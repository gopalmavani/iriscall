<?php

/**
 * AutoLoginForm class.
 * AutoLoginForm is the data structure for keeping
 * user login form data. It is used by the 'Autologin' action of 'SiteController'.
 */
class AutoLoginForm extends CFormModel
{
    public $email;
    private $_identity;
    public $rememberMe;


    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */

    public function rules()
    {
        return array(
            // username and password are required
            array('email', 'required'),
            array('email', 'email', 'message' => "The email is not correct"),
            array('email', 'authenticate1'),
        );
    }


    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $this->_identity = new AutoLogin($this->email, null);
            if (!$this->_identity->authenticate())
                $this->addError('email', 'Incorrect Email or password.');
        }
    }

    public function authenticate1($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $models = UserInfo::model()->findAllByAttributes(array('email' => $this->email));
            /*foreach ($models as $data) {
                if ($data->activeStatus != 1)
                    $this->addError('email', 'Please verify your email account first.');
            }*/
        }
    }


    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        //echo 'in login model';
        if ($this->_identity === null) {
            $this->_identity = new AutoLogin($this->email, null);
            $this->_identity->authenticate();

        }
        if ($this->_identity->errorCode === AutoLogin::ERROR_NONE) {
            $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        } else {
            return false;
        }

    }
}
