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
        };

    }else{
        $cart = "No items in Cart";
    }

    $checkout = array();
    $info_state = true;
    if(isset($_SESSION['user']))
    {
        $auth_info = getAuthInfo($app, $_SESSION['user']);
        $personal_details = getUserPersonalInfo($app, $auth_info);
        if(!$personal_details)
        {
            $info_state = false;
            $checkout['message'] = '';
            $checkout['action'] = 'addpersonalinfoform';
        }else{
            $checkout['message'] = 'checkout';
            $checkout['action'] = 'cartcheckout';
        }
    }else{
        $checkout['action'] = 'login';
        $checkout['message'] = 'please login first and enter your personal info';
    }

    if(isset($_SESSION['stock_error']))
    {
        echo "<script>alert('Cannot Increase quantity not enough in stock')</script>";

    }

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
            'action' => 'cartitemoption',
            'info_state' => $info_state,
            'checkout' => $checkout
        ]);

});