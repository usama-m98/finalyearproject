<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/admininterface', function (Request $request, Response $response) use ($app)
{
    if(isset($_SESSION['user'])){
        if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Root')
        {
            $html_output = $this->view->render($response,
                'admininterface.html.twig',
                [
                    'page_title' => 'admin interface',
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'js_path' => JS_PATH,
                    'page_heading2' => 'Admin Lounge',
                    'add_admin' => 'addadmin',
                    'view_user' => 'viewusers',
                    'assign_build' => 'assignbuilds',
                    'order_interface' => 'orders'
                ]);

            processOutput($app, $html_output);

            return $html_output;
        }
    }else{
        die();
    }

})->setName('admininterface');