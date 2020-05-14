<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/emailchanged', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned_email = validateEmail($app, $tainted);

    var_dump($cleaned_email);
    $auth_info = getAuthInfo($app, $_SESSION['user']);
    updateEmailInDatabase($app, $cleaned_email, $auth_info);

    return $response->withRedirect('personaldetails');
});

function validateEmail($app, $tainted)
{
    $validator = $app->getContainer()->get('validator');
    $email = $tainted['edit-email'];

    $cleaned_email = $validator->sanitiseEmail($email);

    return $cleaned_email;
}

function updateEmailInDatabase($app, $cleaned_email, $auth)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->updateEmail();
    $user_id = $auth['user_id'];

    $parameters = [
        ':email' => $cleaned_email,
        ':user_id' => $user_id
    ];

    $result = $database_wrapper->safeQuery($query, $parameters);

    return $result;
}