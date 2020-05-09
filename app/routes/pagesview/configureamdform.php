<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/configureamdform', function(Request $request, Response $response) use ($app)
{
    $products = getStoredProducts($app);

    return $this->view->render($response,
        'configureamdform.html.twig',
        [
            'page_title' => 'Configure Form',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'login' => 'login',
            'signup' => 'signup',
            'heading' => 'Build Your Pc',
            'action' => 'processconfiguration',
            'products' => $products,
        ]);

})->setName('configureamdform');