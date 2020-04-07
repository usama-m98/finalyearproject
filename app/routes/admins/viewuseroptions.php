<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/viewuseroptions', function (Request $request, Response $response) use ($app)
{
    $tainted= $request->getParsedBody();
    $action= directAction($app, $tainted);
    var_dump($tainted);

    $html_output = $this->view->render($response,
        'result.html.twig',
        [
            'page_title' => 'Personal Details',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
        ]);

    processOutput($app, $html_output);

    return $html_output;
});

function directAction($app, $action)
{
}

function filterUser()
{

}