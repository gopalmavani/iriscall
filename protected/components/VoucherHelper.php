<?php

class VoucherHelper extends CApplicationComponent {

    public static function getAvailableVouchers($email){
        $current_time = date('Y-m-d H:i:s');

        $available_vouchers = Yii::app()->db->createCommand()
            ->select('*')
            ->from('voucher_info')
            ->where('email=:ea',[':ea'=>$email])
            ->andWhere('start_time <= :st', [':st'=>$current_time])
            ->andWhere('end_time >= :et', [':et'=>$current_time])
            ->andWhere('voucher_status = :vs', [':vs'=>1])
            ->andWhere('redeemed_at is null')
            ->andWhere('order_info_id is null')
            ->queryAll();

        return $available_vouchers;
    }

    public static function validateCouponCode($coupon_code, $email){
        $current_time = date('Y-m-d H:i:s');

        $voucher = Yii::app()->db->createCommand()
            ->select('*')
            ->from('voucher_info')
            ->where('email=:ea',[':ea'=>$email])
            ->andWhere('voucher_code=:vc', [':vc'=>$coupon_code])
            ->andWhere('start_time <= :st', [':st'=>$current_time])
            ->andWhere('end_time >= :et', [':et'=>$current_time])
            ->andWhere('voucher_status = :vs', [':vs'=>1])
            ->andWhere('redeemed_at is null')
            ->queryRow();

        return $voucher;
    }

    public static function updateVoucherToSuccess($voucher_code, $orderInfoId){
        $voucher = VoucherInfo::model()->findByAttributes(['voucher_code' => $voucher_code]);
        $order = OrderInfo::model()->findByPk($orderInfoId);
        $voucher->redeemed_at = date('Y-m-d H:i:s');
        $voucher->user_id = $order->user_id;
        $voucher->order_info_id = $orderInfoId;
        $voucher->voucher_status = 0;
        $voucher->modified_at = date('Y-m-d H:i:s');
        $voucher->save(false);
    }

    public static function random_strings($length_of_string){
        // String of all alphanumeric character
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str_result),
            0, $length_of_string);
    }

    public static function voucherMail($voucher_code){
        $voucher = VoucherInfo::model()->findByAttributes(['voucher_code' => $voucher_code]);
        $user = UserInfo::model()->findByPk($voucher->user_id);
        $dashBoardUrl = Yii::app()->createAbsoluteUrl('home/index');
        $mail = new YiiMailer('voucher-creation', [
            'full_name' => $user->full_name,
            'first_name' => $user->first_name,
            'dashBoardURL' => $dashBoardUrl,
            'email' => $user->email,
            'voucher_code' => $voucher_code,
            'voucher_validity' => $voucher->end_time
        ]);
        $mail->setFrom('info@cbmglobal.io', 'CBM Global');
        $mail->setSubject("Voucher Confirmation");
        $mail->setTo($user->email);
        $mail->send();
    }

}