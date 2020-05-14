<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/viewusers', function (Request $request, Response $response) use ($app)
{
    if(isset($_SESSION['user'])){
        if ($_SESSION['role'] == 'Root')
        {
            $user_data = getUserAccountDetails($app);

            if(isset($_SESSION['filtered_user_data']))
            {
                $user_data = $_SESSION['filtered_user_data'];
            }

            return $this->view->render($response,
                'viewusers.html.twig',
                [
                    'page_title' => 'View users',
                    'css_path' => CSS_PATH,
                    'landing_page' => LANDING_PAGE,
                    'js_path' => JS_PATH,
                    'page_heading2' => 'All Users',
                    'users' =>$user_data,
                    'action' => 'viewuseroptions',
                    'action2' => 'deleteuser',
                    'main_page' => 'admininterface'
                ]);
        }
    }else{
        die();
    }

})->setName('viewusers');

function getUserAccountDetails($app)
{
    $database_wrapper = $app->getContainer()->get('databaseWrapper');
    $sql_queries = $app->getContainer()->get('dbQueries');
    $settings = $app->getContainer()->get('settings');

    $database_connection_settings = $settings['pdo_settings'];

    $database_wrapper->setDatabaseConnectionSettings($database_connection_settings);
    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->retrieveAllUserData();

    $database_wrapper->safeQuery($query);
    $result =$database_wrapper->safeFetchAll();

    return $result;
}