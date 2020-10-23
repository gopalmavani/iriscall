<?php
class SSOHelper extends CApplicationComponent {

    /*
     * Modify data for update flow
     * */
    public static function modifyPostDataWRTSSO($data){
        if(isset($data['new_password'])){
            self::setUnsetData($data, 'new_password', 'password');
        } elseif (isset($data['email']['notification-mail'])) {
            $data['allow_notification_mail'] = $data['email']['notification-mail'];
            unset($data['email']['notification-mail']);

            if(isset($data['email']['market-mail'])){
                $data['allow_marketing_mail'] = $data['email']['market-mail'];
                unset($data['email']['market-mail']);
            }
        } elseif (isset($data['payout'])){
            $temp = $data['payout'];
            $data = $temp;
            self::setUnsetData($data, 'bank_building_num', 'bank_building_number');
            self::setUnsetData($data, 'bank_iban', 'iban');
            self::setUnsetData($data, 'bank_bic', 'bic_code');
        } else {
            self::setUnsetData($data, 'private_disclouser', 'is_privacy_disclosure');
            if(isset($data['businesstype']) && ($data['businesstype'] == 1)){
                $data['business_name'] = "";
                $data['vat_number'] = "";
                $data['busAddress_building_num'] = "";
                $data['busAddress_street'] = "";
                $data['busAddress_region'] = "";
                $data['busAddress_city'] = "";
                $data['busAddress_postcode'] = "";
                $data['busAddress_country'] = "";
            } else {
                if(!isset($data['is_different_address']) && isset($data['building_num'])){
                    $data['busAddress_building_num'] = $data['building_num'];
                    $data['busAddress_street'] = $data['street'];
                    $data['busAddress_region'] = $data['region'];
                    $data['busAddress_city'] = $data['city'];
                    $data['busAddress_postcode'] = $data['postcode'];
                    $data['busAddress_country'] = $data['country'];
                }
            }
            self::setUnsetData($data, 'building_num', 'building_number');
            self::setUnsetData($data, 'busAddress_building_num', 'business_building_number');
            self::setUnsetData($data, 'busAddress_city', 'business_city');
            self::setUnsetData($data, 'busAddress_street', 'business_street');
            self::setUnsetData($data, 'busAddress_postcode', 'business_postcode');
            self::setUnsetData($data, 'busAddress_region', 'business_building_number');
            self::setUnsetData($data, 'busAddress_country', 'business_country');
        }
        //Mandatory for all requests
        $data['application'] = Yii::app()->params['applicationName'];
        $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->getId()]);
        if(!isset($data['email'])){
            $data['email'] = $user->email;
        }
        if(!isset($data['api_token'])){
            $data['token'] = $user->api_token;
        }
        return $data;
    }

    /*
     * Modify data for update flow
     * */
    public static function modifyPostDataWRTCBM($data){
        self::setUnsetData($data, 'bank_building_number', 'bank_building_num');
        self::setUnsetData($data, 'iban', 'bank_iban');
        self::setUnsetData($data, 'bic_code', 'bank_bic');
        self::setUnsetData($data, 'building_number', 'building_num');
        self::setUnsetData($data, 'business_building_number', 'busAddress_building_num');
        self::setUnsetData($data, 'business_city', 'busAddress_city');
        self::setUnsetData($data, 'business_street', 'busAddress_street');
        self::setUnsetData($data, 'business_postcode', 'busAddress_postcode');
        self::setUnsetData($data, 'business_building_number', 'busAddress_region');
        self::setUnsetData($data, 'business_country', 'busAddress_country');
        return $data;
    }

    /*
     * Modify data for new registration flow
     * */
    public static function modifyPostDataWRTSSOForNewUser($data){
        //To remove first level depth of the user-info
        $temp = $data['UserInfo'];
        unset($data['UserInfo']);
        $data = array_merge($data, $temp);

        self::setUnsetData($data, 'building_num', 'building_number');
        //$data['date_of_birth'] = date('Y-m-d', strtotime($data['date_of_birth']));

        if(!empty($data['business_name'])){
            if (isset($data['sameAddress'])) {
                $data['busAddress_building_num'] = $data['building_number'];
                $data['busAddress_street'] = $data['street'];
                $data['busAddress_region'] = $data['region'];
                $data['busAddress_city'] = $data['city'];
                $data['busAddress_postcode'] = $data['postcode'];
                $data['busAddress_country'] = $data['country'];
            }
            self::setUnsetData($data, 'busAddress_building_num', 'business_building_number');
            self::setUnsetData($data, 'busAddress_city', 'business_city');
            self::setUnsetData($data, 'busAddress_street', 'business_street');
            self::setUnsetData($data, 'busAddress_postcode', 'business_postcode');
            self::setUnsetData($data, 'busAddress_region', 'business_region');
            self::setUnsetData($data, 'busAddress_country', 'business_country');
        }

        self::setUnsetData($data, 'payout_bank', 'bank_name');
        self::setUnsetData($data, 'payout_street', 'bank_street');
        self::setUnsetData($data, 'payout_house', 'bank_building_number');
        self::setUnsetData($data, 'payout_post', 'bank_postcode');
        self::setUnsetData($data, 'payout_city', 'bank_city');
        self::setUnsetData($data, 'payout_region', 'bank_region');
        self::setUnsetData($data, 'payout_country', 'bank_country');
        self::setUnsetData($data, 'payout_accountname', 'account_name');
        self::setUnsetData($data, 'payout_iban', 'iban');
        self::setUnsetData($data, 'payout_biccode', 'bic_code');

        self::setUnsetData($data, 'notification-mail', 'allow_notification_mail');
        self::setUnsetData($data, 'market-mail', 'allow_marketing_mail');
        self::setUnsetData($data, 'privacy', 'is_privacy_disclosure');

        if(isset($data['allow_notification_mail']) && $data['allow_notification_mail'] == 'on'){
            $data['allow_notification_mail'] = 1;
        } else {
            $data['allow_notification_mail'] = 0;
        }
        if(isset($data['allow_marketing_mail']) && $data['allow_marketing_mail'] == 'on'){
            $data['allow_marketing_mail'] = 1;
        } else {
            $data['allow_marketing_mail'] = 0;
        }
        if(isset($data['is_privacy_disclosure']) && $data['is_privacy_disclosure'] == 'on'){
            $data['is_privacy_disclosure'] = 1;
            $data['is_terms_and_conditions'] = 1;
        } else {
            $data['is_privacy_disclosure'] = 0;
            $data['is_terms_and_conditions'] = 0;
        }

        //Mandatory for all requests
        $data['application'] = Yii::app()->params['applicationName'];
        $data['registered_at'] = date('Y-m-d H:i:s');

        return $data;
    }

    /*
     * Modify data for users moving from MMC to SIO for the first time
     * */
    public static function modifyDataWRTSSOForLogin($data){
        $temp = $data['userInfo'];
        self::setUnsetData($temp, 'busAddress_building_num', 'business_building_number');
        self::setUnsetData($temp, 'busAddress_city', 'business_city');
        self::setUnsetData($temp, 'busAddress_street', 'business_street');
        self::setUnsetData($temp, 'busAddress_postcode', 'business_postcode');
        self::setUnsetData($temp, 'busAddress_region', 'business_building_number');
        self::setUnsetData($temp, 'busAddress_country', 'business_country');

        self::setUnsetData($temp, 'notification_mail', 'allow_notification_mail');
        self::setUnsetData($temp, 'marketting_mail', 'allow_marketing_mail');
        self::setUnsetData($temp, 'privacy_disclosure', 'is_privacy_disclosure');
        $temp['registered_at'] = $temp['created_at'];
        unset($temp['password']);
        $data['userInfo'] = $temp;

        if(isset($data['payoutInfo'])){
            $temp = $data['payoutInfo'];
            self::setUnsetData($temp, 'payout_bank', 'bank_name');
            self::setUnsetData($temp, 'payout_street', 'bank_street');
            self::setUnsetData($temp, 'payout_house', 'bank_building_number');
            self::setUnsetData($temp, 'payout_post', 'bank_postcode');
            self::setUnsetData($temp, 'payout_city', 'bank_city');
            self::setUnsetData($temp, 'payout_region', 'bank_region');
            self::setUnsetData($temp, 'payout_country', 'bank_country');
            self::setUnsetData($temp, 'payout_accountname', 'account_name');
            self::setUnsetData($temp, 'payout_iban', 'iban');
            self::setUnsetData($temp, 'payout_biccode', 'bic_code');
            $data['payoutInfo'] = $temp;
        }

        return $data;
    }

    public static function setUnsetData(&$data, $columnName, $newColumnName){
        if(isset($data[$columnName])){
            $data[$newColumnName] = $data[$columnName];
            unset($data[$columnName]);
        }
    }
}