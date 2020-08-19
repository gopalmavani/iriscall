<?php

/**
 * This is the model class for table "denomination".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'denomination':
 * @property integer $denomination_id
 * @property string $denomination_type
 * @property string $sub_type
 * @property string $created_at
 * @property string $modified_at
 * @property string $label
 * @property string $currency

 */
class Denomination extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'denomination';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('denomination_type, sub_type, label, currency', 'required'),
			array('denomination_type, sub_type, label, currency', 'length', 'max'=>80),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('denomination_id, denomination_type, sub_type, created_at, modified_at, label, currency', 'safe', 'on'=>'search'),
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
			'denomination_id' => 'Denomination',
			'denomination_type' => 'Denomination Type',
			'sub_type' => 'Sub Type',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'label' => 'Label',
			'currency' => 'Currency',
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

		$criteria->compare('denomination_id',$this->denomination_id);
		$criteria->compare('denomination_type',$this->denomination_type,true);
		$criteria->compare('sub_type',$this->sub_type,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('currency',$this->currency,true);

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
	 * @return Denomination the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
