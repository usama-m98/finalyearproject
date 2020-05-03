<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/addproducts', function (Request $request, Response $response) use ($app)
{

    $tainted = $request->getParsedBody();
    $product_image = fileImagesSet();
    $isFormEmpty = checkIfFormIsFilled($tainted);

    if ($isFormEmpty){
        productFormSet();
        return $response->withRedirect('addproductsform');
    }else {
        moveImageFile($product_image['tmp_name'], $product_image['name']);
        $cleaned = cleanProductData($app, $product_image, $tainted);
        $stored = storeProducts($app, $cleaned);
        if(isset($_SESSION['add-product-error']))
        {
            unset($_SESSION['add-product-error']);
        }

        return $response->withHeader('Location','productslist');

    }
});

function storeProducts($app, $cleaned_data)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $parameters = [
        ':product_name' => $cleaned_data['product_name'],
        ':product_type' => $cleaned_data['type'],
        ':product_description' => $cleaned_data['description'],
        ':product_stock' => $cleaned_data['stock'],
        ':product_price' => $cleaned_data['price'],
        ':image' => $cleaned_data['product_image'],
    ];

    $query = $sql_queries->storeProductData();
    $database_wrapper->safeQuery($query, $parameters);
}

function cleanProductData($app, $product_image, $product_data)
{
    $validator = $app->getContainer()->get('validator');

    $image_file = null;
    $cleaned_data = array();
    if ($product_image['size'] < 3000000)
    {
        $image_file = $product_image['name'];
    }else{
        $cleaned_data['error'] = 'Image File is too large';
    }

    $cleaned_data['product_id'] = $validator->sanitiseNumber($product_data['product_id']);
    $cleaned_data['product_name'] = $validator->sanitiseString($product_data['product_name']);
    $cleaned_data['type'] = $validator->sanitiseString($product_data['type']);
    $cleaned_data['description'] = $validator->sanitiseString($product_data['description']);
    $cleaned_data['stock'] = $validator->sanitiseNumber($product_data['stock']);
    $cleaned_data['price'] = $validator->sanitiseString($product_data['price']);
    $cleaned_data['product_image'] = MEDIA_PATH . $validator->sanitiseImageFile($image_file);

    return $cleaned_data;
}

function checkIfFormIsFilled($tainted)
{
    $isEmpty = false;
    if(empty($tainted['description']) || empty($tainted['product_name']) || empty($tainted['type']) ||
    empty($tainted['stock']) || empty($tainted['price']))
    {
        $isEmpty = true;
        $_SESSION['add-product-error'] = "Please Fill the Form Fully";
    }
    return $isEmpty;
}

function moveImageFile($tmp_image, $clean_image)
{
    $target_dir = '/p3t/phpappfolder/public_php/finalyearproject/media/' . $clean_image;
    $message = '';
    if(move_uploaded_file($tmp_image, $target_dir))
    {
        $message ='File is successfully uploaded.';
    }
    else
    {
        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
    }

    return $message;
}


function fileImagesSet()
{
    if(isset($_FILES['product_image']))
    {
        return $_FILES['product_image'];
    }
}

function productFormSet()
{
    if(isset($_SESSION['add-product-error']))
    {
        return $_SESSION['add-product-error'];
    }
}