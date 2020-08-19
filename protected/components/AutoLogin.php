<?php
/**
 * AutoLogin represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
require_once(dirname(__FILE__) . '/ServiceHelper.php');

class AutoLogin extends CUserIdentity
{
    private $_id;

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */

    public function authenticate()
    {
        Yii::trace('authentica');

        $user = UserInfo::model()->findByAttributes(array('email' => $this->username));

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return !$this->errorCode;
        } elseif ($user->email !== $this->username) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            return !$this->errorCode;
        } else {
            $this->_id=$user->user_id;
            $this->setState('role', $user->role);
            $this->setState('username', $user->email);
            $this->setState('name', $user->first_name.' '.$user->last_name);
            $this->errorCode=self::ERROR_NONE;
            /*$this->_id = $user->user_id;
            $this->setState('title', $user->email);
            $this->errorCode = self::ERROR_NONE;*/
        }
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}
