<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/registered', function(Request $request, Response $response) use ($app)
{
   $tainted = $request->getParsedBody();
   $clean_parameters = cleanParameters($app, $tainted);
   $hashed_password = hash_password($app, $clean_parameters['password']);

   $stored_user_details = storeUserAccountDetails($app, $clean_parameters, $hashed_password);

   return $response->withRedirect(LANDING_PAGE); //error to fix: $checked_if_empty will always return a value, so signup will always redirect-> fix it
});


function cleanParameters($app, $tainted_parameters)
{

    $cleaned_parameters = [];
    $validator = $app->getContainer()->get('validator');

    $tainted_username = $tainted_parameters['signup_username'];
    $tainted_email = $tainted_parameters['signup_email'];
    $tainted_button = $tainted_parameters['signup_button'];

    $cleaned_parameters['password'] = $tainted_parameters['signup_password'];
    $cleaned_parameters['sanitised_username'] = $validator->sanitiseString($tainted_username);
    $cleaned_parameters['sanitised_email'] = $validator->sanitiseEmail($tainted_email);

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
    $db = $app->getContainer()->get('db');
    $user = FinalYear\User::create([
       'username' => $clean_parameters['sanitised_username'],
        'email' => $clean_parameters['sanitised_email'],
        'password' => $hashed_password,
        'role' => 'member',
    ]);
}