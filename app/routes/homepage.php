<?php

use \FinalYear\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app)
{

    $html_output = $this->view->render($response,
        'homepage.html.twig',
        [
            'page_title' => 'Homepage',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'homepage_banner' => HOMEPAGE_BANNER,
            'login' => 'login',
            'signup' => 'signup',
        ]);

    processOutput($app, $html_output);

    return $html_output;

})->setName('homepage');

function processOutput($app, $html_output)
{
    $process_output = $app->getContainer()->get('processOutput');
    $html_output = $process_output->processOutput($html_output);
    return $html_output;
}