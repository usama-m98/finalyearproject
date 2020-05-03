<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/productaction', function(Request $request, Response $response) use ($app)
{
    if(isset($_SESSION['user'])) {
        if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Root') {
            $tainted = $request->getParsedBody();
            $clean_product_id = cleanInteger($app, $tainted['productID']);
            $product_status = productActionValidation($tainted['option']);
            $product_types = productTypes();

            if($product_status === 'Edit')
            {
                $products = getStoredProducts($app);
                $item = filterProduct($products, $clean_product_id);

                $html_output = $this->view->render($response,
                    'updateproduct.html.twig',
                    [
                        'page_title' => 'Update Items',
                        'css_path' => CSS_PATH,
                        'landing_page' => LANDING_PAGE,
                        'js_path' => JS_PATH,
                        'page_heading2' => 'Update Items',
                        'action' => 'updateItem',
                        'types' => $product_types,
                        'item' => $item
                    ]);

                processOutput($app, $html_output);

                return $html_output;
            }elseif ($product_status === 'Delete')
            {
                removeItem($app, $clean_product_id);
                setRemoveItem();

                return $response->withHeader('Location','productslist');
            }
        }
    }else{
        return $response->withHeader('Location', LANDING_PAGE);
    }

});

function filterProduct($products, $product_id)
{
    $item_to_keep = null;
    foreach($products as $item)
    {
        if ($item['product_id'] === $product_id)
        {
            $item_to_keep = $item;
        }
    }

    return $item_to_keep;
}

function productActionValidation($param)
{
    $product_status = '';

    if($param === 'Edit-Item')
    {
        $product_status = 'Edit';
    }elseif ($param === 'Remove-Item')
    {
        $product_status = 'Delete';
    }else{
        die();
    }

    return $product_status;
}

function removeItem($app, $product_id)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->removeProduct();

    $params = [
      ':product_id' => $product_id
    ];

    $database_wrapper->safeQuery($query, $params);
    $_SESSION['removed_item'] = true;
}

function setRemoveItem()
{
    if (isset($_SESSION['removed_item']))
    {
        return $_SESSION['removed_item'];
    }
}

