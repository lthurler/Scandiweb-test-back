<?php

use Util\Json;
use Util\Routes;
use Service\ProductService;

require_once 'config.php';


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");    
    header("Access-Control-Allow-Methods: GET,DELETE,POST,OPTIONS");        
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type");  
    
    exit;
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


try {
    
    $routes = new Routes();
    $productService = new ProductService($routes->getRoutes());
    $response = $productService->handleRequest();

    $json = new Json();
    $json->processArrayToReturn($response);

} catch (Exception $exception) {

    echo json_encode([
        'Type' => 'ERROR',
        'Response' => $exception->getMessage()
    ], JSON_THROW_ON_ERROR, 512);
    
    exit;
}