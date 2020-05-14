<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/addadmin', function (Request $request, Response $response) use ($app)
{

    if(isset($_SESSION['user'])){
        if ($_SESSION['role'] == 'Root')
        {
            return $this->view->render($response,
                'addadmin.html.twig',
                [
                    'page_title' => 'add admin',
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'js_path' => JS_PATH,
                    'page_heading2' => 'Add Admin',
                    'action' => 'addadminuser',
                    'main_page' => 'admininterface'
                ]);
        }
    }else{
        return $response->withHeader('Location', LANDING_PAGE);
    }

})->setName('addadmin');