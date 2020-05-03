<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/yourorder', function(Request $request, Response $response) use ($app)
{

    if(isset($_SESSION['user'])) {

        if (isset($_SESSION['message_store']) && $_SESSION['message_store'] == true) {
            echo "<script>alert('Message sent')</script>";
        }
        $auth_info = getAuthInfo($app, $_SESSION['user']);
        $customer_details = getUserPersonalInfo($app, $auth_info);
        $order_detail_history = getOrderDetails($app, $customer_details['customer_id']);

        $html_output = $this->view->render($response,
            'yourorder.html.twig',
            [
                'page_title' => 'Configure Form',
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'js_path' => JS_PATH,
                'heading' => 'Order Details',
                'orders' => $order_detail_history,
            ]);

        processOutput($app, $html_output);
        unset($_SESSION['message_store']);
        return $html_output;
    }else{
        return $response->withRedirect(LANDING_PAGE);
    }
})->setName('yourorder');

function getOrderDetails($app, $customer_id)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrieveOrderData();
    $params = [':customer_id' => $customer_id];

    $database_wrapper->safeQuery($query, $params);
    $order_history = $database_wrapper->safeFetchAll();

    var_dump($order_history);
    return $order_history;
}