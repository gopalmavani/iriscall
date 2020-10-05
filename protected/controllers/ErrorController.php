<?php

class ErrorController extends Controller
{
    public $layout = 'errors';

    /**
     * @param $id
     * This is action opens forum page for specific ticket.
     */
    /**
     * for error display page 
     */
    public function actionIndex()
    {
        $error=Yii::app()->errorHandler->error;
        $this->render('index',['error'=>$error]);
        
    }
}
