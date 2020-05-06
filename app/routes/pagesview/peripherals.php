<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/peripherals', function (Request $request, Response $response) use ($app) {
    $products = getStoredProducts($app);
    $html_output = $this->view->render($response,
        'peripheral.html.twig',
        [
            'page_title' => 'Peripherals',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'login' => 'login',
            'signup' => 'signup',
            'products' => $products,
            'action' => 'shoppingcart'
        ]);

    processOutput($app, $html_output);

    return $html_output;

})->setName('peripherals');