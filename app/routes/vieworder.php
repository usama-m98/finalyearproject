<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/vieworder', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned = validateFormInput($app, $tainted);

   var_dump($tainted);

   $html_output = $this->view->render($response,
       'vieworder.html.twig',
       [
           'page_title' => 'Configure Form',
           'css_path' => CSS_PATH,
           'landing_page' => LANDING_PAGE,
           'js_path' => JS_PATH,
           'heading' => 'Configuration Order Details',
       ]);

   processOutput($app, $html_output);

   return $html_output;
});

function validateFormInput($app, $tainted)
{
    $validator = $app->getContainer()->get('validator');

    $cleaned['case'] = $validator->sanitiseString($tainted['Cases']);
    $cleaned['processor'] = $validator->sanitiseString($tainted['Intel-processor']);
    $cleaned['motherboard'] = $validator->sanitiseString($tainted['Motherboard']);
    $cleaned['ram'] = $validator->sanitiseString($tainted['RAM']);
    $cleaned['graphics_card'] = $validator->sanitiseString($tainted['Graphics-card']);
    $cleaned['hard_drive'] = $validator->sanitiseString($tainted['Hard-drive']);
    $cleaned['cooling_fan'] = $validator->sanitiseString($tainted['Cooling-fan']);
    $cleaned['power_supply'] = $validator->sanitiseString($tainted['Power-Supply']);

    return $cleaned;
}