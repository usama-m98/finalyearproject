<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/assignmentform', function (Request $request, Response $response) use ($app)
{

    $tainted = $request->getParsedBody();
    $cleaned = cleanInteger($app, $tainted);
    updateOrderDetailsWithReassignment($app, $cleaned);

    return $response->withHeader('Location', 'assignbuilds');

});

function updateOrderDetailsWithReassignment($app, $parameter)
{
    $database_wrapper = $app->getContainer()->get('databaseConnection');
    $sql_queries = $app->getContainer()->get('dbQueries');

    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->reassignAdminAssignment();

    $params = [
        ':assignment_value' => $parameter['admin-id'],
        ':order_id_value' => $parameter['order-id'],
    ];

    $database_wrapper->query($query, $params);
    $_SESSION['reassigned'] = true;
}

