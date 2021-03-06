<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


$app->post('/signin', function (Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned_params = cleanSignInParameters($app, $tainted);
    $auth_info = getAuthInfo($app, $cleaned_params['username']);
    $personal_details = getUserPersonalInfo($app, $auth_info);


    $sign_in = signIn($auth_info ,$cleaned_params['password']);

    //checking that sessions have been set
    sessionCheck();
    user();
    role();

    if(!$sign_in)
    {
        return $response->withRedirect('login');
    }

    if(isset($_SESSION['order']))
    {
        return $response->withRedirect('vieworder');
    }
    return $response->withRedirect(LANDING_PAGE);


});

function cleanSignInParameters($app, $tainted)
{
    $cleaned_parameters = [];
    $validator = $app->getContainer()->get('validator');
    $tainted_username = $tainted['username'];

    $cleaned_parameters['password'] = $tainted['password'];
    $cleaned_parameters['username'] = $validator->sanitiseString($tainted_username);

    return $cleaned_parameters;
}

function getAuthInfo($app, $username)
{
    $database_wrapper = $app->getContainer()->get('databaseConnection');
    $sql_queries = $app->getContainer()->get('dbQueries');

    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrieveUserData();
    $parameters = [':username' => $username];

    $database_wrapper->query($query, $parameters);
    $result =$database_wrapper->safeFetchArray();

    return $result;
}

function signIn( $auth_info, $password)
{
    $signed_in = false;
    $hashed_password = $auth_info['password'];

    if(password_verify($password, $hashed_password))
    {
        $_SESSION['user'] = $auth_info['username'];
        $_SESSION['role'] = $auth_info['role'];
        $signed_in = true;
    }else{
        $_SESSION['failed_message'] = 'Username or Password Incorrect';
    }

    return $signed_in;
}

function sessionCheck()
{
    if(isset($_SESSION['user'])){
            if ($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Root') {
                return $_SESSION['active_admin'] = true;
            } else {
                return $_SESSION['active_user'] = true;
            }
        }
}

function user()
{
    if(isset($_SESSION['user'])){
        return $_SESSION['user'];
    }
}

function role(){
    if(isset($_SESSION['role'])){
        return $_SESSION['role'];
    }
}



