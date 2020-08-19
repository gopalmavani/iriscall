<?php

/**
 * This is the model class for table "mmc_matrix".
 *
 * The followings are the available columns in table 'mmc_matrix':
 * @property integer $id
 * @property string $cbm_account_num
 * @property integer $user_id
 * @property string $email
 * @property integer $parent
 * @property integer $lchild
 * @property integer $rchild
 * @property string $created_at
 */
class MMCMatrix extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mmc_matrix';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, parent, lchild, rchild', 'numerical', 'integerOnly'=>true),
			array('cbm_account_num', 'length', 'max'=>50),
			array('email', 'length', 'max'=>80),
			array('created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cbm_account_num, user_id, email, parent, lchild, rchild, created_at', 'safe', 'on'=>'search'),
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
			'cbm_account_num' => 'Cbm Account Num',
			'user_id' => 'User',
			'email' => 'Email',
			'parent' => 'Parent',
			'lchild' => 'Lchild',
			'rchild' => 'Rchild',
			'created_at' => 'Created At',
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
		$criteria->compare('cbm_account_num',$this->cbm_account_num,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('lchild',$this->lchild);
		$criteria->compare('rchild',$this->rchild);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FiftyEuroMatrix the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
