<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/cart', function(Request $request, Response $response) use ($app)
{
    $cart = null;
    if(isset($_SESSION['cart']))
    {
        $cart= $_SESSION['cart'];
    }

    $this->view->render($response,
        'result.html.twig',
        [
            'page_title' => 'Personal Details',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'cart' => $cart
        ]);

});