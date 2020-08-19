<?php

class CronHelper extends CApplicationComponent {

    public static function addCronLogs($cron_id, $log, $stack_trace, $status, $start_time, $end_time){
        $cron_log = new CronLogs();
        $cron_log->cron_id = $cron_id;
        $cron_log->log = $log;
        $cron_log->stack_trace = $stack_trace;
        $cron_log->status = $status;
        $cron_log->start_time = $start_time;
        $cron_log->end_time = $end_time;
        $cron_log->save(false);
    }

    public static function cronDataInsert($table_name, $data){
        $connection = Yii::app()->db->getSchema()->getCommandBuilder();
        $chunked_array = array_chunk($data, 1000);
        foreach ($chunked_array as $chunk_array){
            $command = $connection->createMultipleInsertCommand($table_name, $chunk_array);
            $command->execute();
        }
    }

    public static function fakeDepositArray(){
        $fakeDeposits = Yii::app()->db->createCommand()
            ->select('email')
            ->from('cbm_deposit_withdraw')
            ->where(['or like', 'comment', ['%fake%', '%MMC%']])
            ->andWhere('profit>=:pf',[':pf'=>50])
            ->queryColumn();
        return $fakeDeposits;
        /*$fakeDepositArr = ["agneszohlandt@hotmail.com","dirk.vanhoudt@dvv.be","ria_coemans@hotmail.com",
            "tom.geypens@gmail.com","ilse.vantongerloo@gmail.com","cjv.selleslaghs@telfort.nl",
            "inge_creyf@hotmail.com","info@grcars.be","math.houben@hotmail.com","yves.hulin@telenet.be",
            "demer136@gmail.com","koolen.gjpm@gmail.com","w.a.bouwense@gmail.com","vaniwaar@zeelandnet.nl",
            "henny.raadschilders@kpnmail.nl","desleyleclaire@home.nl","marlies@4sys.nl","bovytrading@hotmail.com"];
        return $fakeDepositArr;*/
    }
}