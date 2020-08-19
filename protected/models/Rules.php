<?php

/**
 * This is the model class for table "rules".
 *
 * The followings are the available columns in table 'rules':
 * @property integer $ruleId
 * @property string $description
 * @property string $ruleType
 * @property string $clientsLevel
 * @property string $created_at
 * @property string $modified_at
 * @property integer $subRuleId
 *
 * The followings are the available model relations:
 * @property Rankrules[] $rankrules
 */
class Rules extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, ruleType, created_at, modified_at, subRuleId', 'required'),
			array('subRuleId', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>255),
			array('ruleType', 'length', 'max'=>12),
			array('clientsLevel', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ruleId, description, ruleType, clientsLevel, created_at, modified_at, subRuleId', 'safe', 'on'=>'search'),
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
			'rankrules' => array(self::HAS_MANY, 'Rankrules', 'ruleId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ruleId' => 'Rule',
			'description' => 'Description',
			'ruleType' => 'Rule Type',
			'clientsLevel' => 'Clients Level',
			'created_at' => 'Created Date',
			'modified_at' => 'Modified Date',
			'subRuleId' => 'Sub Rule',
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

		$criteria->compare('ruleId',$this->ruleId);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('ruleType',$this->ruleType,true);
		$criteria->compare('clientsLevel',$this->clientsLevel,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('subRuleId',$this->subRuleId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Rules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
