<?php

require_once('bootstrap.php');
require './vendor/autoload.php';

use App\Controller\BaseController;
use App\Controller\ContentController;
use App\Controller\CategoryController;
use App\Controller\ImageKitController;
use App\Controller\ProductController;
use App\Controller\QuoteController;
use App\Controller\MessageController;
use App\Controller\SubscriberController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// all of our endpoints start with /api
// everything else results in a 404 Not Found
if ($uri[1] !== 'api') {
    header("HTTP/1.1 404 Not Found");
    exit();
}


$requestMethod = $_SERVER["REQUEST_METHOD"];
processRequest($requestMethod, $uri);

function processRequest($requestMethod, $uri)
{
    $service = (isset($uri[2])) ? $uri[2] : null ;

    if (!isset($service)) {
        echo json_encode(BaseController::unprocessableEntity());
        return;
    }

    switch ($service) {
        case 'content':
            $content = new ContentController($requestMethod, $uri);
            $content->processRequest();
            break;

        case 'categories':
            $category = new CategoryController($requestMethod, $uri);
            $category->processRequest();
            break;

        case 'products':
            $product = new ProductController($requestMethod, $uri);
            $product->processRequest();
            break;

        case 'quotes':
            $product = new QuoteController($requestMethod, $uri);
            $product->processRequest();
            break;

        case 'messages':
            $product = new MessageController($requestMethod, $uri);
            $product->processRequest();
            break;

        case 'subscribers':
            $product = new SubscriberController($requestMethod, $uri);
            $product->processRequest();
            break;

        case 'image-kit-auth':
            $imageKit = new ImageKitController($requestMethod, $uri);
            $authParams = $imageKit->getAuthenticationParams();
            echo $authParams;
            break;
        
        default:
            echo json_encode(BaseController::notFoundResponse());
            break;
    }
}

// pass the request method and user ID to the PersonController and process the HTTP request:
// $controller = new PersonController($dbConnection, $requestMethod, $userId);
// $controller->processRequest();