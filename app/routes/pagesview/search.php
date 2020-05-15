<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/search', function(Request $request, Response $response) use ($app)
{
    $tainted = '';
    if (isset($_GET['search']))
    {
        $tainted= $_GET['search'];
    }

    $clean_string = cleanString($app, $tainted);
    $products = getSearchQuery($app, $clean_string);
    return $this->view->render($response,
        'search.html.twig',
        [
            'page_title' => 'Personal Details',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'login' => 'login',
            'signup' => 'signup',
            'products' => $products
        ]);
});

function getSearchQuery($app, $search)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->searchQuery();

    $parameters = [
        ':search' => '%' .$search . '%'
    ];

    $database_wrapper->safeQuery($query, $parameters);

    $result = $database_wrapper->safeFetchAll();

    return $result;
}

