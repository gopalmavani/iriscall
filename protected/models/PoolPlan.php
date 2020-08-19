<?php

/**
 * This is the model class for table "pool_plan".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'pool_plan':
 * @property integer $id
 * @property string $pool_name
 * @property string $pool_description
 * @property string $pool_amount
 * @property string $pool_denomination
 * @property string $user_id

 */
class PoolPlan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pool_plan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pool_name, pool_amount, user_id', 'required'),
			array('pool_name, pool_amount, pool_denomination, user_id', 'length', 'max'=>50),
			array('pool_description', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, pool_name, pool_description, pool_amount, pool_denomination, user_id', 'safe', 'on'=>'search'),
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
			'pool_name' => 'Pool Name',
			'pool_description' => 'Pool Description',
			'pool_amount' => 'Pool Amount',
			'pool_denomination' => 'Pool Denomination',
			'user_id' => 'User',
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
		$criteria->compare('pool_name',$this->pool_name,true);
		$criteria->compare('pool_description',$this->pool_description,true);
		$criteria->compare('pool_amount',$this->pool_amount,true);
		$criteria->compare('pool_denomination',$this->pool_denomination,true);
		$criteria->compare('user_id',$this->user_id,true);

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
	 * @return PoolPlan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
