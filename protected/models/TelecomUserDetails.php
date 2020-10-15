<?php

/**
 * This is the model class for table "telecom_user_details".
 *
 * The followings are the available columns in table 'telecom_user_details':
 * @property integer $id
 * @property integer $user_id
 * @property string $email
 * @property integer $client_id
 * @property integer $agent_id
 * @property string $agent_name
 * @property string $bus_number
 * @property string $nationality
 * @property integer $company_since_in_months
 * @property string $landline_number
 * @property string $payment_method
 * @property string $credit_card_type
 * @property string $credit_card_number
 * @property string $credit_card_name
 * @property integer $expiry_date_month
 * @property integer $expiry_date_year
 * @property string $comments
 * @property string $created_at
 * @property string $modified_at

 */
class TelecomUserDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'telecom_user_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, client_id, user_id, company_since_in_months, expiry_date_month, expiry_date_year', 'numerical', 'integerOnly'=>true),
            array('created_at, modified_at', 'safe'),
            array('email, credit_card_name', 'length', 'max'=>80),
            array('agent_name, bus_number, nationality, landline_number, payment_method, credit_card_type, credit_card_number', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_id, user_id, company_since_in_months, expiry_date_month, expiry_date_year, email, credit_card_name, agent_name, bus_number, nationality, landline_number, payment_method, credit_card_type, credit_card_number, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'id' => 'Id',
			'client_id' => 'Client',
			'user_id' => 'User',
            'email' => 'Email',
            'agent_id' => 'Agent',
            'agent_name' => 'Agent Name',
            'bus_number' => 'Bus Number',
            'nationality' => 'Nationality',
            'company_since_in_months' => 'Company since in months',
            'landline_number' => 'Landline number',
            'payment_method' => 'Payment Method',
			'credit_card_name' => 'Credit card name',
			'credit_card_type' => 'Credit card type',
			'credit_card_number' => 'Credit card number',
            'expiry_date_month' => 'Expiry date month',
            'expiry_date_year' => 'Expiry date year',
            'comments' => 'Comments',
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
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('email',$this->email, true);
		$criteria->compare('agent_id',$this->agent_id);
		$criteria->compare('agent_name',$this->agent_name, true);
		$criteria->compare('bus_number',$this->bus_number, true);
		$criteria->compare('nationality',$this->nationality, true);
		$criteria->compare('company_since_in_months',$this->company_since_in_months);
		$criteria->compare('landline_number',$this->landline_number, true);
		$criteria->compare('payment_method',$this->payment_method, true);
		$criteria->compare('credit_card_name',$this->credit_card_name, true);
		$criteria->compare('credit_card_type',$this->credit_card_type, true);
		$criteria->compare('credit_card_number',$this->credit_card_number, true);
		$criteria->compare('expiry_date_month',$this->expiry_date_month, true);
		$criteria->compare('expiry_date_year',$this->expiry_date_year, true);
		$criteria->compare('comments',$this->comments, true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);

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
	 * @return Cart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
