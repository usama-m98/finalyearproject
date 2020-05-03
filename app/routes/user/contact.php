<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/contact', function(Request $request, Response $response) use ($app)
{
    if(isset($_SESSION['user'])) {

        $order_id = null;
        if (isset($_GET['orderID'])) {
            $order_id = $_GET['orderID'];
        }


        $html_output = $this->view->render($response,
            'contactform.html.twig',
            [
                'page_title' => 'Contact Form',
                'css_path' => CSS_PATH,
                'landing_page' => LANDING_PAGE,
                'js_path' => JS_PATH,
                'login' => 'login',
                'signup' => 'signup',
                'heading' => 'Contact Us',
                'action' => 'contactform',
                'order_id' => $order_id
            ]);

        processOutput($app, $html_output);

        return $html_output;
    }else{
        return $response->withRedirect(LANDING_PAGE);
    }
});