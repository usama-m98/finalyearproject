<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/productslist', function(Request $request, Response $response) use ($app)
{
    if(isset($_SESSION['user'])) {
        if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Root') {
            $products = getStoredProducts($app);

            if(isset($_SESSION['removed_item']) && $_SESSION['removed_item'] == true)
            {
                echo "<script>alert('Item Removed')</script>";
            }

            $html_output = $this->view->render($response,
                'productlist.html.twig',
                [
                    'page_title' => 'Personal Details',
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'js_path' => JS_PATH,
                    'products' => $products,
                    'action' => 'productaction'
                ]);

            processOutput($app, $html_output);
            unset($_SESSION['removed_item']);
            return $html_output;
        }
    }else{
        return $response->withHeader('Location', LANDING_PAGE);
    }

})->setName('productslist');