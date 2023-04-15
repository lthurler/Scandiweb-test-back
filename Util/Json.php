<?php

namespace Util;

use InvalidArgumentException;
use Util\GenericConstants;
use JsonException;


class Json
{

    public function processArrayToReturn($return) {

        // var_dump($return);exit;
        $data = [];
        $data[GenericConstants::TYPE] = GenericConstants::TYPE_ERROR;

        if((is_array($return) && count($return) > 0)) {            
            $data[GenericConstants::TYPE] = GenericConstants::TYPE_SUCESS;
            $data[GenericConstants::RESPONSE] = $return;
        }

        $this->jsonReturn($data);
    }

    private function jsonReturn($json) {

        header('Content-Type: application/json');
        header('Cache-control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');

        echo json_encode($json, JSON_THROW_ON_ERROR, 1024);
        exit;
    }

    public static function handleJsonRequestBody() {

        try {
            $postJson = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidArgumentException(GenericConstants::ERR0R_MSG_EMPTY_JSON);
        }
        if (is_array($postJson) && count($postJson) > 0) {
            return $postJson;
        }
    }
}
