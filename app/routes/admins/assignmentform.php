<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/assignmentform', function (Request $request, Response $response) use ($app)
{

    $tainted = $request->getParsedBody();
    $cleaned = cleanInteger($app, $tainted);
    updateOrderDetailsWithReassignment($app, $cleaned);



    return $response->withHeader('Location', 'assignbuilds' . '?success=1');

//    $html_output = $this->view->render($response,
//        'result.html.twig',
//        [
//            'page_title' => 'Personal Details',
//            'css_path' => CSS_PATH,
//            'landing_page' => LANDING_PAGE,
//            'js_path' => JS_PATH,
//        ]);
//
//    processOutput($app, $html_output);
//
//    return $html_output;
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
}

