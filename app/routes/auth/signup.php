<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/signup', function (Request $request, Response $response) use ($app)
{
    $sign_up_failure_message = '';
    if(isset($_SESSION['failed_message']))
    {
        $sign_up_failure_message = $_SESSION['failed_message'];
    }

    unset($_SESSION['failed_message']);
    return $this->view->render($response,
        'signup.html.twig',
        [
            'page_title' => 'Signup Form',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'Sign up',
            'action' => 'registered',
            'message' => $sign_up_failure_message
        ]);
})->setName('signup');