<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/admininterface', function (Request $request, Response $response) use ($app)
{
    if(isset($_SESSION['user'])){
        if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Root')
        {
            $orders = array();
            $orders['Root'] = ordersToBeAssigned($app);
            $auth_info = getAuthInfo($app, $_SESSION['user']);
            $orders['admin'] = getAssignedOrderData($app, $auth_info['user_id']);

            $count['root'] = sizeof($orders['Root']);
            $count['admin'] = sizeof($orders['admin']);


            return $this->view->render($response,
                'admininterface.html.twig',
                [
                    'page_title' => 'admin interface',
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'js_path' => JS_PATH,
                    'page_heading2' => 'Admin Lounge',
                    'add_admin' => 'addadmin',
                    'view_user' => 'viewusers',
                    'view_messages' => 'viewallmessages',
                    'assign_build' => 'assignbuilds',
                    'order_interface' => 'orders',
                    'add_products' => 'addproductsform',
                    'products_list' => 'productslist',
                    'admin_details' => 'personaldetails',
                    'count' => $count
                ]);
        }
    }else{
        return $response->withHeader('Location', LANDING_PAGE);
    }

})->setName('admininterface');