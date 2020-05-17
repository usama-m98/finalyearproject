<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/configureintelform', function(Request $request, Response $response) use ($app)
{
    $products = getStoredProducts($app);

    return $this->view->render($response,
        'configureintelform.html.twig',
        [
            'page_title' => 'Configure Form',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'login' => 'login',
            'signup' => 'signup',
            'heading' => 'Build Your Pc',
            'action' => 'processconfiguration',
            'products' => $products,
        ]);

})->setName('configureintelform');

function getStoredProducts($app){
    $database_wrapper = $app->getContainer()->get('databaseConnection');
    $sql_queries = $app->getContainer()->get('dbQueries');

    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrieveProducts();
    $database_wrapper->query($query);
    $result =$database_wrapper->safeFetchAll();

    return $result;
}