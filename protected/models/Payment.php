<?php

/**
 * This is the model class for table "payment".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'payment':
 * @property integer $payment_id
 * @property string $gateway
 * @property string $merchant_ref_id
 * @property string $key_name_1
 * @property string $key_value_1
 * @property string $key_name_2
 * @property string $key_value_2
 * @property string $parameters
 * @property string $url
 * @property string $action_url
 * @property integer $portal_id
 * @property integer $payment_comment
 * @property string $created_at
 * @property string $modified_at

 */
class Payment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('gateway, key_name_1, key_value_1, url, portal_id, created_at', 'required'),
			array('portal_id, payment_comment', 'numerical', 'integerOnly'=>true),
			array('gateway, merchant_ref_id, key_name_1, key_value_1, key_name_2, key_value_2, parameters, url, action_url', 'length', 'max'=>80),
			array('modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('payment_id, gateway, merchant_ref_id, key_name_1, key_value_1, key_name_2, key_value_2, parameters, url, action_url, portal_id, payment_comment, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'payment_id' => 'Payment',
			'gateway' => 'Gateway',
			'merchant_ref_id' => 'Merchant Ref',
			'key_name_1' => 'Key Name 1',
			'key_value_1' => 'Key Value 1',
			'key_name_2' => 'Key Name 2',
			'key_value_2' => 'Key Value 2',
			'parameters' => 'Parameters',
			'url' => 'Url',
			'action_url' => 'Action Url',
			'portal_id' => 'Portal',
			'payment_comment' => 'Payment Comment',
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

		$criteria->compare('payment_id',$this->payment_id);
		$criteria->compare('gateway',$this->gateway,true);
		$criteria->compare('merchant_ref_id',$this->merchant_ref_id,true);
		$criteria->compare('key_name_1',$this->key_name_1,true);
		$criteria->compare('key_value_1',$this->key_value_1,true);
		$criteria->compare('key_name_2',$this->key_name_2,true);
		$criteria->compare('key_value_2',$this->key_value_2,true);
		$criteria->compare('parameters',$this->parameters,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('action_url',$this->action_url,true);
		$criteria->compare('portal_id',$this->portal_id);
		$criteria->compare('payment_comment',$this->payment_comment);
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
	 * @return Payment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
