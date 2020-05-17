<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/usernamechanged', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned_username = validateUsername($app, $tainted);
    $auth_info = getAuthInfo($app, $_SESSION['user']);
    $update_username = updateUsernameInDatabase($app, $cleaned_username, $auth_info);


    return $response->withRedirect('personaldetails');
});

function validateUsername($app, $tainted)
{
    $validator = $app->getContainer()->get('validator');
    $username = $tainted['edit-username'];

    $cleaned_username = $validator->sanitiseString($username);

    return $cleaned_username;
}

function updateUsernameInDatabase($app, $cleaned_username, $auth)
{
    $database_wrapper = $app->getContainer()->get('databaseConnection');
    $sql_queries = $app->getContainer()->get('dbQueries');

    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->updateUsername();
    $user_id = $auth['user_id'];

    $parameters = [
        ':username' => $cleaned_username,
        ':user_id' => $user_id
    ];

    $database_wrapper->query($query, $parameters);

    $new_username = switchSessionUser($cleaned_username);

    return $new_username;

}

function switchSessionUser($username)
{
    $_SESSION['user'] = $username;
    return $username;
}
