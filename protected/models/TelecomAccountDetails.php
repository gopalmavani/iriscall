<?php

/**
 * This is the model class for table "telecom_account_details".
 *
 * The followings are the available columns in table 'telecom_account_details':
 * @property integer $id
 * @property integer $user_id
 * @property integer $client_id
 * @property string $email
 * @property string $phone_number
 * @property string $sim_card_number
 * @property string $old_sim_card_number
 * @property integer $is_voice_mail_enabled
 * @property string $tariff_plan
 * @property string $extra_options
 * @property string $comments
 * @property string $previous_operator_client_id
 * @property string $previous_operator_name
 * @property string $previous_operator_client_invoice_name
 * @property string $authorised_person_name
 * @property string $authorised_person_vat_number
 * @property string $created_at
 * @property string $modified_at

 */
class TelecomAccountDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'telecom_account_details';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, client_id, user_id, is_voice_mail_enabled', 'numerical', 'integerOnly'=>true),
            array('created_at, modified_at', 'safe'),
            array('email, extra_options, previous_operator_name, previous_operator_client_invoice_name, authorised_person_name, authorised_person_vat_number', 'length', 'max'=>80),
            array('phone_number, sim_card_number, old_sim_card_number, tariff_plan, previous_operator_client_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_id, user_id, is_voice_mail_enabled, email, extra_options, previous_operator_name, previous_operator_client_invoice_name, authorised_person_name, authorised_person_vat_number, phone_number, sim_card_number, old_sim_card_number, tariff_plan, previous_operator_client_id, created_at, modified_at', 'safe', 'on'=>'search'),
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
            'phone_number' => 'Phone number',
            'sim_card_number' => 'Sim card number',
            'old_sim_card_number' => 'Old sim card number',
            'is_voice_mail_enabled' => 'Voice mail',
            'tariff_plan' => 'Tariff plan',
			'extra_options' => 'Extra options',
			'comments' => 'Comments',
			'previous_operator_client_id' => 'Previous Operator Client Id',
			'previous_operator_name' => 'Previous Operator Name',
			'previous_operator_client_invoice_name' => 'Previous Operator Client Invoice Name',
            'authorised_person_name' => 'Authorised Person Name',
            'authorised_person_vat_number' => 'Authorised Person Vat Number',
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
		$criteria->compare('phone_number',$this->phone_number, true);
		$criteria->compare('sim_card_number',$this->sim_card_number, true);
		$criteria->compare('old_sim_card_number',$this->old_sim_card_number, true);
		$criteria->compare('tariff_plan',$this->tariff_plan, true);
		$criteria->compare('extra_options',$this->extra_options, true);
		$criteria->compare('comments',$this->comments, true);
		$criteria->compare('previous_operator_client_id',$this->previous_operator_client_id, true);
		$criteria->compare('previous_operator_name',$this->previous_operator_name, true);
		$criteria->compare('previous_operator_client_invoice_name',$this->previous_operator_client_invoice_name, true);
		$criteria->compare('authorised_person_name',$this->authorised_person_name, true);
		$criteria->compare('authorised_person_vat_number',$this->authorised_person_vat_number, true);
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
