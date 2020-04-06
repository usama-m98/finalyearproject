<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/addpersonalinfoform', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned_params = cleanPersonalInfoParams($app, $tainted);
    $auth_info = getAuthInfo($app, $_SESSION['user']);
    $store_personal_info = storeUserPersonalInfo($app, $cleaned_params, $auth_info);

//    $html_output = $this->view->render($response,
//        'result.html.twig',
//        [
//            'page_title' => 'Personal Details',
//            'css_path' => CSS_PATH,
//            'landing_page' => LANDING_PAGE,
//            'js_path' => JS_PATH,
//        ]);
//
//    processOutput($app, $html_output);

    return $response->withRedirect('personaldetails');
});

function cleanPersonalInfoParams($app, $tainted)
{
    $cleaned_parameters = [];
    $validator = $app->getContainer()->get('validator');

    $tainted_firstname = $tainted['firstname'];
    $tainted_surname = $tainted['surname'];
    $tainted_address = $tainted['address'];
    $tainted_postcode = $tainted['postcode'];
    $tainted_city = $tainted['city'];
    $tainted_phoneno = $tainted['phone-number'];

    $cleaned_parameters['firstname'] = $validator->sanitiseString($tainted_firstname);
    $cleaned_parameters['surname'] = $validator->sanitiseString($tainted_surname);
    $cleaned_parameters['address'] = $validator->sanitiseString($tainted_address);
    $cleaned_parameters['postcode'] = $validator->sanitiseString($tainted_postcode);
    $cleaned_parameters['city'] = $validator->sanitiseString($tainted_city);
    $cleaned_parameters['phone-number'] = $validator->sanitiseString($tainted_phoneno);

    return $cleaned_parameters;
}

function storeUserPersonalInfo($app, $cleaned, $auth)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->insertPersonalDetails();
    $user_id = $auth['user_id'];

    $parameters = [
        ':firstname' => $cleaned['firstname'],
        ':surname' => $cleaned['surname'],
        ':address' => $cleaned['address'],
        ':postcode' => $cleaned['postcode'],
        ':city' => $cleaned['city'],
        ':phonenumber' => $cleaned['phone-number'],
        ':userid' => $user_id,
    ];

    $database_wrapper->safeQuery($query, $parameters);
}