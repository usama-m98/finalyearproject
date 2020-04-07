<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/addadminuser', function (Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    var_dump($tainted);
    $clean_parameters = cleanSignUpParameters($app, $tainted);
    $hashed_password = hash_password($app, $clean_parameters['password']);
    $stored_user_details = storeUserAccountDetails($app, $clean_parameters, $hashed_password);

    echo 'User has been added';
    return $response->withRedirect(LANDING_PAGE);


})->setName('addadminuser');