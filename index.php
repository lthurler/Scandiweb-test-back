<?php

use Util\Json;
use Util\Routes;
use Validator\RequestValidator;
use Util\GenericConstants;

require_once 'bootstrap.php';

try {

    $requestValidator = new RequestValidator(Routes::getRoutes());
    $return = $requestValidator->handleRequest();
    // var_dump($return);exit;    

    $json = new Json();
    $json->processArrayToReturn($return);

} catch (Exception $exception) {

    echo json_encode([
        GenericConstants::TYPE => GenericConstants::TYPE_ERROR,
        GenericConstants::RESPONSE => $exception->getMessage()
    ], JSON_THROW_ON_ERROR, 512);
    exit;
}
