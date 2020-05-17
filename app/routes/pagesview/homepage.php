<?php

use \FinalYear\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function(Request $request, Response $response) use ($app)
{
    $slideshow = array(APP_URL . '/media/homepage/gamingpcbundle.jpg', APP_URL . '/media/homepage/getyourownsetup.jpg');
    $amd = APP_URL . '/media/homepage/AMD.jpg';
    $intel = APP_URL . '/media/homepage/Intel.jpg';

    return $this->view->render($response,
        'homepage.html.twig',
        [
            'page_title' => 'Homepage',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'login' => 'login',
            'signup' => 'signup',
            'slideshow' => $slideshow,
            'intel' => $intel,
            'amd' => $amd
        ]);
})->setName('homepage');


