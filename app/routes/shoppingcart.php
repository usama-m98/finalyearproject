<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/shoppingcart', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned = cleanInteger($app, $tainted);
    $stored_products = getStoredProducts($app);
    $product = getCartProduct($stored_products, $cleaned['product_id']);
    $session = storeCartValues($app, $product, $cleaned['quantity']);


    $html_output = $this->view->render($response,
        'result.html.twig',
        [
            'page_title' => 'Personal Details',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
        ]);

    processOutput($app, $html_output);

    return $html_output;

});

function cleanInteger($app, $tainted)
{
    $validator = $app->getContainer()->get('validator');

    $clean_integer['product_id'] = $validator->sanitiseNumber($tainted['product_id']);
    $clean_integer['quantity'] = $validator->sanitiseNumber($tainted['quantity']);

    return $clean_integer;
}

function storeCartValues($app, $product_details, $quantity)
{
    $cart = $app->getContainer()->get('cart');
    if(isset($_SESSION['cart']))
    {
        if(isset($_SESSION['cart'][$product_details['product_id']]))
        {
            $index = $product_details['product_id'];
            $quantity = $_SESSION['cart'][$index]['quantity'];
            $cart->setProductValues($_SESSION['cart'][$index], $quantity);
            $cart->incrementQuantity();
            $cart->setSessionValues();
        }else{
            $cart->setProductValues($product_details, $quantity);
            $cart->setSessionValues($product_details['product_id']);
        }
    }else{
        $cart->setProductValues($product_details, $quantity);
        $cart->setSessionValues($product_details['product_id']);
        $cart->setSession();
    }

    var_dump($cart->getSession());
}

function getCartProduct($products, $product_to_get)
{

    $product_details = false;
    foreach($products as $value)
    {
        if($value['product_id'] === $product_to_get)
        {
            $product_details = $value;
        }
    }

    return $product_details;
}