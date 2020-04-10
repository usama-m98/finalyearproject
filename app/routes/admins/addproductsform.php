<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/addproductsform', function (Request $request, Response $response) use ($app)
{
    if(isset($_SESSION['user'])) {
        if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Root') {
            $html_output = $this->view->render($response,
                'addproductsform.html.twig',
                [
                    'page_title' => 'Add Items',
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'js_path' => JS_PATH,
                    'page_heading2' => 'Add Items',

                ]);

            processOutput($app, $html_output);

            return $html_output;
        }
    }
})->setName('addproductsform');