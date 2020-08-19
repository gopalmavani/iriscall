<?php

/**
 * This is the model class for table "sys_users".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'sys_users':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $activekey
 * @property integer $auth_level
 * @property integer $status
 * @property string $created_at
 * @property string $lastvisit_at

 */
class SysUsers extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'sys_users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_at', 'required'),
            array('auth_level, status', 'numerical', 'integerOnly'=>true),
            array('username', 'length', 'max'=>20),
            array('password, email, activekey', 'length', 'max'=>130),
            array('lastvisit_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, email, activekey, auth_level, status, created_at, lastvisit_at', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'activekey' => 'Activekey',
            'auth_level' => 'Auth Level',
            'status' => 'Status',
            'created_at' => 'Created At',
            'lastvisit_at' => 'Lastvisit At',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activekey',$this->activekey,true);
        $criteria->compare('auth_level',$this->auth_level);
        $criteria->compare('status',$this->status);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('lastvisit_at',$this->lastvisit_at,true);

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pagesize' => 50,
            ),
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SysUsers the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
