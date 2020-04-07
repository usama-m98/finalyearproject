<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/viewusers', function (Request $request, Response $response) use ($app)
{
    $user_data = getUserAccountDetails($app);
    var_dump($user_data);
    $html_output = $this->view->render($response,
        'viewusers.html.twig',
        [
            'page_title' => 'View users',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'All Users',
            'users' =>$user_data,
            'action' => 'viewuseroptions'
        ]);

    processOutput($app, $html_output);

    return $html_output;
})->setName('viewusers');

function getUserAccountDetails($app)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrieveAllUserData();

    $database_wrapper->safeQuery($query);
    $result =$database_wrapper->safeFetchAll();

    return $result;
}