<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/viewallmessages', function(Request $request, Response $response) use ($app)
{
    $stored_messages = getAllMessages($app);


    $html_output = $this->view->render($response,
        'viewmessages.html.twig',
        [
            'page_title' => 'Personal Details',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'messages' => $stored_messages,
            'main_page' => 'admininterface'
        ]);

    processOutput($app, $html_output);

    return $html_output;


})->setName('viewallmessages');

function getAllMessages($app)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrieveAllStoredMessages();

    $database_wrapper->safeQuery($query);
    $result = $database_wrapper->safeFetchAll();

    return $result;

}