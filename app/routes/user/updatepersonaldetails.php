<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/updatepersonaldetails', function(Request $request, Response $response) use ($app)
{
    $auth_info = getAuthInfo($app, $_SESSION['user']);
    $personal_details = getUserPersonalInfo($app, $auth_info);


    $error_message = '';
    if (isset($_SESSION['form-error']))
    {
        $error_message = 'Please Fill Form full and correctly';
    }

    unset($_SESSION['form-error']);
    return $this->view->render($response,
        'updatepersonaldetail.html.twig',
        [
            'page_title' => 'Edit email',
            'css_path' => CSS_PATH,
            'landing_page' => LANDING_PAGE,
            'js_path' => JS_PATH,
            'page_heading2' => 'Edit email',
            'action' => 'personaldetailschanged',
            'details' => $personal_details,
            'message' => $error_message
        ]);

});