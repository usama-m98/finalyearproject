<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/cartitemoption', function(Request $request, Response $response) use ($app)
{
   $tainted = $request->getParsedBody();
   $cart_option = validateCartOption($tainted['cart']);
   $clean_id = cleanInteger($app, $tainted['cart-index']);

    $stored_products = getStoredProducts($app);
    $product = getProduct($stored_products, $clean_id);

    implementCartOption($app, $cart_option, $clean_id, $product['stock']);

   return $response->withHeader('Location', 'cart');

});

function validateCartOption($options)
{
    $cart_option = '';
    if ($options === 'Increase-Quantity')
    {
        $cart_option = 'increment';
    }elseif ($options === 'Decrease-Quantity')
    {
        $cart_option = 'decrement';
    }elseif ($options === 'Delete')
    {
        $cart_option = 'remove';
    }else{
        die();
    }

    return $cart_option;
}

function implementCartOption($app, $option, $index, $stock)
{
    $cart = $app->getContainer()->get('cart');
    $quantity = $_SESSION['cart'][$index]['quantity'];

    if(array_key_exists($index, $_SESSION['cart']))
    {
        if($option === 'remove')
        {
            $cart->removeSessionCartValue($index);
        }elseif ($option === 'increment'){
            if($quantity < $stock)
            {
                $cart->setProductValues($_SESSION['cart'][$index], $quantity);
                $cart->incrementQuantity();
                $cart->setSessionValues();
            }else{
                $_SESSION['stock_error'] = 'Not enough in stock';
            }
        }elseif ($option === 'decrement'){
            $cart->setProductValues($_SESSION['cart'][$index], $quantity);
            $cart->decrementQuantity();
            $cart->setSessionValues();
        }
    }else{
        die();
    }

}
