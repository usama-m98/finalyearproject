<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/signin', function (Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned_params = cleanSignInParameters($app, $tainted);
    $sign_in = signIn($app, $cleaned_params['username'], $cleaned_params['password']);

    if(!$sign_in)
    {
        return $response->withRedirect('login');

    }

    return $response->withRedirect(LANDING_PAGE);

});

function signIn($app, $username, $password)
{
    $db = $app->getContainer()->get('db');
    $auth = $app->getContainer()->get('auth');
    $signin_result = $auth->signInAttempt($username, $password);

    return $signin_result;
}


function cleanSignInParameters($app, $tainted)
{
    $cleaned_parameters = [];
    $validator = $app->getContainer()->get('validator');
    $tainted_username = $tainted['username'];

    $cleaned_parameters['password'] = $tainted['password'];
    $cleaned_parameters['username'] = $validator->sanitiseString($tainted_username);

    return $cleaned_parameters;
}