<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/vieworder', function(Request $request, Response $response) use ($app)
{

    $order = $_SESSION['order'];
    $total = getTotal($order);
    $personal_details = $_SESSION['customer_details'];
    $action = '';
    $info_state = true;

    if(!$personal_details)
    {
        $info_state = false;
        $action = 'addpersonalinfoform';
    }

    $checkout = array();
    if (isset($_SESSION['user']))
    {
        $checkout['message'] = 'checkout';
        $checkout['action'] = 'checkout';
    }else{
        $checkout['message'] = 'please login first and enter your personal info';
        $checkout['action'] = 'login';
    }

   $html_output = $this->view->render($response,
       'vieworder.html.twig',
       [
           'page_title' => 'Configure Form',
           'css_path' => CSS_PATH,
           'landing_page' => LANDING_PAGE,
           'js_path' => JS_PATH,
           'login' => 'login',
           'signup' => 'signup',
           'heading' => 'Configuration Order Details',
           'products' => $order,
           'total' => $total,
           'message' => $checkout['message'],
           'src' => $checkout['action'],
           'info_state' => $info_state,
           'action' => $action,
       ]);

   processOutput($app, $html_output);

   return $html_output;
});

function getTotal($prices)
{
    $total = 0;
    foreach ($prices as $price)
    {
        $total += $price['price'];
    }

    return $total;
}

