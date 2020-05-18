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

function cleanString($app, $tainted)
{
    $validator = $app->getContainer()->get('validator');
    $not_clean = $tainted;
    $clean_string = null;
    if(is_array($not_clean))
    {
        foreach ($not_clean as $key => $value)
        {
            $clean_string[$key] = $validator->sanitiseString($value);
        }
    }else{
        $clean_string = $validator->sanitiseString($not_clean);
    }

    return $clean_string;
}

function getSearchQuery($app, $search)
{
    $database_wrapper = $app->getContainer()->get('databaseConnection');
    $sql_queries = $app->getContainer()->get('dbQueries');

    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->searchQuery();

    $parameters = [
        ':search' => '%' .$search . '%'
    ];

    $database_wrapper->query($query, $parameters);

    $result = $database_wrapper->safeFetchAll();

    return $result;
}

