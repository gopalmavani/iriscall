<?php

/**
 * This is the model class for table "registration_steps".
 *
 * The followings are the available columns in table 'registration_steps':
 * @property string $id
 * @property integer $product_id
 * @property integer $step_number
 * @property string $status_name
 * @property string $comment
 * @property string $font_icon_class
 * @property string $created_at
 * @property string $modified_at
 */
class RegistrationSteps extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'registration_steps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, step_number, status_name', 'required'),
			array('product_id, step_number', 'numerical', 'integerOnly'=>true),
			array('font_icon_class', 'length', 'max'=>50),
			array('comment, created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, step_number, status_name, comment, font_icon_class, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'step_number' => 'Step Number',
			'status_name' => 'Status Name',
			'comment' => 'Comment',
			'font_icon_class' => 'Font Icon Class',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('step_number',$this->step_number);
		$criteria->compare('status_name',$this->status_name,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('font_icon_class',$this->font_icon_class,true);
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
	 * @return RegistrationSteps the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
