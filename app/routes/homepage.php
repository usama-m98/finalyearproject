<?php

use \FinalYear\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app)
{
    $_SESSION['slideshow'] = array();
    $_SESSION['slideshow'][0] = APP_URL . '/media/homepage/gamingpcbundle.jpg';
    $_SESSION['slideshow'][1] = APP_URL . '/media/homepage/getyourownsetup.jpg';
    setSlideshow();

    $html_output = $this->view->render($response,
        'homepage.html.twig',
        [
            'page_title' => 'Homepage',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'login' => 'login',
            'signup' => 'signup',
            'slideshow' => $_SESSION['slideshow']
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

function setSlideshow()
{
    if(isset($_SESSION['slideshow']))
    {
        return $_SESSION['slideshow'];
    }
}