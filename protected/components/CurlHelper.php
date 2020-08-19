<?php

class CurlHelper extends CApplicationComponent{

    public static function executeAction($url, $dataArray, $actionType) {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $actionType,
                CURLOPT_POSTFIELDS => json_encode($dataArray),
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);

            $result['success_response'] = json_decode($response, true);
            $result['error_response'] = json_decode($error, true);

        } catch (Exception $e){
            $result['success_response'] = '';
            $result['error_response'] = $e->getMessage();
        }
        return $result;
    }

}

?>