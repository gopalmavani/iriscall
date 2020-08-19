<?php

/**
 * Created by PhpStorm.
 * User: imyuvii
 * Date: 27/10/16
 * Time: 5:06 PM
 */
class ApiResponse
{
    public static function json($result, $code, $data = [], $message = '') {
        header('Content-type: application/json');
        echo CJSON::encode([
            "result" => $result,
            "code" => $code,
            "message" => $message,
            "data" => $data
        ]);
    }

    private function _getStatus($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Field Is Empty', // request empty field - validation
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}