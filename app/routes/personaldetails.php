<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/personaldetails', function(Request $request, Response $response) use ($app)
{

    $auth_info = getAuthInfo($app, $_SESSION['user']);
    $username = $auth_info['username'];
    $email = $auth_info['email'];
    $personal_details = getUserPersonalInfo($app, $auth_info);
    $personal_info_exists = false;
    sessionAddress();
    if ($personal_details)
    {
        $personal_info_exists = true;
        $_SESSION['address'] = $personal_details;
    }

    $html_output = $this->view->render($response,
        'personaldetails.html.twig',
        [
            'page_title' => 'Personal Details',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'User Account Information',
            'page_heading3' => 'Personal Details',
            'username' => $username,
            'email' => $email,
            'personal_info_exists' => $personal_info_exists,
            'personal_info' => $personal_details,
        ]);

    processOutput($app, $html_output);

    return $html_output;
})->setName('personaldetails');

function getUserPersonalInfo($app, $auth_info)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrievePersonalDetails();
    $user_id = $auth_info['user_id'];

    $parameters = [
        ":user_id" => $user_id
    ];

    $database_wrapper->safeQuery($query, $parameters);
    $result[0] = $database_wrapper->safeFetchArray();
    return $result[0];
}

function sessionAddress()
{
    if (isset($_SESSION['address']))
    {
        return $_SESSION['address'];
    }

}
