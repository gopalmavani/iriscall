<?php

/**
 * This is the model class for table "product_info".
 *
 * The followings are the available columns in table 'product_info':
 * @property integer $product_id
 * @property string $sku
 * @property string $name
 * @property double $price
 * @property integer $agent
 * @property integer $licenses
 * @property string $description
 * @property integer $is_active
 * @property string $image
 * @property string $created_at
 * @property string $modified_at
 * @property integer $is_delete
 * @property string $short_description
 * @property integer $is_subscription_enabled
 * @property double $sale_price
 * @property string $sale_start_date
 * @property string $sale_end_date
 *
 * The followings are the available model relations:
 * @property ProductAffiliate[] $productAffiliates
 * @property ProductCategory[] $productCategories
 * @property ProductLicenses[] $productLicenses
 * @property UserLicenseCount[] $userLicenseCounts
 * @property UserLicenses[] $userLicenses
 */
class ProductInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'product_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sku, name, price, short_description', 'required'),
			array('agent, licenses, is_active, is_delete, is_subscription_enabled ', 'numerical', 'integerOnly'=>true),
			array('price, sale_price', 'numerical'),
			array('sku, name, short_description', 'length', 'max'=>255),
			array('description', 'length', 'max'=>20000),
			array('image', 'length', 'max'=>80),
			array('created_at, modified_at, sale_start_date, sale_end_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('product_id, sku, name, price, agent, licenses, description, is_active, image, created_at, modified_at, is_delete, short_description, is_subscription_enabled, sale_price, sale_start_date, sale_end_date', 'safe', 'on'=>'search'),
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
			'productAffiliates' => array(self::HAS_MANY, 'ProductAffiliate', 'product_id'),
			'productCategories' => array(self::HAS_MANY, 'ProductCategory', 'product_id'),
			'productLicenses' => array(self::HAS_MANY, 'ProductLicenses', 'product_id'),
			'userLicenseCounts' => array(self::HAS_MANY, 'UserLicenseCount', 'product_id'),
			'userLicenses' => array(self::HAS_MANY, 'UserLicenses', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_id' => 'Product',
			'sku' => 'Sku',
			'name' => 'Name',
			'price' => 'Price',
			'agent' => 'Agent',
			'licenses' => 'Licenses',
			'description' => 'Description',
			'is_active' => 'Is Active',
			'image' => 'Image',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'is_delete' => 'Is Delete',
			'short_description' => 'Short Description',
			'is_subscription_enabled' => 'Is Subscription Enabled',
			'sale_price' => 'Sale Price',
			'sale_start_date' => 'Sale Start Date',
			'sale_end_date' => 'Sale End Date',
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

		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('agent',$this->agent);
		$criteria->compare('licenses',$this->licenses);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('short_description',$this->short_description,true);
		$criteria->compare('is_subscription_enabled',$this->is_subscription_enabled);
		$criteria->compare('sale_price',$this->sale_price);
		$criteria->compare('sale_start_date',$this->sale_start_date,true);
		$criteria->compare('sale_end_date',$this->sale_end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
