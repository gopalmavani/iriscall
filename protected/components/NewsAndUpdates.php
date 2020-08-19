<?php

class NewsAndUpdates extends CWidget {

    public $data;
    public $dateArray;

    public function init()
    {

        // this method is called by CController::beginWidget()
        $this->data = Yii::app()->db->createCommand()
            ->select('*')
            ->from('fb_feed')
            ->where('is_enabled = 1')
            ->queryAll();

        foreach($this->data as $dt)
        {
            $newDate = $this->time_elapsed_string($dt['created_at']);
            $this->dateArray[$dt['id']] = $newDate;
        }
    }


    public function run()
    {
        // this method is called by CController::endWidget()
        $this->render('newsAndUpdates');
    }


    public function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}