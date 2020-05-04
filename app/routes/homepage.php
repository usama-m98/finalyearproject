<?php

use \FinalYear\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app)
{
    $slideshow = array(APP_URL . '/media/homepage/gamingpcbundle.jpg', APP_URL . '/media/homepage/getyourownsetup.jpg');

    $html_output = $this->view->render($response,
        'homepage.html.twig',
        [
            'page_title' => 'Homepage',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'login' => 'login',
            'signup' => 'signup',
            'slideshow' => $slideshow
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
