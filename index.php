<?php

use Util\Json;
use Util\Routes;
use Validator\RequestValidator;
use Util\GenericConstants;

require_once 'bootstrap.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: *');
header("Access-Control-Max-Age: 3600");
header('Access-Control-Allow-Methods: GET,PATCH,DELETE,POST,PUT, OPTIONS');

try {

    $requestValidator = new RequestValidator(Routes::getRoutes());
    $return = $requestValidator->handleRequest();

    $json = new Json();
    $json->processArrayToReturn($return);

} catch (Exception $exception) {

    echo json_encode([
        GenericConstants::TYPE => GenericConstants::TYPE_ERROR,
        GenericConstants::RESPONSE => $exception->getMessage()
    ], JSON_THROW_ON_ERROR, 512);
    exit;
}