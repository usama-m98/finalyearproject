<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/processconfiguration', function(Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $cleaned = validateFormInput($app, $tainted);
    $products = getStoredProducts($app);
    $price = getPrice($products, $cleaned);
    order();

    return $response->withRedirect('vieworder');
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
        $product_price_list[$item['name']] = $item['price'];}


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

