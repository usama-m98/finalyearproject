<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/youraccount', function (Request $request, Response $response) use ($app)
{

    return $this->view->render($response,
        'youraccount.html.twig',
        [
            'page_title' => 'Your Account',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'Account Homepage',
        ]);
})->setName('youraccount');