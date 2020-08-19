<?php

/**
 * This is the model class for table "order_payment".
 *
 * The followings are the available columns in table 'order_payment':
 * @property integer $payment_id
 * @property integer $order_info_id
 * @property double $total
 * @property integer $payment_mode
 * @property string $payment_ref_id
 * @property integer $payment_status
 * @property string $payment_date
 * @property string $created_at
 * @property string $modified_at
 * @property string $transaction_mode
 * @property integer $denomination_id
 *
 * The followings are the available model relations:
 * @property Denomination $denomination
 * @property OrderInfo $orderInfo
 * @property Payment $paymentMode
 */
class OrderPayment extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_payment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('total, payment_mode, payment_ref_id, payment_date, transaction_mode, denomination_id', 'required'),
			array('order_info_id, payment_mode, payment_status, denomination_id', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical'),
			array('payment_ref_id, transaction_mode', 'length', 'max'=>80),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('payment_id, order_info_id, total, payment_mode, payment_ref_id, payment_status, payment_date, created_at, modified_at, transaction_mode, denomination_id', 'safe', 'on'=>'search'),
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
			'denomination' => array(self::BELONGS_TO, 'Denomination', 'denomination_id'),
			'orderInfo' => array(self::BELONGS_TO, 'OrderInfo', 'order_info_id'),
			'paymentMode' => array(self::BELONGS_TO, 'Payment', 'payment_mode'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'payment_id' => 'Payment',
			'order_info_id' => 'Order Info',
			'total' => 'Total',
			'payment_mode' => 'Payment Mode',
			'payment_ref_id' => 'Payment Ref',
			'payment_status' => 'Payment Status',
			'payment_date' => 'Payment Date',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'transaction_mode' => 'Transaction Mode',
			'denomination_id' => 'Denomination',
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
		$criteria->compare('order_info_id',$this->order_info_id);
		$criteria->compare('total',$this->total);
		$criteria->compare('payment_mode',$this->payment_mode);
		$criteria->compare('payment_ref_id',$this->payment_ref_id,true);
		$criteria->compare('payment_status',$this->payment_status);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('transaction_mode',$this->transaction_mode,true);
		$criteria->compare('denomination_id',$this->denomination_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderPayment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
