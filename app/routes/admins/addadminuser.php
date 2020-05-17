<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/addadminuser', function (Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    if (empty($tainted['signup_username']) || empty($tainted['signup_email']) || empty($tainted['signup_password']))
    {
        $_SESSION['failed_message'] = 'Please Fill the Form Completely';
        return $response->withRedirect('addadmin');
    }else{

    }
    $clean_parameters = cleanSignUpParameters($app, $tainted);
    $auth = getUserAccountDetails($app);
    $account_exists = usernameAndEmailExists($clean_parameters['sanitised_email'], $clean_parameters['sanitised_username'],
        $auth);
    if($account_exists['username'])
    {
        $_SESSION['failed_message'] = 'Username exists';
        return $response->withRedirect('addadmin');
    }

    if ($account_exists['email']) {
        $_SESSION['failed_message'] = 'Email exists';
        return $response->withRedirect('addadmin');
    }

    if ($clean_parameters['password'] === false) {
        return $response->withRedirect('addadmin');
    } else {
        $hashed_password = hash_password($app, $clean_parameters['password']);

        storeUserAccountDetails($app, $clean_parameters, $hashed_password);

        return $response->withRedirect('viewusers');
    }


})->setName('addadminuser');