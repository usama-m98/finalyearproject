<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/configureintelform', function(Request $request, Response $response) use ($app)
{
    $products = getStoredProducts($app);

    $html_output = $this->view->render($response,
        'configureintelform.html.twig',
        [
            'page_title' => 'Configure Form',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'heading' => 'Build Your Pc',
            'action' => 'ViewOrder',
            'products' => $products,
        ]);

    processOutput($app, $html_output);

    return $html_output;
})->setName('configureintelform');

function getStoredProducts($app){
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrieveIntelProcessor();
    $database_wrapper->safeQuery($query);
    $result =$database_wrapper->safeFetchAll();

    return $result;
}