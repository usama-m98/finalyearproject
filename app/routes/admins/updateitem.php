<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/updateitem', function (Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $product_image = fileImagesSet();

    moveImageFile($product_image['tmp_name'], $product_image['name']);
    $cleaned = cleanProductData($app, $product_image, $tainted);
    updateProduct($app, $cleaned);


    $_SESSION['updated'] = true;
    setUpdated();

    return $response->withHeader('Location', 'productslist');

});


function updateProduct($app, $cleaned_data)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->updateItem();

    $parameters = [
        ':product_name' => $cleaned_data['product_name'],
        ':product_type' => $cleaned_data['type'],
        ':product_description' => $cleaned_data['description'],
        ':product_stock' => $cleaned_data['stock'],
        ':product_price' => $cleaned_data['price'],
        ':image' => $cleaned_data['product_image'],
        ':product_id' => $cleaned_data['product_id']
    ];

    $database_wrapper->safeQuery($query, $parameters);
}

function setUpdated()
{
    if (isset($_SESSION['updated']))
    {
        return $_SESSION['updated'];
    }
}