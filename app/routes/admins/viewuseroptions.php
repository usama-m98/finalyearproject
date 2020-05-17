<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/viewuseroptions', function (Request $request, Response $response) use ($app)
{
    $body= $request->getParsedBody();
    $action= directAction($app, $body);
    $filtered = null;

    if ($action === 'reset'){
        if(isset($_SESSION['filtered_user_data']))
        {
            unset($_SESSION['filtered_user_data']);
            $filtered = getUserAccountDetails($app);
        }
    } else{
        $_SESSION['filtered_user_data'] = filterUser($app, $action);
        $filtered = $_SESSION['filtered_user_data'];
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
        }else{
            die();
        }
    }
    return $data;
}

function filterUser($app, $user)
{
    $database_wrapper = $app->getContainer()->get('databaseConnection');
    $sql_queries = $app->getContainer()->get('dbQueries');

    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->filterUserAndRetrieve();

    $parameters = [
        ':role' => $user,
    ];

    $database_wrapper->query($query, $parameters);
    return $database_wrapper->safeFetchAll();

}

function isFilteredUserDataSet()
{
    if (isset($_SESSION['filtered_user_data']))
    {
        return $_SESSION['filtered_user_data'];
    }
}
