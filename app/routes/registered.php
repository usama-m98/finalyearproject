<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/registered', function(Request $request, Response $response) use ($app)
{
   $tainted = $request->getParsedBody();
   $clean_parameters = cleanParameters($app, $tainted);
});


function cleanParameters($app, $taintedParameters)
{


}

function hash_password($app, $password_to_hash): string
{
    $bcrypt_wrapper = $app->getContainer()->get('bcryptWrapper');
    $hashed_password = $bcrypt_wrapper->createHashedPassword($password_to_hash);
    return $hashed_password;
}