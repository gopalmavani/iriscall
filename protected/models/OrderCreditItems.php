<?php

/**
 * This is the model class for table "order_credit_items".
 *
 * The followings are the available columns in table 'order_credit_items':
 * @property string $credit_item_id
 * @property integer $credit_memo_id
 * @property integer $order_info_id
 * @property integer $product_id
 * @property integer $product_sku
 * @property string $product_details
 * @property string $product_name
 * @property double $product_price
 * @property string $product_country_name
 * @property integer $order_item_qty
 * @property integer $refund_item_qty
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property OrderCreditMemo $creditMemo
 * @property OrderInfo $orderInfo
 */
class OrderCreditItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_credit_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('credit_memo_id, order_info_id, product_id, product_sku, created_at', 'required'),
			array('credit_memo_id, order_info_id, product_id, product_sku, order_item_qty, refund_item_qty', 'numerical', 'integerOnly'=>true),
			array('product_price', 'numerical'),
			array('product_details, product_name, product_country_name', 'length', 'max'=>50),
			array('modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('credit_item_id, credit_memo_id, order_info_id, product_id, product_sku, product_details, product_name, product_price, product_country_name, order_item_qty, refund_item_qty, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'creditMemo' => array(self::BELONGS_TO, 'OrderCreditMemo', 'credit_memo_id'),
			'orderInfo' => array(self::BELONGS_TO, 'OrderInfo', 'order_info_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'credit_item_id' => 'Credit Item',
			'credit_memo_id' => 'Credit Memo',
			'order_info_id' => 'Order Info',
			'product_id' => 'Product',
			'product_sku' => 'Product Sku',
			'product_details' => 'Product Details',
			'product_name' => 'Product Name',
			'product_price' => 'Product Price',
			'product_country_name' => 'Product Country Name',
			'order_item_qty' => 'Order Item Qty',
			'refund_item_qty' => 'Refund Item Qty',
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

		$criteria->compare('credit_item_id',$this->credit_item_id,true);
		$criteria->compare('credit_memo_id',$this->credit_memo_id);
		$criteria->compare('order_info_id',$this->order_info_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('product_sku',$this->product_sku);
		$criteria->compare('product_details',$this->product_details,true);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('product_price',$this->product_price);
		$criteria->compare('product_country_name',$this->product_country_name,true);
		$criteria->compare('order_item_qty',$this->order_item_qty);
		$criteria->compare('refund_item_qty',$this->refund_item_qty);
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
	 * @return OrderCreditItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
