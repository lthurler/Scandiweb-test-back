<?php

namespace Util;

use InvalidArgumentException;
use JsonException;


class Json
{
    public static function processArrayToReturn($response)
    {
        $data = [];
        $data['type'] = 'error';

        if ((is_array($response) && count($response) > 0)) {
            $data['type'] = 'success';
            $data['response'] = $response;
        }

        self::jsonReturn($data);
    }

    private static function jsonReturn($data)
    {
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET,PATCH,DELETE,POST,PUT');

        echo json_encode($data, JSON_THROW_ON_ERROR, 1024);
        exit;
    }

    public static function handleJsonRequestBody()
    {
        try {
            $postJson = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);

        } catch (JsonException $e) {
            throw new InvalidArgumentException('Request Body cannot be empty!');
        }

        if (is_array($postJson) && count($postJson) > 0) {
            return $postJson;
        }
    }
}