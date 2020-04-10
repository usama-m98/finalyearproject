<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/addproductsform', function (Request $request, Response $response) use ($app)
{
    $product_types = productTypes();

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
                    'action' => 'addproducts',
                    'types' => $product_types
                ]);

            processOutput($app, $html_output);

            return $html_output;
        }else{
            die();
        }
    }
})->setName('addproductsform');

function productTypes()
{
    $products = [
        "Intel-Motherboard",
        "AMD-Motherboard",
        "Case",
        "RAM",
        "Power-Supply",
        "Cooler",
        "AMD-Processor",
        "Intel-Processor",
        "Storage",
        "Graphics-Card",
        "Laptops",
        "Monitor",
        "Desktops",
        "Peripherals",
        "Other"
    ];

    return $products;
}