<?php

/**
 * This is the model class for table "nu_kyc".
 *
 * The followings are the available columns in table 'nu_kyc':
 * @property integer $id
 * @property integer $registration_id
 * @property integer $user_id
 * @property string $username
 * @property string $path
 * @property string $type
 * @property string $comment
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property NuRegistrations $registration
 * @property UserInfo $user
 */
class NuKyc extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'nu_kyc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registration_id, user_id, username, path, type, created_at', 'required'),
			array('registration_id, user_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>255),
			array('path', 'length', 'max'=>500),
			array('type', 'length', 'max'=>100),
			array('comment, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, registration_id, user_id, username, path, type, comment, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'registration' => array(self::BELONGS_TO, 'NuRegistrations', 'registration_id'),
			'user' => array(self::BELONGS_TO, 'UserInfo', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'registration_id' => 'Registration',
			'user_id' => 'User',
			'username' => 'Username',
			'path' => 'Path',
			'type' => 'Type',
			'comment' => 'Comment',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('registration_id',$this->registration_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('path',$this->path,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NuKyc the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
