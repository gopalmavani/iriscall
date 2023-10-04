<?php

class GenerateInvoice extends CApplicationComponent
{
    /**
     * @param $month
     * @param $type
     */
    public static function createInvoice($month_year, $org_id){
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $org_id = !empty($org_id) ? explode(",", $org_id) : [];

        self::fetchCDRInfo($month_year, $org_id);
        self::fetchFromNumber($month_year, $org_id);
        self::calculateCost($month_year, $org_id);
        self::invoiceGenerate($month_year, $org_id);
    }

    public static function fetchCDRInfo($month_year, $org_id){
        try{
            $date_range = [];
            $myDateTime = DateTime::createFromFormat('F-Y', $month_year);
            $start = strtotime($myDateTime->format('Y-m-01'));
            $end = strtotime($myDateTime->format('Y-m-t'));
            for ($i = $start; $i <= $end; $i += 86400) {
                $date_range[] = date("Y-m-d", $i);
            }
            //$organisationInfo = Yii::app()->db->createCommand("SELECT * FROM company_info WHERE id IN ({$org_id})")->queryAll();
            foreach ($org_id as $id){
                $fetchCDR = self::fetchCDR($date_range, $id);
                $log = "Fetch CDR info for organization ID: {$id} {$fetchCDR}".PHP_EOL;
                file_put_contents('protected/runtime/invoice.log', $log, FILE_APPEND);
            }
        } catch (Exception $e) {
            $log = "fetchCDRInfo: {$e->getMessage()}".PHP_EOL;
            file_put_contents('protected/runtime/invoice.log', $log, FILE_APPEND);
        }
    }

