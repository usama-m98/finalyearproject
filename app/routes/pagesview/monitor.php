<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/monitor', function(Request $request, Response $response) use ($app)
{
    $products = getStoredProducts($app);
    if(isset($_SESSION['stock_error']))
    {
        echo "<script>alert('Cannot add anymore to cart not enough in stock')</script>";
    }

    unset($_SESSION['stock_error']);

    return $this->view->render($response,
        'monitors.html.twig',
        [
            'page_title' => 'Monitors',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'login' => 'login',
            'signup' => 'signup',
            'products' => $products,
            'action' => 'shoppingcart'
        ]);

})->setName('monitor');