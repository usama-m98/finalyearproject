<?php

$app_url = dirname($_SERVER['SCRIPT_NAME']);
$media_dir_path = $app_url . '/media/';
$css_file_path = $app_url . '/css/styles.css';
$js_file_path = $app_url . '/js/scripts.js';
$homepage_banner = $app_url . '/media/Gaming_PC_Banner_Hyper_Liquid.jpg';
define('MEDIA_PATH', $media_dir_path);
define('CSS_PATH', $css_file_path);
define('JS_PATH', $js_file_path);
define('APPLICATION_NAME', 'CustomPcSpecialists');
define('HOMEPAGE_BANNER', $homepage_banner);

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
        'pdo_settings' => [
            'rdbms' => 'mysql',
            'host' => 'localhost',
            'db_name' => 'final_year_db',
            'port' => '3306',
            'user_name' => 'final_year_user',
            'user_password' => 'final_year_pass',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'options' => [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => true,
            ],
        ]
    ],
];

return $settings;