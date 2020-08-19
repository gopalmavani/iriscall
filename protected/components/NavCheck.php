<?php

/**
 * Created by PhpStorm.
 * User: deepak
 * Date: 5/12/16
 * Time: 1:00 PM
 */
class NavCheck
{
    public static function navigationCheck()
    {
        $userChk = Yii::app()->db->schema->getTable('user_info')?'yes':'no';
        $rolesChk = Yii::app()->db->schema->getTable('roles')?'yes':'no';
        $proChk = Yii::app()->db->schema->getTable('product_info')?'yes':'no';
        $orderChk = Yii::app()->db->schema->getTable('order_info')?'yes':'no';
        $walletChk = Yii::app()->db->schema->getTable('wallet')?'yes':'no';
        $eventChk = Yii::app()->db->schema->getTable('events')?'yes':'no';
        $poolChk = Yii::app()->db->schema->getTable('pool_plan')?'yes':'no';
        $compenChk = Yii::app()->db->schema->getTable('compensations_plan')?'yes':'no';
        $htmlbuilder = is_file(Yii::getPathOfAlias('application.modules.admin.views.layouts.builder').'.php')?'yes':'no';

        if ($userChk == "yes"){
            $usernav = "";
        }else{
            $usernav = "user-nav";
        }
        if ($rolesChk == "yes"){
            $rolesnav = "";
        }else{
            $rolesnav = "roles-nav";
        }
        if ($proChk == "yes"){
            $productnav = "";
        }else{
            $productnav = "product-nav";
        }

        if ($orderChk == "yes"){
            $ordernav = "";
        }else{
            $ordernav = "order-nav";
        }

        if ($walletChk == "yes"){
            $walletnav = "";
        }else{
            $walletnav = "wallet-nav";
        }

        if ($eventChk == "yes"){
            $eventnav = "";
        }else{
            $eventnav = "wallet-nav";
        }


        if ($poolChk== "yes"){
            $poolnav = "";
        }else{
            $poolnav = "pool-nav";
        }

        if ($compenChk == "yes"){
            $compennav = "";
        }else{
            $compennav = "compen-nav";
        }

        if ($htmlbuilder == "yes"){
            $buildernav = "";
        }else{
            $buildernav = "builder-nav";
        }

        $navigation = [
            'user' => $usernav,
            'roles' => $rolesnav,
            'product' => $productnav,
            'order' => $ordernav,
            'wallet' => $walletnav,
            'event' => $eventnav,
            'pool' => $poolnav,
            'compensation' => $compennav,
            'builder' => $buildernav,
        ];

        return $navigation;
    }


    public static function menuCheck()
    {
        $userChk = Yii::app()->db->schema->getTable('user_info')?'yes':'no';
        $proChk = Yii::app()->db->schema->getTable('product_info')?'yes':'no';
        $orderChk = Yii::app()->db->schema->getTable('order_info')?'yes':'no';
        $eventChk = Yii::app()->db->schema->getTable('events')?'yes':'no';
        $walletChk = Yii::app()->db->schema->getTable('wallet')?'yes':'no';
        $ticketChk = Yii::app()->db->schema->getTable('ticketing')?'yes':'no';

        if ($userChk == "yes"){
            $usernav = "";
        }else{
            $usernav = "no-user-table";
        }

        if ($proChk == "yes"){
            $productnav = "";
        }else{
            $productnav = "no-product-table";
        }

        if ($orderChk == "yes"){
            $ordernav = "";
        }else{
            $ordernav = "no-order-table";
        }

        if ($eventChk == "yes"){
            $eventChk = "";
        }else{
            $eventChk = "no-event-table";
        }

        if ($walletChk == "yes"){
            $walletnav = "";
        }else{
            $walletnav = "no-wallet-table";
        }

        if ($ticketChk == "yes"){
            $ticketnav = "";
        }else{
            $ticketnav = "no-ticket-table";
        }

        /*if ($poolChk== "yes"){
            $poolnav = "";
        }else{
            $poolnav = "pool-nav";
        }

        if ($compenChk == "yes"){
            $compennav = "";
        }else{
            $compennav = "compen-nav";
        }*/

        $navigation = [
            'user' => $usernav,
            'product' => $productnav,
            'order' => $ordernav,
            'event' => $eventChk,
            'wallet' => $walletnav,
            'ticket' => $ticketnav,
            /*'pool' => $poolnav,
            'compensation' => $compennav,*/
        ];

        return $navigation;
    }

    public static function MenuItems(){
        $MenuTables=CylTables::model()->findAll(
            array(
                'condition'=>'isMenu="1" AND display_status = "1"',
                'order'=>'menu_order'
            ));
        //  $MenuTables = CylTables::model()->findAllByAttributes(['isMenu' => 1, 'display_status' => 1]);
        return $MenuTables;
    }

}