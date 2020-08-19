<?php

class ContactusController extends Controller
{
    public $layout = 'main';
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    protected function beforeAction($action)
    {
        if (Yii::app()->user->isGuest){
            $this->redirect(Yii::app()->createUrl('home/login'));
        }/* else{
            $user = UserInfo::model()->findByAttributes(['user_id' => Yii::app()->user->id]);
            if ($action->id != 'login'){
                if (Yii::app()->session['userid'] != $user->password){
                    $this->redirect(Yii::app()->createUrl('home/login'));
                }
            }
        }*/
        return parent::beforeAction($action);

    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * This is ajax action to load event in popup
     */
    public function actionViewEvent()
    {

        $events = Events::model()->findByAttributes(['event_id' => $_POST['event_id'] ]);
        if ($events) {
            $users = explode(',', $events->user_id);
            $Name = array();
            foreach($users as $user) {
                if($user != 'all'){
                    $userName = UserInfo::model()->findByAttributes(['user_id' => $user]);
                    $Name[] = $userName->full_name;
                }else{
                    $Name[] = "All users are invited";
                }
            };
            $invited_user = implode(', ', $Name);

            echo json_encode([
                'token' => 1,
                'data' => [
                    'title' => $events->event_title,
                    'host' => $events->event_host,
                    'start' => $events->event_start,
                    'end' => $events->event_end,
                    'description' => $events->event_description,
                    'location' => $events->event_location,
                    'users' => $invited_user,
                ]
            ]);
        } else {
            echo json_encode([
                'token' => 0,
            ]);
        }

    }

}