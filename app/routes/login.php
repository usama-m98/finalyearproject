<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/login', function(Request $request, Response $response) use ($app)
{
    $html_output = $this->view->render($response,
        'loginform.html.twig',
        [
            'page_title' => 'Login Form',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'heading' => 'Login',
            'action' => 'signin',
        ]);

    processOutput($app, $html_output);

    return $html_output;
})->setName('login');