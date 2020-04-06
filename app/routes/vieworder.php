<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/vieworder', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned = validateFormInput($app, $tainted);
    $products = getStoredProducts($app);
    $price = getPrice($products, $cleaned);
    $total = getTotal($price);
    order();

    $auth_info = getAuthInfo($app, $_SESSION['user']);
    $personal_details = getUserPersonalInfo($app, $auth_info);
    $action = null;
    $info_state = true;

    if(!$personal_details)
    {
        $info_state = false;
        $action = "checkout";
    }

    $checkout = array();
    if (isset($_SESSION['user']))
    {
        $checkout['state'] = true;
        $checkout['message'] = 'checkout';
        $checkout['action'] = 'checkout';
    }else{
        $checkout['message'] = 'please login first and enter your personal info';
        $checkout['action'] = 'login';
    }

   $html_output = $this->view->render($response,
       'vieworder.html.twig',
       [
           'page_title' => 'Configure Form',
           'css_path' => CSS_PATH,
           'landing_page' => LANDING_PAGE,
           'js_path' => JS_PATH,
           'login' => 'login',
           'signup' => 'signup',
           'heading' => 'Configuration Order Details',
           'products' => $price,
           'total' => $total,
           'state' => $checkout['state'],
           'message' => $checkout['message'],
           'src' => $checkout['action'],
           'info_state' => $info_state,
           'action' => $action,
       ]);

   processOutput($app, $html_output);

   return $html_output;
});

function validateFormInput($app, $tainted)
{
    $validator = $app->getContainer()->get('validator');

    $cleaned['case'] = $validator->sanitiseString($tainted['Cases']);
    $cleaned['processor'] = $validator->sanitiseString($tainted['Intel-processor']);
    $cleaned['motherboard'] = $validator->sanitiseString($tainted['Motherboard']);
    $cleaned['ram'] = $validator->sanitiseString($tainted['RAM']);
    $cleaned['graphics_card'] = $validator->sanitiseString($tainted['Graphics-card']);
    $cleaned['hard_drive'] = $validator->sanitiseString($tainted['Hard-drive']);
    $cleaned['cooling_fan'] = $validator->sanitiseString($tainted['Cooling-fan']);
    $cleaned['power_supply'] = $validator->sanitiseString($tainted['Power-Supply']);

    return $cleaned;
}

function getPrice($products, $order)
{
    $product_price_list = array();
    $order_prices = array();

    foreach($products as $item)
    {
        $product_price_list[$item['name']] = $item['price'];
    }


    foreach ($order as $item)
    {
        if (array_key_exists($item, $product_price_list)){
            $order_prices[$item] = $product_price_list[$item];
        }
    }

    $_SESSION['order'] = $order_prices;
    return $order_prices;
}

function getTotal($prices)
{
    $total = 0;
    foreach ($prices as $price)
    {
        $total += $price;
    }

    return $total;
}


function order()
{
    if (isset($_SESSION['order']))
    {
        return $_SESSION['order'];
    }
}


