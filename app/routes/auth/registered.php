<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->post('/registered', function(Request $request, Response $response) use ($app)
{
   $tainted = $request->getParsedBody();

   if (empty($tainted['signup_username']) || empty($tainted['signup_email']) || empty($tainted['signup_password']))
   {

       return $response->withRedirect('signup');
   }else{
       $clean_parameters = cleanSignUpParameters($app, $tainted);
       $hashed_password = hash_password($app, $clean_parameters['password']);

       $stored_user_details = storeUserAccountDetails($app, $clean_parameters, $hashed_password);

       return $response->withRedirect(LANDING_PAGE);
   }
});


function cleanSignUpParameters($app, $tainted_parameters)
{

    $cleaned_parameters = [];
    $validator = $app->getContainer()->get('validator');

    $tainted_username = $tainted_parameters['signup_username'];
    $tainted_email = $tainted_parameters['signup_email'];
    $tainted_role = '';

    if (array_key_exists('role', $tainted_parameters))
    {
        $tainted_role = $tainted_parameters['role'];
    }else{
        $tainted_role = 'Member';
    }

    $cleaned_parameters['password'] = $tainted_parameters['signup_password'];
    $cleaned_parameters['sanitised_username'] = $validator->sanitiseString($tainted_username);
    $cleaned_parameters['sanitised_email'] = $validator->sanitiseEmail($tainted_email);
    $cleaned_parameters['role'] = $validator->sanitiseRole($tainted_role);

    return $cleaned_parameters;
}

function hash_password($app, $password_to_hash): string
{
    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');
    $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash);
    return $hashed_password;
}

function storeUserAccountDetails($app, $clean_parameters, $hashed_password)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $parameters = [
        ':username' => $clean_parameters['sanitised_username'],
        ':email' => $clean_parameters['sanitised_email'],
        ':password' => $hashed_password,
        ':role' => $clean_parameters['role']
    ];

    $query = $sql_queries->storeUserLoginData();
    $database_wrapper->safeQuery($query, $parameters);

}