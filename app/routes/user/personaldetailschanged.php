<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/personaldetailschanged', function(Request $request, Response $response) use ($app)
{
    $tainted = $request->getParsedBody();
    $cleaned_params = cleanPersonalInfoParams($app, $tainted);
    $auth_info = getAuthInfo($app, $_SESSION['user']);
    $isFormEmpty = personalInfoFilled($tainted);

    if ($isFormEmpty)
    {
        return $response->withRedirect($_SERVER['HTTP_REFERER']);
    }else{
        updateUserPersonalInfo($app, $cleaned_params, $auth_info);
        return $response->withHeader('Location', 'personaldetails');
    }
});

function updateUserPersonalInfo($app, $cleaned, $auth)
{
    $database_wrapper = $app->getContainer()->get('databaseConnection');
    $sql_queries = $app->getContainer()->get('dbQueries');

    $database_wrapper->makeDatabaseConnection();

    $query = $sql_queries->updateCustomerDetails();
    $user_id = $auth['user_id'];

    $parameters = [
        ':first_name' => $cleaned['firstname'],
        ':surname' => $cleaned['surname'],
        ':address' => $cleaned['address'],
        ':postcode' => $cleaned['postcode'],
        ':city' => $cleaned['city'],
        ':phone_number' => $cleaned['phone-number'],
        ':userid' => $user_id,
    ];

    $database_wrapper->query($query, $parameters);
}