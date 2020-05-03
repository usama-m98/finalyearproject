<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/viewmessages', function(Request $request, Response $response) use ($app)
{

})->setName('viewmessages');