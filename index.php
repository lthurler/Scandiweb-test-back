<?php

use Util\Json;
use Util\Routes;
// use Validator\RequestValidator;
use Service\ProductService;

require_once 'config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {    
    header("Access-Control-Allow-Methods: GET,PATCH,POST,OPTIONS");        
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type");  
    
    exit;
}

try {
    
    $productService = new ProductService(Routes::getRoutes());
    $response = $productService->handleRequest();

    Json::processArrayToReturn($response);

} catch (Exception $exception) {

    echo json_encode([
        'Type' => 'ERROR',
        'Response' => $exception->getMessage()
    ], JSON_THROW_ON_ERROR, 512);
    
    exit;
}