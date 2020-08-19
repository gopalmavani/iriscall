<?php

/**
 * This is the model class for table "user_daily_balance".
 *
 * The followings are the available columns in table 'user_daily_balance':
 * @property integer $id
 * @property string $email_address
 * @property integer $login
 * @property double $balance
 * @property integer $agent
 * @property double $equity
 * @property double $deposit
 * @property string $created_at
 * @property string $modified_at
 */
class UserDailyBalance extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_daily_balance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email_address, login, agent, created_at', 'required'),
			array('login, agent', 'numerical', 'integerOnly'=>true),
			array('balance, equity, deposit', 'numerical'),
			array('email_address', 'length', 'max'=>50),
			array('modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email_address, login, balance, agent, equity, deposit, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'email_address' => 'Email Address',
			'login' => 'Login',
			'balance' => 'Balance',
			'agent' => 'Agent',
			'equity' => 'Equity',
			'deposit' => 'Deposit',
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
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('login',$this->login);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('agent',$this->agent);
		$criteria->compare('equity',$this->equity);
		$criteria->compare('deposit',$this->deposit);
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
	 * @return UserDailyBalance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
