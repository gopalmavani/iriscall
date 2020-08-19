<?php

class ServiceHelper extends CApplicationComponent
{
    public function syncDataWithFB()
    {
        /*$model = SyncFb::model()->findByPk(1);*/
        $model = Settings::model()->findByAttributes(['module_name' => "Facebook Feed", 'settings_key' => "clientId"]);
        $model1 = Settings::model()->findByAttributes(['module_name' => "Facebook Feed", 'settings_key' => "clientSecretId"]);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => Yii::app()->params['FBUrl'] . "?client_id=" . $model->value .
                "&client_secret=" . $model1->value . "&grant_type=" . Yii::app()->params['FBGrantType'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function getDataFromFB($accessToken, $minDate)
    {
        /*$model = SyncFb::model()->findByPk(1);*/
        $model2 = Settings::model()->findByAttributes(['module_name' => "Facebook Feed", 'settings_key' => "pageId"]);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://graph.facebook.com/v2.9/" . $model2->value .
                "/posts?fields=picture%2Cmessage%2Ccreated_time%2Cfrom&access_token=" . $accessToken . "&since=" . $minDate,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public static function apiGoMarket($request, $end_point)
    {
        $curl = curl_init();

        // curl call
        curl_setopt_array($curl, array(
            CURLOPT_URL => Yii::app()->params['mt4ServiceUrl'] . $end_point,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 500,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $request,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ));
        $rt = curl_exec($curl);
        $info = curl_getinfo($curl);
        $httpcode = $info["http_code"];

        /*based on statuscode add api log to mmc_api_log*/
        if ($httpcode != 200) {
            $log = new CbmLogs();
            $log->status = 0;
            $log->created_date = date('Y-m-d H:i:s', strtotime("-1 days"));
            $log->log = "cURL Error #:" . substr(curl_exec($curl), 0, 200);
            $log->save(false);
            $data = array();
            $data['result'] = false;
            $data['error'] = json_decode($rt, true);
            return $data;
        } else {
            $data = array();
            $data['result'] = true;
            $data['data'] = CJSON::decode($rt, true);
            curl_close($curl);
            return $data;
        }
    }

    /*Get Country*/
    public static function getCountryNameFromId($id)
    {
        $country = Countries::model()->findByAttributes(['id' => $id]);
        if (!isset($country->id))
            return "";
        else
            return $country->country_name;
    }

    /*Get Country From Country Code*/
    public static function getCountryNameFromCode($Country_code)
    {
        // print_r($Country_code);die;
        $country = Countries::model()->findByAttributes(['country_code' => $Country_code]);
        // print_r($country->id);die;
        if (!isset($country->id))
            return "";
        else
            return $country->id;
    }

    /*List Of Countries*/
    public function getNationalOptions()
    {
        return array(
            "AF" => "Afghanistan",
            "AX" => "Aland Islands",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia, Plurinational State of",
            "BQ" => "Bonaire, Sint Eustatius and Saba",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "IO" => "British Indian Ocean Territory",
            "BN" => "Brunei Darussalam",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos (Keeling) Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo",
            "CD" => "Congo, the Democratic Republic of the",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "CI" => "Côte d'Ivoire",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CW" => "Curaçao",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands (Malvinas)",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and McDonald Islands",
            "VA" => "Holy See (Vatican City State)",
            "HN" => "Honduras",
            "HK" => "Hong Kong",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran, Islamic Republic of",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KP" => "Korea, Democratic People's Republic of",
            "KR" => "Korea, Republic of",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Lao People's Democratic Republic",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macao",
            "MK" => "Macedonia, the former Yugoslav Republic of",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "MX" => "Mexico",
            "FM" => "Micronesia, Federated States of",
            "MD" => "Moldova, Republic of",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territory, Occupied",
            "PA" => "Panama",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RE" => "Réunion",
            "RO" => "Romania",
            "RU" => "Russian Federation",
            "RW" => "Rwanda",
            "BL" => "Saint Barthélemy",
            "SH" => "Saint Helena, Ascension and Tristan da Cunha",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin (French part)",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "ST" => "Sao Tome and Principe",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SX" => "Sint Maarten (Dutch part)",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "SS" => "South Sudan",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syrian Arab Republic",
            "TW" => "Taiwan, Province of China",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania, United Republic of",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "UM" => "United States Minor Outlying Islands",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VE" => "Venezuela, Bolivarian Republic of",
            "VN" => "Viet Nam",
            "VG" => "Virgin Islands, British",
            "VI" => "Virgin Islands, U.S.",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe",
        );
    }

    public static function getCountry()
    {
        $result = array();
        $countries = Countries::model()->findAll();
        foreach ($countries as $value) {
            $country[$value->id] = $value->country_name;

        }
        return $country;
    }

    /* for the Name hide after some words*/
    public static function hideStringGenealogy($id)
    {
        $userDetail = UserInfo::model()->findByPk($id);
        $end = str_repeat('*', strlen(substr($userDetail->full_name, 3)));
        $begin = substr($userDetail->full_name, 0, 3);
        return $begin . $end;
    }

    /* for the Email hide after some words*/
    public static function hideEmailGenealogy($id)
    {
        $userDetail = UserInfo::model()->findByPk($id);
        $mail_segments = explode("@", $userDetail->email);
        $mail_segments[0] = str_repeat("*", strlen($mail_segments[0]));
        return implode("@", $mail_segments);
    }
    
    //To get Transaction Status
    public static function getTransactionStatusDetails($tran_status, $tran_type, $reference_id){
        //For Affiliate earnings commission scheme
        $affiliate_reference = WalletMetaEntity::model()->findByAttributes(['reference_key'=>'Affiliate Commission']);
        if($tran_status == 0)
            $response = "<span class='kt-badge kt-badge--inline kt-badge--danger'>Pending</span>";
        elseif ($tran_status == 1)
            $response = "<span class='kt-badge kt-badge--inline kt-badge--success'>On Hold</span>";
        elseif ($tran_status == 2){
            if(($tran_type == Yii::app()->params['DebitTransactionType']) && ($reference_id == $affiliate_reference->reference_id)){
                $response = "<span class='kt-badge kt-badge--inline kt-badge--danger'>Refunded</span>";
            } else {
                $response = "<span class='kt-badge kt-badge--inline kt-badge--success'>Approved</span>";
            }
        } else
            $response = "<span class='kt-badge kt-badge--inline kt-badge--warning'>Rejected</span>";
        return $response;
    }

    //To get payout Settings
    public static function getPayoutSettings($reserve_wallet_commission_status){
        if($reserve_wallet_commission_status == 0)
            $response = "100%  Commission payout";
        elseif ($reserve_wallet_commission_status == 1)
            $response = "50% Commission payout / 50% In reserve for pending order";
        else
            $response = "100% In reserve for pending order";
        return $response;
    }

    /*
     * Add to CBM User Licenses
     * If already present, modify if required
     * */
    public static function modifyCBMUserLicenses($userId, $email, $totalLicenses, $availableLicenses)
    {
        $cbm_user_license = CbmUserLicenses::model()->findByAttributes(['email' => $email]);
        if (isset($cbm_user_license->email)) {
            if (($cbm_user_license->user_id == 0) || empty($cbm_user_license->user_id))
                $cbm_user_license->user_id = $userId;
            $cbm_user_license->total_licenses += $totalLicenses;
            $cbm_user_license->available_licenses += $availableLicenses;
            $cbm_user_license->modified_at = date('Y-m-d H:i:s');
            $cbm_user_license->save(false);
        } else {
            //Add to CBM User License
            $cbm_user_licenses = new CbmUserLicenses();
            $cbm_user_licenses->user_id = $userId;
            $cbm_user_licenses->email = $email;
            $cbm_user_licenses->total_licenses = $totalLicenses;
            $cbm_user_licenses->available_licenses = $availableLicenses;
            $cbm_user_licenses->created_at = date('Y-m-d H:i:s');
            $cbm_user_licenses->save(false);
        }
    }

    /*
     * Update user status based upon step Number and email
     * */
    public static function updateUserStatus($email, $step_number, $productId){
        $registration_status = RegistrationStatus::model()->findByAttributes(['email' => $email, 'product_id' => $productId]);

        if(isset($registration_status->email)){
            $registration_status->step_number = $step_number;
            $registration_status->modified_at = date('Y-m-d H:i:s');
        } else {
            $user = UserInfo::model()->findByAttributes(['email'=>$email]);
            $registration_status = new RegistrationStatus();
            if(isset($user->email))
                $registration_status->user_id = $user->user_id;
            $registration_status->product_id = $productId;
            $registration_status->email = $email;
            $registration_status->step_number = $step_number;
        }
        $registration_status->save(false);
    }

    /*
     * Get email from string
     * */
    public static function extract_emails_from($string){
        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
        return $matches[0];
    }

    /*
     * Mapping of Jira ticket status and database status
     * */
    public static function getMappedStatus($status){
        if($status == 'New registration')
            $db_status = 'CBM REGISTRATION';
        elseif ($status == 'License paid')
            $db_status = 'BUYING LICENSES';
        elseif ($status == 'Infinox Registration')
            $db_status = 'MANAGED ACCOUNT REGISTRATION WITH INFINOX';
        elseif ($status == 'Infinox KYC')
            $db_status = 'MANAGED ACCOUNT KYC';
        elseif ($status == 'Setup account')
            $db_status = 'SETUP ACCOUNT AND ACCOUNT NUMBER';
        elseif ($status == 'LPOA signed')
            $db_status = 'SIGNING THE LPOA';
        elseif ($status == 'Account funded')
            $db_status = 'FUNDING YOUR ACCOUNT';
        elseif ($status == 'Check account')
            $db_status = 'ACCOUNT ACTIVATION';
        else
            $db_status = '';

        return $db_status;
    }

    /*
     * Get Infinox name from login
     * */
    public static function getInfinoxName($login){
        $mt4Account = CbmAccounts::model()->findByPk($login);
        if(isset($mt4Account->agent)){
            $agent = AgentInfo::model()->findByAttributes(['agent_number'=>$mt4Account->agent]);
            return $agent->agent_name;
        } else {
            return " ";
        }
    }

    /*
     * Get mt4 account from session Login
     * */
    public static function getMt4Acoount($email){
        if(isset($_SESSION['loginId'])){
            $loginId = $_SESSION['loginId'];
            $account_login = CbmAccounts::model()->findByAttributes(['email_address' => $email, 'login' => $loginId]);
        } else {
            $account_login = '';
        }
        return $account_login;
    }

    /*
     * Get EU countries
     * */
    public static function getEUCountries(){
        $EUCountries = ["Austria","Italy","Belgium","Latvia","Bulgaria","Lithuania","Croatia (Hrvatska)","Luxembourg","Cyprus","Malta","Czech Republic","Netherlands","Denmark","Poland","Estonia","Portugal","Finland","Romania","France","Slovakia","Germany","Slovenia","Greece","Spain","Hungary","Sweden","Ireland","United Kingdom"];
        $EUCountryId = [];
        foreach ($EUCountries as $EUCountry){
            $tempCountry = Countries::model()->findByAttributes(['country_name'=>$EUCountry]);
            array_push($EUCountryId, $tempCountry->id);
        }
        return $EUCountryId;
    }

    /*
     * Check whether country is in EU or not
     * */
    public static function isEUCountry($countryId){
        $euCountries = ServiceHelper::getEUCountries();
        if(in_array($countryId, $euCountries)){
            return true;
        } else {
            return false;
        }
    }
    
    /*
     * Get discounted license price and other relevant details
     * */
    public static function getDiscountedPrice($quantity, $productId){
        $product = ProductInfo::model()->findByAttributes(['product_id' => $productId]);
        switch ($quantity){
            case ($quantity >= 15 && $quantity <= 62):
                $itemTotal = $product->price*$quantity;
                $d_price = $itemTotal*10 / 100;
                $subTotal = $itemTotal-$d_price;
                $itemPrice = $product->price - ($product->price * 10/100);
                $result = ['subTotal'=>$subTotal,'discount'=>$d_price,'product_id'=>$productId, 'item_price'=>$itemPrice];
                break;
            case ($quantity >= 63 && $quantity <= 126):
                $itemTotal = $product->price*$quantity;
                $d_price = $itemTotal*20 / 100;
                $subTotal = $itemTotal-$d_price;
                $itemPrice = $product->price - ($product->price * 20/100);
                $result = ['subTotal'=>$subTotal,'discount'=>$d_price,'product_id'=>$productId, 'item_price'=>$itemPrice];
                break;
            case ($quantity >= 127 && $quantity <= 255):
                $itemTotal = $product->price*$quantity;
                $d_price = $itemTotal*30 / 100;
                $subTotal = $itemTotal-$d_price;
                $itemPrice = $product->price - ($product->price * 30/100);
                $result = ['subTotal'=>$subTotal,'discount'=>$d_price,'product_id'=>$productId, 'item_price'=>$itemPrice];
                break;
            case ($quantity > 255):
                $itemTotal = $product->price*$quantity;
                $d_price = $itemTotal*40 / 100;
                $subTotal = $itemTotal-$d_price;
                $itemPrice = $product->price - ($product->price * 40/100);
                $result = ['subTotal'=>$subTotal,'discount'=>$d_price,'product_id'=>$productId, 'item_price'=>$itemPrice];
                break;
            default:
                $itemTotal = $product->price*$quantity;
                $d_price = 0;
                $subTotal = $itemTotal;
                $itemPrice = $product->price;
                $result = ['subTotal'=>$subTotal,'discount'=>$d_price,'product_id'=>$productId, 'item_price'=>$itemPrice];
                break;
        }
        return $result;
    }
}
