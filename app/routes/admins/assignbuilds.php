<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/assignbuilds', function (Request $request, Response $response) use ($app)
{

    if ( isset($_GET['success']) && $_GET['success'] == 1 )
    {
        echo "<script>alert('Assignment Complete')</script>";
    }

    $orders = ordersToBeAssigned($app);
    $count_of_assigned = countOfAssigned($app);
    $admins = filterUser($app, 'Admin');

    $html_output = $this->view->render($response,
        'assignbuilds.html.twig',
        [
            'page_title' => 'Assign Build',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'orders' => $orders,
            'assigned' => $count_of_assigned,
            'action' => 'assignmentform',
            'admins' => $admins
        ]);

    processOutput($app, $html_output);

    return $html_output;
})->setName('assignbuilds');

function ordersToBeAssigned($app)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrieveOrderDataToBeAssigned();

    $database_wrapper->safeQuery($query);
    $result =$database_wrapper->safeFetchAll();

    return $result;
}

function countOfAssigned($app)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->countOfOrdersAssignedToAdmins();

    $database_wrapper->safeQuery($query);
    $result =$database_wrapper->safeFetchAll();

    return $result;
}