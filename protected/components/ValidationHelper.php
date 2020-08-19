<?php

/**
 * Created by PhpStorm.
 * User: imyuvii
 * Date: 27/10/16
 * Time: 7:39 PM
 */
class ValidationHelper
{
    /**
     * Validation
     * @param $email, $date, $number
     * @return true
     */

    public static function ValidateEmail($email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
           return "Invalid Email";
        }

    }

    public static function ValidatePhoneNumber($phone){
        if (!is_numeric($phone) || strlen($phone) < 10) {
            return "Invalid Phone Number";
        }
    }

    public static function ValidateDOB($number){
        $date_arr = preg_split( "(-|/)", $number );
        if (!checkdate($date_arr[0], $date_arr[1], $date_arr[2])) {
            return "Invalid Date of birth";
        }
    }


}