<?php

$app_url = dirname($_SERVER['SCRIPT_NAME']);
$css_file_path = $app_url . '/css/styles.css';
define('CSS_PATH', $css_file_path);
define('APPLICATION_NAME', 'CustomPcSpecialists');

$url_root = $_SERVER['SCRIPT_NAME'];
$url_root = implode('/', explode('/', $url_root, -1));
define('LANDING_PAGE', $url_root);
define ('BCRYPT_ALGO', PASSWORD_DEFAULT);
define ('BCRYPT_COST', 12);

$settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => false,
        'addContentLengthHeader' => false,
        'mode' => 'development',
        'debug' => true,
        'class_path' => __DIR__ . '/src/',
        'view' => [
            'template_path' => __DIR__ . '/templates/',
            'twig' => [
                'cache' => false,
                'auto_reload' => true
            ]],
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'final_year_db',
            'username' => 'final_year_user',
            'password' => 'final_year_pass',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
];

return $settings;