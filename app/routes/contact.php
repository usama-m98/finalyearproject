<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/contact', function(Request $request, Response $response) use ($app)
{

    $html_output = $this->view->render($response,
        'contactform.html.twig',
        [
            'page_title' => 'Contact Form',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'login' => 'login',
            'signup' => 'signup',
            'heading' => 'Contact Us',
            'action' => 'contactform'
        ]);

    processOutput($app, $html_output);

    return $html_output;
});