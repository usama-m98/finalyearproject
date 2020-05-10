<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/cartcheckout', function(Request $request, Response $response) use ($app) {
    if (isset($_SESSION['user']) && isset($_SESSION['cart'])) {

        $cart = $_SESSION['cart'];
        $auth_info = getAuthInfo($app, $_SESSION['user']);
        $personal_details = getUserPersonalInfo($app, $auth_info);

        storeOrderDetails($app, $personal_details['customer_id'], $cart);

        $message = 'Your order has been placed';

        unset($_SESSION['cart']);
        return $this->view->render($response,
            'checkoutview.html.twig',
            [
                'page_title' => 'Configure Form',
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'js_path' => JS_PATH,
                'heading' => 'Checkout',
                'message' => $message
            ]);

    } else {
        return $response->withRedirect(LANDING_PAGE);
    }
});

function storeOrderDetails($app, $customer_id, $cart)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();
    $stored_products = getStoredProducts($app);

    $date = date('m/d/Y');
    foreach($cart as $item)
    {
        $params = [
            ":date_of_order" => $date,
            ":description" => $item['name'],
            ":total" => $item['price'],
            ":quantity" => $item['quantity'],
            ":assigned" => (int)'1',
            ":status" => 'Processing',
            ":customer_id" => (int)$customer_id
        ];
        $query = $sql_queries->storeOrderData();

        $database_wrapper->safeQuery($query, $params);
    }

    foreach($cart as $item)
    {
        $product = getProduct($stored_products, $item['product_id']);

        $stock = $product['stock'] - $item['quantity'];
        $params = [
            ':quantity' => $stock,
            ':product_id' => $item['product_id']
        ];
        $query = $sql_queries->updateStock();
        $database_wrapper->safeQuery($query, $params);
    }
}