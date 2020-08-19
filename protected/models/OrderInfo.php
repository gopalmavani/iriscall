<?php

/**
 * This is the model class for table "order_info".
 *
 * The followings are the available columns in table 'order_info':
 * @property integer $order_info_id
 * @property integer $order_id
 * @property integer $user_id
 * @property double $vat
 * @property double $vat_percentage
 * @property string $vat_number
 * @property string $company
 * @property integer $order_status
 * @property string $order_origin
 * @property string $building
 * @property string $street
 * @property string $city
 * @property string $region
 * @property string $country
 * @property string $postcode
 * @property double $orderTotal
 * @property double $discount
 * @property double $netTotal
 * @property integer $invoice_number
 * @property string $invoice_date
 * @property string $created_date
 * @property string $modified_date
 * @property integer $is_subscription_enabled
 * @property string $order_comment
 * @property string $user_name
 * @property string $email
 * @property string $voucher_code
 * @property double $voucher_discount
 *
 * The followings are the available model relations:
 * @property OrderCreditMemo[] $orderCreditMemos
 * @property OrderCreditMemo[] $orderCreditMemos1
 * @property UserInfo $user
 * @property OrderLineItem[] $orderLineItems
 * @property OrderPayment[] $orderPayments
 */
class OrderInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, user_id, orderTotal, netTotal', 'required'),
			array('order_id, user_id, order_status, invoice_number, is_subscription_enabled', 'numerical', 'integerOnly'=>true),
			array('vat, vat_percentage, orderTotal, discount, netTotal, voucher_discount', 'numerical'),
			array('vat_number, company, order_origin, building, street, city, region, country', 'length', 'max'=>80),
			array('postcode', 'length', 'max'=>20),
			array('order_comment', 'length', 'max'=>200),
			array('user_name, email, voucher_code', 'length', 'max'=>100),
			array('invoice_date, created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_info_id, order_id, user_id, vat, vat_percentage, vat_number, company, order_status, order_origin, building, street, city, region, country, postcode, orderTotal, discount, netTotal, invoice_number, invoice_date, created_date, modified_date, is_subscription_enabled, order_comment, user_name, email, voucher_code, voucher_discount', 'safe', 'on'=>'search'),
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
			'orderCreditMemos' => array(self::HAS_MANY, 'OrderCreditMemo', 'invoice_number'),
			'orderCreditMemos1' => array(self::HAS_MANY, 'OrderCreditMemo', 'order_info_id'),
			'user' => array(self::BELONGS_TO, 'UserInfo', 'user_id'),
			'orderLineItems' => array(self::HAS_MANY, 'OrderLineItem', 'order_info_id'),
			'orderPayments' => array(self::HAS_MANY, 'OrderPayment', 'order_info_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_info_id' => 'Order Info',
			'order_id' => 'Order',
			'user_id' => 'User',
			'vat' => 'Vat',
			'vat_percentage' => 'Vat Percentage',
			'vat_number' => 'Vat Number',
			'company' => 'Company',
			'order_status' => 'Order Status',
			'order_origin' => 'Order Origin',
			'building' => 'Building',
			'street' => 'Street',
			'city' => 'City',
			'region' => 'Region',
			'country' => 'Country',
			'postcode' => 'Postcode',
			'orderTotal' => 'Order Total',
			'discount' => 'Discount',
			'netTotal' => 'Net Total',
			'invoice_number' => 'Invoice Number',
			'invoice_date' => 'Invoice Date',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
			'is_subscription_enabled' => 'Is Subscription Enabled',
			'order_comment' => 'Order Comment',
			'user_name' => 'User Name',
			'email' => 'Email',
			'voucher_code' => 'Voucher Code',
			'voucher_discount' => 'Voucher Discount',
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

		$criteria->compare('order_info_id',$this->order_info_id);
		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('vat',$this->vat);
		$criteria->compare('vat_percentage',$this->vat_percentage);
		$criteria->compare('vat_number',$this->vat_number,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('order_status',$this->order_status);
		$criteria->compare('order_origin',$this->order_origin,true);
		$criteria->compare('building',$this->building,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('orderTotal',$this->orderTotal);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('netTotal',$this->netTotal);
		$criteria->compare('invoice_number',$this->invoice_number);
		$criteria->compare('invoice_date',$this->invoice_date,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);
		$criteria->compare('is_subscription_enabled',$this->is_subscription_enabled);
		$criteria->compare('order_comment',$this->order_comment,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('voucher_code',$this->voucher_code,true);
		$criteria->compare('voucher_discount',$this->voucher_discount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
