<?php

class CBMActivityHelper extends CApplicationComponent {

    public static function createCBMActivity($userId, $referenceId, $referenceDataOne, $referenceDataTwo, $referenceDataThree, $comment, $time){
        $cbmActivity = new CbmActivity();
        $cbmActivity->user_id = $userId;
        $cbmActivity->reference_id = $referenceId;
        $cbmActivity->reference_data_1 = $referenceDataOne;
        $cbmActivity->reference_data_2 = $referenceDataTwo;
        $cbmActivity->reference_data_3 = $referenceDataThree;
        $cbmActivity->comment = $comment;
        $cbmActivity->created_at = $time;
        $cbmActivity->save(false);
    }

}
