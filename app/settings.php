<?php

$app_url = dirname($_SERVER['SCRIPT_NAME']);
$media_dir_path = $app_url . '/media/';
$css_file_path = $app_url . '/css/styles.css';
$js_file_path = $app_url . '/js/scripts.js';
define('MEDIA_PATH', $media_dir_path);
define('CSS_PATH', $css_file_path);
define('JS_PATH', $js_file_path);
define('APPLICATION_NAME', 'CustomPcSpecialists');
define('APP_URL', $app_url);

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
    ],
];

return $settings;