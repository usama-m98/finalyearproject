<?php

use \FinalYear\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/changeslideshow', function(Request $request, Response $response) use ($app)
{
    $html_output = $this->view->render($response,
        'changeslideshow.html.twig',
        [
            'page_title' => 'Change Slideshow',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'Change Slideshow',
        ]);

    processOutput($app, $html_output);

    return $html_output;

})->setName('changeslideshow');