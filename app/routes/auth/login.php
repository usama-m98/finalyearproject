<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/login', function(Request $request, Response $response) use ($app)
{
    $error_message = '';
    if (isset($_SESSION['failed_message']))
    {
        $error_message = $_SESSION['failed_message'];
    }

    unset($_SESSION['failed_message']);
    return $this->view->render($response,
        'loginform.html.twig',
        [
            'page_title' => 'Login Form',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'heading' => 'Login',
            'action' => 'signin',
            'message' => $error_message
        ]);
})->setName('login');
