<?php

/**
 * This is the model class for table "cbm_activity_reference".
 *
 * The followings are the available columns in table 'cbm_activity_reference':
 * @property integer $id
 * @property string $reference
 * @property string $reference_data_1
 * @property string $reference_data_2
 * @property string $reference_data_3
 * @property string $description
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property CbmActivity[] $cbmActivities
 */
class CbmActivityReference extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cbm_activity_reference';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reference, reference_data_1, reference_data_2, reference_data_3', 'length', 'max'=>255),
			array('description, created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, reference, reference_data_1, reference_data_2, reference_data_3, description, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'cbmActivities' => array(self::HAS_MANY, 'CbmActivity', 'reference_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'reference' => 'Reference',
			'reference_data_1' => 'Reference Data 1',
			'reference_data_2' => 'Reference Data 2',
			'reference_data_3' => 'Reference Data 3',
			'description' => 'Description',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('reference',$this->reference,true);
		$criteria->compare('reference_data_1',$this->reference_data_1,true);
		$criteria->compare('reference_data_2',$this->reference_data_2,true);
		$criteria->compare('reference_data_3',$this->reference_data_3,true);
		$criteria->compare('description',$this->description,true);
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
	 * @return CbmActivityReference the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
