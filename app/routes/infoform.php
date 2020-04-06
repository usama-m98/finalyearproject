<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/infoform', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned_params = cleanPersonalInfoParams($app, $tainted);
    $auth_info = getAuthInfo($app, $_SESSION['user']);
    var_dump($auth_info);
    $store_personal_info = storeUserPersonalInfo($app, $cleaned_params, $auth_info);

//    $html_output = $this->view->render($response,
//        'result.html.twig',
//        [
//            'page_title' => 'Personal Details',
//            'css_path' => CSS_PATH,
//            'landing_page' => LANDING_PAGE,
//            'js_path' => JS_PATH,
//        ]);
//
//    processOutput($app, $html_output);

    return $response->withRedirect('vieworder');
});
