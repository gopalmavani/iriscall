<?php

/**
 * This is the model class for table "cbm_accounts".
 *
 * The followings are the available columns in table 'cbm_accounts':
 * @property string $login
 * @property string $name
 * @property string $currency
 * @property double $balance
 * @property double $prev_balance
 * @property double $equity
 * @property double $prev_equity
 * @property string $email_address
 * @property string $group
 * @property string $agent
 * @property string $registration_date
 * @property string $leverage
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $postcode
 * @property string $country
 * @property string $phone_number
 * @property string $created_date
 * @property string $modified_at
 * @property double $max_balance
 * @property double $max_equity
 */
class CbmAccounts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cbm_accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('balance, prev_balance, equity, prev_equity, max_balance, max_equity', 'numerical'),
			array('login, phone_number', 'length', 'max'=>20),
			array('name', 'length', 'max'=>200),
			array('currency', 'length', 'max'=>10),
			array('email_address, address', 'length', 'max'=>300),
			array('group, agent, leverage, city, state, postcode, country', 'length', 'max'=>50),
			array('registration_date, created_date, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('login, name, currency, balance, prev_balance, equity, prev_equity, email_address, group, agent, registration_date, leverage, address, city, state, postcode, country, phone_number, created_date, modified_at, max_balance, max_equity', 'safe', 'on'=>'search'),
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
			'login' => 'Login',
			'name' => 'Name',
			'currency' => 'Currency',
			'balance' => 'Balance',
			'prev_balance' => 'Prev Balance',
			'equity' => 'Equity',
			'prev_equity' => 'Prev Equity',
			'email_address' => 'Email Address',
			'group' => 'Group',
			'agent' => 'Agent',
			'registration_date' => 'Registration Date',
			'leverage' => 'Leverage',
			'address' => 'Address',
			'city' => 'City',
			'state' => 'State',
			'postcode' => 'Postcode',
			'country' => 'Country',
			'phone_number' => 'Phone Number',
			'created_date' => 'Created Date',
			'modified_at' => 'Modified At',
			'max_balance' => 'Max Balance',
			'max_equity' => 'Max Equity',
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

		$criteria->compare('login',$this->login,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('prev_balance',$this->prev_balance);
		$criteria->compare('equity',$this->equity);
		$criteria->compare('prev_equity',$this->prev_equity);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('agent',$this->agent,true);
		$criteria->compare('registration_date',$this->registration_date,true);
		$criteria->compare('leverage',$this->leverage,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('max_balance',$this->max_balance);
		$criteria->compare('max_equity',$this->max_equity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CbmAccounts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
