<?php

/**
 * This is the model class for table "commission_plan_settings".
 *
 * The followings are the available columns in table 'commission_plan_settings':
 * @property integer $commission_plan_id
 * @property string $user_level
 * @property integer $rank_id
 * @property integer $product_id
 * @property integer $category_id
 * @property integer $amount_type
 * @property double $amount
 * @property integer $wallet_type_id
 * @property integer $wallet_reference_id
 * @property integer $denomination_id
 * @property integer $wallet_status
 * @property string $created_at
 * @property string $modified_at
 */
class CommissionPlanSettings extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'commission_plan_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('commission_plan_id, user_level, rank_id, product_id, category_id, amount_type, amount, wallet_type_id, wallet_reference_id, denomination_id, wallet_status', 'required'),
			array('commission_plan_id, rank_id, product_id, category_id, amount_type, wallet_type_id, wallet_reference_id, denomination_id, wallet_status', 'numerical', 'integerOnly'=>true),
			array('user_level', 'length', 'max'=>30),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('commission_plan_id, user_level, rank_id, product_id, category_id, amount_type, amount, wallet_type_id, wallet_reference_id, denomination_id, wallet_status, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'commission_plan_id' => 'Commission Plan',
			'user_level' => 'User Level',
			'rank_id' => 'Rank',
			'Product_id' => 'Product Name',
			'category_id' => 'Category',
            'amount_type' => 'Amount Type',
			'amount' => 'Amount',
			'wallet_type_id' => 'Wallet Type',
			'wallet_reference_id' => 'Wallet Reference',
			'denomination_id' => 'Denomination',
            'wallet_status' => 'Status',
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

		$criteria->compare('commission_plan_id',$this->commission_plan_id);
		$criteria->compare('user_level',$this->user_level);
		$criteria->compare('rank_id',$this->rank_id);
		$criteria->compare('product_id',$this->product_id);
        $criteria->compare('category_id',$this->category_id);
		$criteria->compare('amount_type',$this->amount_type);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('wallet_type_id',$this->wallet_type_id);
        $criteria->compare('wallet_reference_id',$this->wallet_reference_id);
		$criteria->compare('denomination_id',$this->denomination_id);
		$criteria->compare('wallet_status',$this->wallet_status);
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
	 * @return CommissionPlanSettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
