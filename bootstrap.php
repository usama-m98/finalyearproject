<?php

session_start();

require 'vendor/autoload.php';

$settings = require __DIR__ . '/app/settings.php';

$container = new \Slim\Container($settings);

require __DIR__ . '/app/dependencies.php';

$app = new \Slim\App($container);

require __DIR__ . '/app/middleware.php';

require __DIR__ . '/app/routes.php';

$capsule = $app->getContainer()->get('db');
$capsule->bootEloquent();

$app->run();

