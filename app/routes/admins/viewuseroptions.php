<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/viewuseroptions', function (Request $request, Response $response) use ($app)
{
    $tainted= $request->getParsedBody();
    $action= directAction($app, $tainted);
    $filtered = null;

    if ($action === 'reset'){
        if(isset($_SESSION['filtered_user_data']))
        {
            unset($_SESSION['filtered_user_data']);
            $filtered = getUserAccountDetails($app);
        }
    } else{
        $filtered = filterUser($app, $action);
    }
    isFilteredUserDataSet();

    return $response->withRedirect('viewusers');
});

function directAction($app, $action)
{
    $data = '';
    foreach($action as $key => $value)
    {
        if ($key=== 'filter_admin'){
            $data = 'Admin';
        }elseif ($key === 'filter_user'){
            $data = 'Member';
        }elseif ($key === 'reset'){
            $data = 'reset';
        }
    }
    return $data;
}

function filterUser($app, $user)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->filterUserAndRetrieve();

    $parameters = [
        ':role' => $user,
    ];

    $database_wrapper->safeQuery($query, $parameters);
    $_SESSION['filtered_user_data'] = $database_wrapper->safeFetchAll();

}

function isFilteredUserDataSet()
{
    if (isset($_SESSION['filtered_user_data']))
    {
        return $_SESSION['filtered_user_data'];
    }
}
