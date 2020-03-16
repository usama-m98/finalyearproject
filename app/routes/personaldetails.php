<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/personaldetails', function(Request $request, Response $response) use ($app)
{

    $auth_info = getAuthInfo($app, $_SESSION['user']);
    $username = $auth_info['username'];
    $email = $auth_info['email'];

    $html_output = $this->view->render($response,
        'personaldetails.html.twig',
        [
            'page_title' => 'Personal Details',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'User Account Information',
            'page_heading3' => 'Personal Details',
            'username' => $username,
            'email' => $email
        ]);

    processOutput($app, $html_output);

    return $html_output;
})->setName('personaldetails');