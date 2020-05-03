<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/assignmentform', function (Request $request, Response $response) use ($app)
{

    $tainted = $request->getParsedBody();
    $cleaned = cleanInteger($app, $tainted);
    updateOrderDetailsWithReassignment($app, $cleaned);

    if (isset($_SESSION['reassigned']))
    {
        return $_SESSION['reassigned'];
    }


    return $response->withHeader('Location', 'assignbuilds');

});

function updateOrderDetailsWithReassignment($app, $parameter)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->reassignAdminAssignment();

    $params = [
        ':assignment_value' => $parameter['admin-id'],
        ':order_id_value' => $parameter['order-id'],
    ];

    $database_wrapper->safeQuery($query, $params);
    $_SESSION['reassigned'] = true;
}

