<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/checkout', function(Request $request, Response $response) use ($app)
{
    $order = $_SESSION['order'];
    $order_details = getOrderStringAndTotal($order);
    var_dump($order_details);
    $tainted = $request->getParsedBody();
    var_dump($tainted);
    $cleaned_params = cleanPersonalInfoParams($app, $tainted);
    $auth_info = getAuthInfo($app, $_SESSION['user']);
    $store_personal_info = storeUserPersonalInfo($app, $cleaned_params, $auth_info);

    $html_output = $this->view->render($response,
        'checkoutview.html.twig',
        [
            'page_title' => 'Configure Form',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'heading' => 'Checkout',
        ]);

    processOutput($app, $html_output);

    return $html_output;
})->setName('checkout');

function getOrderStringAndTotal($order)
{
    $order_detail= array();
    $order_string = '';
    $order_total = 0;
    foreach ($order as $item => $price){
        $order_string .= $item . "\n";
        $order_total += $price;
    }
    $order_detail['order'] = $order_string;
    $order_detail['total'] = $order_total;

    return $order_detail;
}

function storeOrderDetails($app, $order_details){
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $parameters = [

    ];
}