    public static function fetchCDR($date_range, $organisation_id){
        $all_data = [];
        foreach ($date_range as $date){
            //old url for get cdr data
            //$fileUrl = 'https://files.apollo.compass-stack.com/cdr/'.$organisation_id.'/'.$date.'/company.csv';
            //New url for get cdr data
            $fileUrl = 'https://files.pbx.mytelephony.eu/cdr/'.$organisation_id.'/'.$date.'/company.csv';
            //The path & filename to save to.
            $saveTo = 'company.csv';
            $saveTo = $_SERVER['DOCUMENT_ROOT'].Yii::app()->baseUrl.'/uploads/cdr-csv/company.csv';
            //Open file handler.
            $fp = fopen($saveTo, 'w+');

            //If $fp is FALSE, something went wrong.
            if($fp === false){
                throw new Exception('Could not open: ' . $saveTo);
            }

            $token = base64_encode(Yii::app()->params['cdr_username'].":".Yii::app()->params['cdr_password']);
            //Create a cURL handle.
            $ch = curl_init($fileUrl);
            //Pass our file handle to cURL.
            curl_setopt($ch, CURLOPT_FILE, $fp);

            //Timeout if the file doesn't download after 20 seconds.
            curl_setopt($ch, CURLOPT_TIMEOUT, 9000);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER , array(
                "Authorization: Basic ".$token,
                "content-type: application/json",
                "Accept: application/vnd.iperity.compass.v3+json"
            ));
            //Execute the request.
            curl_exec($ch);
            //If there was an error, throw an Exception
            if(curl_errno($ch)){
                throw new Exception(curl_error($ch));
            }
            //Get the HTTP status code.
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            //Close the cURL handler.
            curl_close($ch);
            //Close the file handler.
            fclose($fp);

            if($statusCode == 200) {
                $data = self::csvToArray($saveTo, ',');
                $cdr_data = [];
                foreach ($data as $key => $value) {
                    if($value['from_type'] != 'external'){
                        if(empty($value['answer_time'])){
                            $value['answer_time'] = '0000-00-00 00:00:00';
                        }
                        $value['organisation_id'] = $organisation_id;
                        $value['unit_cost'] = '';
                        $value['date'] = $date;
                        $value['created_at'] = date('Y-m-d H:i:s');
                        $start_time = new DateTime($value['start_time']);
                        $end_time = new DateTime($value['end_time']);
                        $interval = date_diff($end_time,$start_time);
                        $total_time = $interval->format('%h:%i:%s');
                        $value['total_time'] = $total_time;
                        $value['comment'] = '';
                        $value['created_at'] = date('Y-m-d H:i:s');
                        array_push($cdr_data, $value);
                    }
                }

                if(!empty($cdr_data)){
                    $deleted = CallDataRecordsInfo::model()->deleteAll("organisation_id='" .$organisation_id."' and date = '".$date."'");
                    $connection = Yii::app()->db->getSchema()->getCommandBuilder();
                    $chunked_array = array_chunk($cdr_data, 5000);
                    $table_name = 'cdr_info';
                    foreach ($chunked_array as $chunk_array){
                        $command = $connection->createMultipleInsertCommand($table_name, $chunk_array);
                        $command->execute();
                        $logMessage = count($chunk_array)." records were inserted in ".$table_name.PHP_EOL;
                        file_put_contents('protected/runtime/insert.log', $logMessage, FILE_APPEND);
                    }
                }
            }
        }
        return "<div align='center'><h3 style='color: green; margin-bottom: 0'>Call Data Records added successfully!!</h3></div>";
    }

    public static function csvToArray($filename = '', $delimiter){
        if(!file_exists($filename) || !is_readable($filename)) return FALSE;
        $header = NULL;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== FALSE ) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header){
                    $header = $row;
                }else{
                    $data_convert_int = [];
                    foreach ($row as $key => $val){
                        if($key == 9){
                            $val = (int)$val;
                        }
                        array_push($data_convert_int,$val);
                    }
                    $data[] = array_combine($header, $data_convert_int);
                }
            }
            fclose($handle);
        }

        return $data;
    }

    public static function fetchFromNumber($month_year, $org_id){
        try{
            $myDateTime = DateTime::createFromFormat('F-Y', $month_year);
            $start = $myDateTime->format('Y-m-01');
            $end = $myDateTime->format('Y-m-t');
            $start_date = $start.' 00:00:00';
            $end_date = $end.' 23:59:59';
            foreach ($org_id as $id){
                $response = self::updateFromNumber($start_date, $end_date, $id);
                $msg = $response['message'] ?? '';
                $log = "Fetch From Number for organization ID: {$id} {$msg}".PHP_EOL;
                file_put_contents('protected/runtime/invoice.log', $log, FILE_APPEND);
            }
        }catch (Exception $e) {
            $log = "fetchFromNumber: {$e->getMessage()}".PHP_EOL;
            file_put_contents('protected/runtime/invoice.log', $log, FILE_APPEND);
        }
    }

    public static function updateFromNumber($start_date, $end_date, $organisation_id){
        $query = Yii::app()->db->createCommand("SELECT DISTINCT(from_id) FROM `cdr_info` WHERE (start_time BETWEEN '$start_date' AND '$end_date') AND from_id != '' AND organisation_id = $organisation_id");
        $cdr_data = $query->queryAll();
        $res_data = [];
        $res = [];
        if(!empty($cdr_data)){
            foreach ($cdr_data as $data){
                $from_id = $data['from_id'];
                $from_numer = '';
                $token = base64_encode(Yii::app()->params['cdr_username'].":".Yii::app()->params['cdr_password']);
                try{
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://rest.pbx.mytelephony.eu/identity/".$from_id,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 90000,
                        CURLOPT_SSL_VERIFYPEER=>false,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Basic ".$token,
                            "content-type: application/json",
                            "Accept: application/vnd.iperity.compass.v3+json"
                        ),
                    ));
                    $response = curl_exec($curl);
                    curl_close($curl);
                    $response = json_decode($response);
                    if(!empty($response)){
                        $resource_number = '';
                        if(isset($response->cli)){
                            $identity_number = explode("/",$response->cli);
                            $resource_number = end($identity_number);
                        }
                    }else{
                        $resource_number = '';
                    }
                    if(!empty($resource_number)){
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => "https://rest.pbx.mytelephony.eu/resource/".$resource_number,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => "",
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 999990,
                            CURLOPT_SSL_VERIFYPEER=>false,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "GET",
                            CURLOPT_HTTPHEADER => array(
                                "Authorization: Basic ".$token,
                                "content-type: application/json",
                                "Accept: application/vnd.iperity.compass.v3+json"
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $response = json_decode($response);
                        if(!empty($response)){
                            $from_numer = $response->number;
                        }
                    }
                    $res = [
                        'status' => 1,
                        'message' => 'Fetch from number completed.'
                    ];
                }catch(Exception $e){
                    $error = $e->getMessage();
                    $res = [
                        'status' => 0,
                        'message' => $error
                    ];
                }
                try{
                    CallDataRecordsInfo::model()->updateAll(array('from_number' => $from_numer), 'from_id=:from_id AND from_number=:from_number',array(':from_id'=>$from_id,'from_number'=>''));
                    $res = [
                        'status' => 1,
                        'message' => "<div align='center'><h3 style='color: green; margin-bottom: 0'>Call data record updated!!</h3></div>"
                    ];
                }catch (Exception $e){
                    $error = $e->getMessage();
                    $res = [
                        'status' => 0,
                        'message' => $error
                    ];
                }
            }
        }
        $res_data = $res;

        return $res_data;
    }

    public static function calculateCost($month_year, $org_id){
        try{
            $myDateTime = DateTime::createFromFormat('F-Y', $month_year);
            $start = $myDateTime->format('Y-m-01');
            $end = $myDateTime->format('Y-m-t');
            $start_date = $start.' 00:00:00';
            $end_date = $end.' 23:59:59';
            foreach ($org_id as $id){
                $response = self::cdrCostCalculate($start_date, $end_date, $id);
                $msg = $response['message'] ?? '';
                $log = "Calculate Cost for organization ID: {$id} {$msg}".PHP_EOL;
                file_put_contents('protected/runtime/invoice.log', $log, FILE_APPEND);
            }
        }catch (Exception $e) {
            $log = "calculateCost: {$e->getMessage()}".PHP_EOL;
            file_put_contents('protected/runtime/invoice.log', $log, FILE_APPEND);
        }
    }

    public static function cdrCostCalculate($start_date, $end_date, $organisation_id){
        set_time_limit(0);
        $query = Yii::app()->db->createCommand("SELECT * FROM `cdr_info` WHERE (start_time BETWEEN '$start_date' AND '$end_date') AND organisation_id = $organisation_id");
        $cdr_data = $query->queryAll();
        $ar = [];
        $res = [];
        $data =[];
        $message = '<div class=row>';
        foreach ($cdr_data as $cdr){
            $model = CallDataRecordsInfo::model()->findByPk($cdr['id']);
            $tonumber = $cdr['to_number'];
            $diff = strtotime($cdr['end_time']) - strtotime($cdr['start_time']);
            $total_time = $diff;
            $fromnumber = $cdr['from_number'];
            /*$tonumber = '3214314051';
            $fromnumber = '3214813909';*/
            $cost_calculate = self::costCalculate($tonumber,$total_time,$fromnumber);
            if($cost_calculate['cost'] == '0.00' && $cost_calculate['comment'] == '-'){
                $message .= "<div class=col-md-6><div class=col-md-12><span style='color: red;>".$tonumber."</span> number not match to CDR cost rules.</div></div>";
            }
            if($total_time <= 0){
                $comment = '-';
            }else{
                $comment = $cost_calculate['comment'];
            }
            $model['unit_cost'] = $cost_calculate['cost'];
            $model['comment'] = $comment;
            $model->save(false);
        }

        $res = [
            'status' => 1,
            'message' => $message."</div><div align='center'><h3 style='color: green; margin-bottom: 0'>Cost calculation completed.</h3></div>"
        ];
        return $res;
    }

    /**
     * @param $tonumber
     * @param $totaltime
     */
    public static function costCalculate($tonumber,$totaltime,$fromnumber){
        $prefix_start_char = substr($tonumber, 0, 2);
        $to_strlen_prefix = strlen($tonumber);
        $from_strlen_prefix = strlen($fromnumber);
        $cost_rules = Yii::app()->db->createCommand("SELECT * FROM `cdr_cost_rules` where digit = ".$to_strlen_prefix." or from_number_digit = ".$from_strlen_prefix." or start_with = SUBSTRING($tonumber,0,LENGTH(start_with)) and from_number_start_with = SUBSTRING($tonumber,0,LENGTH(from_number_start_with)) ORDER BY start_with asc");
        $cost_rules = $cost_rules->queryAll();
        $cost = '0.00';
        $comment = '-';
        foreach ($cost_rules as $rule){
            if($to_strlen_prefix == $rule['digit'] && $from_strlen_prefix == $rule['from_number_digit'] && $rule['from_number_start_with'] == substr($fromnumber, 0, strlen($rule['from_number_start_with']))){
                if(!empty($rule['from_number_digit']) && !empty($rule['from_number_start_with']) && !empty($rule['digit'])) {
                    if($rule['from_number_digit'] == $from_strlen_prefix && $rule['from_number_start_with'] == substr($fromnumber, 0, strlen($rule['from_number_start_with'])) && $rule['digit'] == $to_strlen_prefix){
                        $cost = $rule['cost'];
                        $comment = $rule['comment'];
                    }
                }
            } else if($to_strlen_prefix == $rule['digit']){
                if(empty($rule['from_number_digit']) && empty($rule['start_with'])){
                    $cost = $rule['cost'];
                    $comment = $rule['comment'];
                }if(empty($rule['from_number_digit']) && !empty($rule['start_with'])){
                    if($rule['start_with'] == substr($tonumber, 0, strlen($rule['start_with']))){
                        $cost = $rule['cost'];
                        $comment = $rule['comment'];
                    }
                }if(!empty($rule['from_number_digit']) && empty($rule['start_with'])) {
                    if($rule['from_number_digit'] == $from_strlen_prefix){
                        $cost = $rule['cost'];
                        $comment = $rule['comment'];
                    }
                }
            }
        }
        $result = array('cost'=>round($cost,3),'comment'=>$comment);
        return $result;
    }

    public static function invoiceGenerate($month_year, $organization_id){
        try {
            $data_array = $ids = $selected = [];
            $organization_id = !empty($organization_id) ? implode(",", $organization_id) : [];
            $organisationInfo = Yii::app()->db->createCommand("SELECT * FROM company_info WHERE organisation_id IN ({$organization_id})")->queryAll();
            $month = $month_year;
            $start = date("Y-m-01", strtotime($month));
            $end = date("Y-m-t", strtotime($month));
            if($month != '') {
                $getMonth = date("F, Y", strtotime($month));
            } else {
                $getMonth = '';
            }
            foreach($organisationInfo as $organisation){
                $org_id = $organisation['organisation_id'];
                $ids[] = $org_id;
                $selected[$org_id] = ($getMonth != '') ? $organisation['name'] . ' for ' . $getMonth : $organisation['name'];

                /* National Call */
                $national_call_cdr_data = Yii::app()->db->createCommand("SELECT count(*) as total_time FROM `cdr_info` where organisation_id = " . $org_id . " and (`comment` LIKE '%National Fixed Call%' or `comment` LIKE 'National Mobile Call') and date >= '" . $start . "' and date <= '$end'");
                $national_call_cdr_data = $national_call_cdr_data->queryRow();
                $national_call_total_time = 0;
                $min = '0';
                if(!empty($national_call_cdr_data['total_time']) && $national_call_cdr_data['total_time'] > 0) {
                    $national_call_total_time = $national_call_cdr_data['total_time'];
                    $data_array[$org_id][] = ['is_min' => false,'rule' => 'Setup National call','min' => $national_call_total_time,'total_time' => $national_call_total_time,'cost' => '0.025'];
                }

                /* National Fixed Call */
                $cdr_rules = $model = CdrCostRulesInfo::model()->findByAttributes(['comment' => 'National Fixed Call']);
                $sql_one = "SELECT SEC_TO_TIME(SUM(time_to_sec(total_time))) AS total_time FROM cdr_info WHERE organisation_id = {$org_id} AND `comment` LIKE '%{$cdr_rules->comment}%' AND `date` >= '{$start}' AND `date` <= '{$end}'";
                $national_fixed_call_cdr_data = Yii::app()->db->createCommand($sql_one)->queryRow();

                $time = '00:00:00';
                $min = '0';
                if(!empty($national_fixed_call_cdr_data['total_time'])) {
                    $time = $national_fixed_call_cdr_data['total_time'];
                    $timesplit = explode(':', $time);
                    $min = ($timesplit[0] * 60) + ($timesplit[1]) + (round($timesplit[2] / 60, 2));
                }
                if($min > 0) {
                    $data_array[$org_id][] = ['is_min' => true,'rule' => 'National Fixed call','total_time' => $time,'min' => $min,'cost' => $cdr_rules->cost];
                }

                /* National Mobile Call */
                $cdr_rules_2 = $model = CdrCostRulesInfo::model()->findByAttributes(['comment' => 'National Mobile Call']);
                $sql_two = "SELECT SEC_TO_TIME(SUM(time_to_sec(total_time))) AS total_time FROM cdr_info WHERE organisation_id = {$org_id} AND `comment` LIKE '%{$cdr_rules_2->comment}%' AND `date` >= '{$start}' AND `date` <= '{$end}'";
                $national_mobile_call_cdr_data = Yii::app()->db->createCommand($sql_two)->queryRow();

                $min2 = 0;
                $national_mobile_total_time = '00:00:00';
                if(!empty($national_mobile_call_cdr_data['total_time'])) {
                    $time2 = $national_mobile_call_cdr_data['total_time'];
                    $timesplit2 = explode(':', $time2);
                    $min2 = ($timesplit2[0] * 60) + ($timesplit2[1]) + (round($timesplit2[2] / 60, 2));
                    $national_mobile_total_time = $national_mobile_call_cdr_data['total_time'];
                }
                if($min2 > 0) {
                    $data_array[$org_id][] = ['is_min' => true,'rule' => 'National Mobile call','total_time' => $national_mobile_total_time,'min' => $min2,'cost' => $cdr_rules_2->cost];
                }

                /* International Call */
                $sql_three = "SELECT count(*) AS total_time FROM cdr_info WHERE organisation_id = {$org_id} AND `comment` LIKE '%International%' AND `date` >= '{$start}' AND `date` <= '{$end}'";
                $international_call_cdr_data = Yii::app()->db->createCommand($sql_three)->queryRow();

                $international_call_total_time = 0;
                if(!empty($international_call_cdr_data['total_time']) && $international_call_cdr_data['total_time'] > 0) {
                    $international_call_total_time = $international_call_cdr_data['total_time'];
                    $data_array[$org_id][] = ['is_min' => false,'rule' => 'Setup International call','min' => $international_call_total_time,'total_time' => $international_call_total_time,'cost' => '0.100'];
                }

                //All international call
                $all_international = Yii::app()->db->createCommand("SELECT DISTINCT comment, cost FROM cdr_cost_rules WHERE comment Like '%international call -%'");
                $all_international_cdr_rules = $all_international->queryAll();
                foreach($all_international_cdr_rules as $international_cdr_rule) {
                    $sql_four = "SELECT SEC_TO_TIME(SUM(time_to_sec(total_time))) AS total_time FROM cdr_info WHERE organisation_id = {$org_id} AND `comment` LIKE '%{$international_cdr_rule['comment']}%' AND `date` >= '{$start}' AND `date` <= '{$end}'";
                    $international_cdr_data = Yii::app()->db->createCommand($sql_four)->queryRow();

                    $min3 = 0;
                    $international_total_time = '00:00:00';
                    if(!empty($international_cdr_data['total_time'])) {
                        $time3 = $international_cdr_data['total_time'];
                        $timesplit3 = explode(':', $time3);
                        $min3 = ($timesplit3[0] * 60) + ($timesplit3[1]) + (round($timesplit3[2] / 60, 2));
                        $international_total_time = $international_cdr_data['total_time'];
                    }
                    if($min3 > 0) {
                        $data_array[$org_id][] = ['is_min' => true,'rule' => $international_cdr_rule['comment'],'total_time' => $international_total_time,'min' => $min3,'cost' => $international_cdr_rule['cost']];
                    }
                }

                /* Number Of Users */
                $token = base64_encode(Yii::app()->params['com_username'] . ":" . Yii::app()->params['com_password']);
                $url = 'https://rest.pbx.mytelephony.eu/company/' . $org_id . '/users';
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Basic " . $token,
                        "content-type: application/json",
                        "Accept: application/vnd.iperity.compass.v3+json"
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $response = json_decode($response);
                $numberOfUsers = 0;
                $list = [];
                if(!empty($response)) {
                    $numberOfUsers = (is_array($response) || is_object($response)) ? count($response) : '';
                    foreach($response as $res) {
                        $list[] = $res->entityId;
                    }
                }
                $entityId = implode(', ', $list);
                if($numberOfUsers > 0) {
                    $data_array[$org_id][] = ['is_min' => false,'rule' => 'Number Of Users','min' => $numberOfUsers,'total_time' => $numberOfUsers,'cost' => '8','entityId' => $entityId];
                }

                /* External Numbers */
                $exUrl = 'https://rest.pbx.mytelephony.eu/company/' . $org_id . '/externalNumbers';//https://rest.apollo.compass-stack.com/company
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $exUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Basic " . $token,
                        "content-type: application/json",
                        "Accept: application/vnd.iperity.compass.v3+json"
                    ),
                ));
                $externalNumber = curl_exec($curl);
                curl_close($curl);
                $externalNumber = json_decode($externalNumber);
                $numberOfExternalNumber = 0;
                $resource = [];
                if(!empty($externalNumber)) {
                    $numberOfExternalNumber = (is_array($externalNumber) || is_object($externalNumber)) ? count($externalNumber) : '';
                    foreach($externalNumber as $data) {
                        $resource[] = $data->resourceId;
                    }
                }
                $resourceId = implode(', ', $resource);
                if($numberOfExternalNumber > 0) {
                    $data_array[$org_id][] = ['is_min' => false,'rule' => 'External Numbers','min' => $numberOfExternalNumber,'total_time' => $numberOfExternalNumber,'cost' => '4','resourceId' => $resourceId];
                }
            }

            $res = [
                'details' => $data_array,
                'org_id' => $ids,
                'selected' => $selected
            ];
            echo json_encode($res);
        } catch (Exception $exception) {
            $log = "invoiceGenerate: {$exception->getMessage()}".PHP_EOL;
            file_put_contents('protected/runtime/invoice.log', $log, FILE_APPEND);
        }
    }
}