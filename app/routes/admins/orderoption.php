<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/orderoption', function (Request $request, Response $response) use ($app)
{
    $parsed_body = $request->getParsedBody();
    $clean_order_id = cleanInteger($app, $parsed_body['orderID']);
    $order_status = orderAction($parsed_body['option']);
    implementOrderStatus($app, $clean_order_id, $order_status);

   return $response->withHeader('Location', 'orders');
});

function orderAction($param)
{
    $order_status = '';
    if($param === 'Set-Processed')
    {
        $order_status = 'Processing';
    }elseif ($param === 'Building') {
        $order_status = 'Building';
    }elseif ($param === 'Dispatch') {
        $order_status = 'Dispatched';
    }elseif ($param === 'Cancel-Order')
    {
        $order_status = 'Cancelled';
    }else{
        die();
    }

    return $order_status;
}

function implementOrderStatus($app, $order_id, $order_status)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();
    $query = $sql_queries->updateCancelOrder();


    $parameter = [
        ":order_status" => $order_status,
        ":order_id_value" => $order_id
    ];

    $database_wrapper->safeQuery($query, $parameter);

}