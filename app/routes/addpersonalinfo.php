<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/addpersonalinfo', function(Request $request, Response $response) use ($app)
{

    $html_output = $this->view->render($response,
        'addpersonalinfo.html.twig',
        [
            'page_title' => 'Enter Personal Info',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'Enter Personal Info',
            'action' => 'addpersonalinfoform',
        ]);

    processOutput($app, $html_output);

    return $html_output;
});