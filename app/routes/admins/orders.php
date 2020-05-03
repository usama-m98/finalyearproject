<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/orders', function (Request $request, Response $response) use ($app)
{
    if(isset($_SESSION['user'])){
        if ($_SESSION['role'] == 'Root') {
            $all_orders = getAllOrderData($app);

            $html_output = $this->view->render($response,
                'orders.html.twig',
                [
                    'page_title' => 'Assign Build',
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'js_path' => JS_PATH,
                    'orders' => $all_orders,
                    'action' => 'orderoption'
                ]);

            processOutput($app, $html_output);

            return $html_output;
        }else{
            return $response->withRedirect(LANDING_PAGE);
        }
    }
})->setName('orders');

function getAllOrderData($app)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrieveAllOrderData();

    $database_wrapper->safeQuery($query);
    $result = $database_wrapper->safeFetchAll();

    return $result;
}
