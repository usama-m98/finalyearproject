<?php


// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        $container['settings']['view']['template_path'],
        $container['settings']['view']['twig'],
        [
            'debug' => true // This line should enable debug mode
        ]
    );
    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    $view->getEnvironment()->addGlobal('session', $_SESSION);
    if(isset($_SESSION['cart']))
    {
        $view->getEnvironment()->addGlobal('cart_count', sizeof($_SESSION['cart']));
    }

    return $view;
};


$container['validator'] = function ($container) {
    $validator = new \FinalYear\Validator();
    return $validator;
};

$container['bcryptWrapper'] = function ($container) {
    $wrapper = new \FinalYear\BcryptWrapper();
    return $wrapper;
};

$container['dbQueries'] = function ($container){
    $db_query = new \FinalYear\DbQueries();
    return $db_query;
};

$container['databaseWrapper'] = function ($container){
    $database_wrapper = new \FinalYear\DatabaseWrapper();
    return $database_wrapper;
};

$container['processOutput'] = function ($container){
    $model = new FinalYear\ProcessOutput();
    return $model;
};

$container['cart'] = function ($container){
    $cart = new FinalYear\Cart();
    return $cart;
};

