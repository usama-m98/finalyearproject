<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/contactform', function(Request $request, Response $response) use ($app)
{

    $tainted = $request->getParsedBody();
    $clean_msg = cleanString($app, $tainted['message']);
    $clean_order_id = cleanInteger($app, $tainted['order_id']);
    $auth_info = getAuthInfo($app, $_SESSION['user']);
    storeMessageInDatabase($app, $clean_msg, $clean_order_id, $auth_info['user_id']);
    messageStoreSet();

    return $response->withHeader('Location', 'yourorder');

});

function cleanString($app, $string)
{
    $validator = $app->getContainer()->get('validator');
    $not_clean = $string;
    $cleaned = null;
    if(is_array($string))
    {
        foreach ($not_clean as $key => $value)
        {
            $cleaned[$key] = $validator->sanitiseString($value);
        }
    }else{
        $cleaned = $validator->sanitiseString($not_clean);
    }

    return $cleaned;
}

function storeMessageInDatabase($app, $message, $order_id, $user_id)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->storeMessage();

    $date = date('m/d/Y');
    $params = [
        ':message_string' => $message,
        ':date' => $date,
        ':order_id_value' => $order_id,
        ':user_id_value' => $user_id,
    ];

    $database_wrapper->safeQuery($query, $params);
    $_SESSION['message_store'] = true;
}

function messageStoreSet()
{
    if(isset($_SESSION['message_store']))
    {
        return $_SESSION['message_store'];
    }
}