<?php

/**
 * This is the model class for table "user_license_count".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'user_license_count':
 * @property integer $license_id
 * @property integer $user_id
 * @property integer $total_licenses
 * @property integer $available_licenses
 * @property integer $product_id
 * @property string $created_at
 * @property string $modified_at

 *
 * The followings are the available model relations:
 * @property UserInfo $user
 * @property ProductInfo $product
 */
class UserLicenseCount extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_license_count';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, total_licenses, available_licenses, product_id', 'required'),
			array('user_id, total_licenses, available_licenses, product_id', 'numerical', 'integerOnly'=>true),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('license_id, user_id, total_licenses, available_licenses, product_id, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'UserInfo', 'user_id'),
			'product' => array(self::BELONGS_TO, 'ProductInfo', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'license_id' => 'License',
			'user_id' => 'User',
			'total_licenses' => 'Total Licenses',
			'available_licenses' => 'Available Licenses',
			'product_id' => 'Product',
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

		$criteria->compare('license_id',$this->license_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('total_licenses',$this->total_licenses);
		$criteria->compare('available_licenses',$this->available_licenses);
		$criteria->compare('product_id',$this->product_id);
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
	 * @return UserLicenseCount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
