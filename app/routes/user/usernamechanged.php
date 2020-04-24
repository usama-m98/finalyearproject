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

function validateUsername($app, $tainted)
{
    $validator = $app->getContainer()->get('validator');
    $username = $tainted['edit-username'];

    $cleaned_username = $validator->sanitiseString($username);

    return $cleaned_username;
}

function updateUsernameInDatabase($app, $cleaned_username, $auth)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->updateUsername();
    $user_id = $auth['user_id'];

    $parameters = [
        ':username' => $cleaned_username,
        ':user_id' => $user_id
    ];

    $database_wrapper->safeQuery($query, $parameters);

    $new_username = switchSessionUser($cleaned_username);

    return $new_username;

}

function switchSessionUser($username)
{
    $_SESSION['user'] = $username;
    return $username;
}
