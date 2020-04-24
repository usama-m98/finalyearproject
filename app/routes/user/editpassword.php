<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/editpassword', function(Request $request, Response $response) use ($app)
{

    $html_output = $this->view->render($response,
        'editpassword.html.twig',
        [
            'page_title' => 'Edit password',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'Edit password',
            'action' => 'passwordchanged',
        ]);

    processOutput($app, $html_output);

    return $html_output;
});