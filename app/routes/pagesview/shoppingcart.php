<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/shoppingcart', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned = cleanInteger($app, $tainted);
    $stored_products = getStoredProducts($app);
    $product = getProduct($stored_products, $cleaned['product_id']);
    storeCartValues($app, $product, $cleaned['quantity']);


    return $response->withRedirect($_SERVER['HTTP_REFERER']);

});

function cleanInteger($app, $tainted)
{
    $validator = $app->getContainer()->get('validator');
    $not_clean = $tainted;
    $clean_integer = null;
    if(is_array($not_clean))
    {
        foreach ($not_clean as $key => $value)
        {
            $clean_integer[$key] = $validator->sanitiseNumber($value);
        }
    }else{
        $clean_integer = $validator->sanitiseNumber($not_clean);
    }

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
            if($quantity < $product_details['stock'])
            {
                $cart->setProductValues($_SESSION['cart'][$index], $quantity);
                $cart->incrementQuantity();
                $cart->setSessionValues();
            }else{
                $_SESSION['stock_error'] = "Cannot add item to cart, not enough of this item is in stock";
            }
        }else{
            $cart->setProductValues($product_details, $quantity);
            $cart->setSessionValues($product_details['product_id']);
        }
    }else{
        $cart->setProductValues($product_details, $quantity);
        $cart->setSessionValues($product_details['product_id']);
        $cart->setSession();
    }

}

function getProduct($products, $product_to_get)
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