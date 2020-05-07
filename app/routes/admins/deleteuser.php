<?php

use \FinalYear\User;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/deleteuser', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $clean_id = cleanInteger($app, $tainted);

    removeUsers($app, $clean_id);
    $html_output = $this->view->render($response,
        'result.html.twig',
        [
            'page_title' => 'Personal Details',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
        ]);

    processOutput($app, $html_output);

    return $html_output;
});

function removeUsers($app, $users)
{
    $database = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database->setDatabaseConnectionSettings($database_connection_settings);
    $database->makeDatabaseConnection();

    $query = $sql_queries->deleteUser();

    foreach($users as $user)
    {
        $parameter = [
            ':user_id' => $user
        ];

        $database->safeQuery($query, $parameter);
    }
}
