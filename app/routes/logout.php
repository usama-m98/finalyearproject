<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/logout', function(Request $request, Response $response) use ($app)
{
    unset($_SESSION['role']);
    unset($_SESSION['user']);
    session_destroy();

    return $response->withRedirect(LANDING_PAGE);

})->setName('logout');