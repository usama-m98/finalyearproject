<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/signup', function (Request $request, Response $response) use ($app)
{

    $html_ouput = $this->view->render($response,
        'signup.html.twig',
        [
            'page_title' => 'Signup Form',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'page_heading' => 'Sign up',
            'action' => 'registered',
        ]);

    processOutput($app, $html_ouput);

    return $html_ouput;

})->setName('signup');