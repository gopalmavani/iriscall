<?php

/**
 * This is the model class for table "order_line_item".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'order_line_item':
 * @property integer $order_line_item_id
 * @property integer $order_info_id
 * @property string $product_name
 * @property integer $item_qty
 * @property string $item_disc
 * @property string $item_price
 * @property string $created_at
 * @property string $modified_at
 * @property integer $product_id
 * @property string $product_sku

 *
 * The followings are the available model relations:
 * @property OrderInfo $orderInfo
 */
class OrderLineItem extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_line_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_name, item_qty, item_price, product_sku', 'required'),
			array('order_info_id, item_qty, product_id', 'numerical', 'integerOnly'=>true),
			array('product_name', 'length', 'max'=>100),
			array('item_disc, product_sku', 'length', 'max'=>255),
			array('item_price', 'length', 'max'=>80),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_line_item_id, order_info_id, product_name, item_qty, item_disc, item_price, created_at, modified_at, product_id, product_sku', 'safe', 'on'=>'search'),
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
			'orderInfo' => array(self::BELONGS_TO, 'OrderInfo', 'order_info_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_line_item_id' => 'Order Line Item',
			'order_info_id' => 'Order Info',
			'product_name' => 'Product Name',
			'total_time' => 'Total Time',
			'item_qty' => 'Item Qty',
			'item_disc' => 'Item Disc',
			'item_price' => 'Item Price',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'product_id' => 'Product',
			'product_sku' => 'Product Sku',
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

		$criteria->compare('order_line_item_id',$this->order_line_item_id);
		$criteria->compare('order_info_id',$this->order_info_id);
		$criteria->compare('product_name',$this->product_name,true);
		$criteria->compare('total_time',$this->total_time,true);
		$criteria->compare('item_qty',$this->item_qty);
		$criteria->compare('item_disc',$this->item_disc,true);
		$criteria->compare('item_price',$this->item_price,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('product_sku',$this->product_sku,true);

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
	 * @return OrderLineItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
