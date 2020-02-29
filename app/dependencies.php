<?php

$container['db'] = function ($container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    return $capsule;
};

$container['auth'] = function ($container) {
    $auth = new FinalYear\UserAuth();
    return $auth;
};

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

    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user(),
    ]);

    return $view;
};

$container['user'] = function ($container) {
    $user = new \FinalYear\User();
    return $user;
};


$container['validator'] = function ($container) {
    $validator = new \FinalYear\Validator();
    return $validator;
};

$container['bcryptWrapper'] = function ($container) {
    $wrapper = new \FinalYear\BcryptWrapper();
    return $wrapper;
};

$container['processOutput'] = function ($container){
    $model = new FinalYear\ProcessOutput();
    return $model;
};

