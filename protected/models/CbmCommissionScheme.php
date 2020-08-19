<?php

/**
 * This is the model class for table "cbm_commission_scheme".
 *
 * The followings are the available columns in table 'cbm_commission_scheme':
 * @property string $id
 * @property string $scheme
 * @property double $max_amount
 * @property double $max_earnings
 * @property integer $wallet_type_id
 * @property integer $scheme_id
 * @property string $created_at
 * @property string $modified_at
 */
class CbmCommissionScheme extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cbm_commission_scheme';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_type_id, scheme_id', 'numerical', 'integerOnly'=>true),
			array('max_amount, max_earnings', 'numerical'),
			array('scheme', 'length', 'max'=>200),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, scheme, max_amount, max_earnings, wallet_type_id, scheme_id, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'scheme' => 'Scheme',
			'max_amount' => 'Max Amount',
			'max_earnings' => 'Max Earnings',
			'wallet_type_id' => 'Wallet Type',
			'scheme_id' => 'Scheme Id',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('scheme',$this->scheme,true);
		$criteria->compare('max_amount',$this->max_amount);
		$criteria->compare('max_earnings',$this->max_earnings);
		$criteria->compare('wallet_type_id',$this->wallet_type_id);
		$criteria->compare('scheme_id',$this->scheme_id);
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
	 * @return CbmCommissionScheme the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
