<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/editemail', function(Request $request, Response $response) use ($app)
{

    return $this->view->render($response,
        'editemail.html.twig',
        [
            'page_title' => 'Edit email',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'Edit email',
            'action' => 'emailchanged',
        ]);
});


