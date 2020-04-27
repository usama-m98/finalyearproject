<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/checkout', function(Request $request, Response $response) use ($app)
{
    if(isset($_SESSION['user']))
    {
        if(isset($_SESSION['order']))
        {
            $order = $_SESSION['order'];
            $order_details = getOrderStringAndTotal($order);
            $auth_info = getAuthInfo($app, $_SESSION['user']);
            $personal_details = getUserPersonalInfo($app, $auth_info);

            storeOrderDetails($app, $order_details, $personal_details);

            $message = 'Your order has been placed';

            $html_output = $this->view->render($response,
                'checkoutview.html.twig',
                [
                    'page_title' => 'Configure Form',
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'js_path' => JS_PATH,
                    'heading' => 'Checkout',
                    'message' => $message
                ]);

            processOutput($app, $html_output);

            return $html_output;
        }else{
            return $response->withRedirect(LANDING_PAGE);
        }
    }else {
        return $response->withRedirect(LANDING_PAGE);
    }
})->setName('checkout');

function getOrderStringAndTotal($order)
{
    $order_detail= array();
    $order_string = '';
    $order_total = 0;
    foreach ($order as $item => $price){
        $order_string .= $item . " ";
        $order_total += $price;
    }
    $order_detail['order'] = $order_string;
    $order_detail['total'] = $order_total;

    return $order_detail;
}

function storeOrderDetails($app, $order_details, $personal_details){
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $date = date('m/d/Y');
    $params = [
        ":date_of_order" => $date,
        ":description" => $order_details['order'],
        ":total" => $order_details['total'],
        ":address" => $personal_details['address'],
        ":postcode" => $personal_details['postcode'],
        ":city" => $personal_details['city'],
        ":assigned" => (int)'1',
        ":status" => 'Processing',
        ":customer_id" => (int)$personal_details['customer_id']
    ];
    $query = $sql_queries->storeOrderData();


    $database_wrapper->safeQuery($query, $params);

}