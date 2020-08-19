<?php

class VerifySSOToken extends CApplicationComponent{

    public static function verify() {
        if(!Yii::app()->user->isGuest){
            $user = UserInfo::model()->findByPk(Yii::app()->user->id);
            $sso_url = Yii::app()->params['SSO_URL'];
            if(!is_null($user->api_token)){
                //Validate token
                $curl_token = curl_init();

                curl_setopt_array($curl_token, array(
                    CURLOPT_URL => $sso_url."api/validateToken",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode([
                        "token" => $user->api_token
                    ]),
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "content-type: application/json"
                    ),
                ));

                $response_token = curl_exec($curl_token);
                $err_token = curl_error($curl_token);
                curl_close($curl_token);

                if(!$err_token){
                    $response = json_decode($response_token, true);
                    if($response['status'] != 1){
                        UserHelper::performLogout();
                    }
                } else {
                    UserHelper::performLogout();
                }
            } else {
                UserHelper::performLogout();
            }
        }
    }

}

?>