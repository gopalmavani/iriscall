<?php

/**
 * This is the model class for table "order_credit_memo".
 *
 * The followings are the available columns in table 'order_credit_memo':
 * @property integer $credit_memo_id
 * @property integer $order_info_id
 * @property integer $invoice_number
 * @property double $order_total
 * @property double $vat
 * @property double $refund_amount
 * @property integer $memo_status
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property OrderCreditItems[] $orderCreditItems
 * @property OrderInfo $invoiceNumber
 * @property OrderInfo $orderInfo
 */
class OrderCreditMemo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_credit_memo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_total, refund_amount, created_at', 'required'),
			array('order_info_id, invoice_number, memo_status', 'numerical', 'integerOnly'=>true),
			array('order_total, vat, refund_amount', 'numerical'),
			array('modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('credit_memo_id, order_info_id, invoice_number, order_total, vat, refund_amount, memo_status, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'orderCreditItems' => array(self::HAS_MANY, 'OrderCreditItems', 'credit_memo_id'),
			'invoiceNumber' => array(self::BELONGS_TO, 'OrderInfo', 'invoice_number'),
			'orderInfo' => array(self::BELONGS_TO, 'OrderInfo', 'order_info_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'credit_memo_id' => 'Credit Memo',
			'order_info_id' => 'Order Info',
			'invoice_number' => 'Invoice Number',
			'order_total' => 'Order Total',
			'vat' => 'Vat',
			'refund_amount' => 'Refund Amount',
			'memo_status' => 'Memo Status',
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

		$criteria->compare('credit_memo_id',$this->credit_memo_id);
		$criteria->compare('order_info_id',$this->order_info_id);
		$criteria->compare('invoice_number',$this->invoice_number);
		$criteria->compare('order_total',$this->order_total);
		$criteria->compare('vat',$this->vat);
		$criteria->compare('refund_amount',$this->refund_amount);
		$criteria->compare('memo_status',$this->memo_status);
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
	 * @return OrderCreditMemo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
