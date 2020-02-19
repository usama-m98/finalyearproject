<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/registered', function(Request $request, Response $response) use ($app)
{
   $tainted = $request->getParsedBody();
});


function cleanParameters($app, $taintedParameters)
{

}