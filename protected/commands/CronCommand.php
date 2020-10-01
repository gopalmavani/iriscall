<?php

class CronCommand extends CConsoleCommand
{
    public function actionCronExecute()
    {
        $variable_from_file = (int)file_get_contents(Yii::app()->getbaseUrl() . '/count.txt');
        $next = $variable_from_file + 1;
        if (file_put_contents(Yii::app()->getbaseUrl() . '/count.txt', $next) === false) {
            die("Error");
        }
        file_put_contents(Yii::app()->getbaseUrl() . '/count.txt', $next);
    }
}
