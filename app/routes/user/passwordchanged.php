<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/passwordchanged', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $auth_info = getAuthInfo($app, $_SESSION['user']);
    $is_password_same = isPasswordTheSame($tainted);
    if($is_password_same)
    {
        $hashed_password = hash_password($app, $tainted['edit-password']);
        $update_password = updatePasswordInDatabase($app, $hashed_password, $auth_info);

        return $response->withRedirect('personaldetails');
    }else{
        return $response->withRedirect('editpassword');
    }
});

function isPasswordTheSame($passwords)
{
    $is_password_same = false;
    if($passwords['edit-password'] === $passwords['confirm-password'])
    {
        $is_password_same = true;
    }

    return $is_password_same;
}

function updatePasswordInDatabase($app, $password, $auth)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->updatePassword();
    $user_id = $auth['user_id'];

    $parameters = [
        ':password' => $password,
        ':user_id' => $user_id
    ];

    $result = $database_wrapper->safeQuery($query, $parameters);

    return $result;
}