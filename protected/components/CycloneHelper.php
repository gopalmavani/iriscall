<?php

class CycloneHelper
{
    /**
     * Maintain error codes
     * @param $c
     * @return mixed
     */
    public static function codes($c)
    {
        $codes = [
            200 => true,
            500 => "Internal Server Error",
            510 => "Curl Error",
            511 => "GII Error",
            512 => "Table could not generated",
            513 => "Table could not modified",
            514 => "Could not generate table"
        ];

        return $codes[$c];
    }

    /**
     * Returns json formatted response
     * @param $code
     * @param array $data
     * @param string $msg
     */
    public static function jsonResponse($code, $data = [], $msg = '') {
        echo CJSON::encode([
            "result" => CycloneHelper::codes($code),
            "message" => $msg,
            "data" => $data
        ]);
    }

    /**
     * Handles curl request
     * @param $url
     * @param $data
     * @param $type
     * @return bool|mixed
     */
    public static function curl($url, $data, $type) {
        try {

            $data_string = CJSON::encode($data);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
            );
            $result = curl_exec($ch);
            curl_close($ch);
            return CJSON::decode($result);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Call Gii API
     * @param $name
     * @param array $data
     * @return bool|mixed
     */
    public static function gii($name, $data = []) {
        $domain = Yii::app()->params['templateCurlUrl'];
        $url = $domain. "/admin/gii/{$name}/index";
        return CycloneHelper::curl($url, $data, 'post');
    }

    /**
     * @param array $name
     * @return bool|mixed
     */
    public static function TestFunction($name) {
        return $name;
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function nameStrict($string) {
        return preg_replace("/[^A-Za-z0-9]/", "", strtolower($string));
    }
}