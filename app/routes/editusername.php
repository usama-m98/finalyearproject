<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('\editpersonaldetails', function(Request $request, Response $response) use ($app)
{

   $html_output = $this->view->render($response,
       'editpersonaldetails.html.twig',
       [
           'page_title' => 'Edit Personal Details',
           'css_path' => CSS_PATH,
           'landing_page' => LANDING_PAGE,
           'js_path' => JS_PATH,
           'page_heading2' => 'Edit Personal Info',
           'action' => '#',
       ]);

   processOutput($app, $html_output);

   return $html_output;
});