<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/personaldetails', function(Request $request, Response $response) use ($app)
{

    if(isset($_SESSION['user'])) {

        $auth_info = getAuthInfo($app, $_SESSION['user']);
        $username = $auth_info['username'];
        $email = $auth_info['email'];
        $personal_details = getUserPersonalInfo($app, $auth_info);
        $personal_info_exists = false;

        $main_page = $_SERVER['HTTP_REFERER'];
        if ($personal_details) {
            $personal_info_exists = true;
        }

        $error_message = '';
        if (isset($_SESSION['form-error']))
        {
            $error_message = 'Please Fill Form full and correctly';
        }

        unset($_SESSION['form-error']);
        return $this->view->render($response,
            'personaldetails.html.twig',
            [
                'page_title' => 'Personal Details',
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'js_path' => JS_PATH,
                'main_page' => $main_page,
                'page_heading2' => 'User Account Information',
                'username' => $username,
                'email' => $email,
                'personal_info_exists' => $personal_info_exists,
                'personal_info' => $personal_details,
                'action' => 'addpersonalinfoform',
                'message' => $error_message
            ]);


    }else{
        return $response->withRedirect(LANDING_PAGE);
    }
})->setName('personaldetails');

function getUserPersonalInfo($app, $auth_info)
{
    $database_wrapper = $app->getContainer()->get('databaseConnection');
    $sql_queries = $app->getContainer()->get('dbQueries');

    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrievePersonalDetails();
    $user_id = $auth_info['user_id'];

    $parameters = [
        ":user_id" => $user_id
    ];

    $database_wrapper->query($query, $parameters);
    $result[0] = $database_wrapper->safeFetchArray();
    return $result[0];
}

