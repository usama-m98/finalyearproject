<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/cart', function(Request $request, Response $response) use ($app)
{
    $cart = null;
    $total = 0;


    if(isset($_SESSION['cart']))
    {
        $cart= $_SESSION['cart'];
        foreach($cart as $key => $value)
        {
            $total += $value['total'];
        }
    }

    if(isset($_SESSION['stock_error']))
    {
        echo "<script>alert('Cannot Increase quantity not enough in stock')</script>";

    }

    unset($_SESSION['stock_error']);

    return $this->view->render($response,
        'cart.html.twig',
        [
            'page_title' => 'Cart',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'heading' => 'Cart',
            'cart' => $cart,
            'total' => $total,
            'action' => 'cartitemoption'
        ]);

});