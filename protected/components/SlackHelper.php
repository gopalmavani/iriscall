<?php
class SlackHelper extends CApplicationComponent {

    public static function sendData($channel, $text){
        $tokenItcan = 'xoxp-244285340007-531647210147-616795671926-3328cc644b0d855cb84b9550912c160d';
        $message = urlencode($text);
        $channel = urlencode($channel);
        $url = "https://slack.com/api/chat.postMessage?token=".$tokenItcan."&channel=".$channel."&text=".$message."&icon_emoji=:speech_balloon:&username=CronRobo&link_names=1&as_user=false";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
    }

}