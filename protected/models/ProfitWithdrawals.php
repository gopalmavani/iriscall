<?php

/**
 * This is the model class for table "profit_withdrawals".
 *
 * The followings are the available columns in table 'profit_withdrawals':
 * @property integer $id
 * @property integer $from_account
 * @property integer $to_account
 * @property string $product
 * @property double $amount
 * @property string $email
 * @property integer $status
 * @property string $comment
 * @property string $created_At
 * @property string $modified_At
 */
class ProfitWithdrawals extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profit_withdrawals';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_account, to_account, product, amount, email, status, comment, created_At', 'required'),
			array('from_account, to_account, status', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('product', 'length', 'max'=>200),
			array('email, comment', 'length', 'max'=>50),
			array('modified_At', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, from_account, to_account, product, amount, email, status, comment, created_At, modified_At', 'safe', 'on'=>'search'),
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
			'from_account' => 'From Account',
			'to_account' => 'To Account',
			'product' => 'Product',
			'amount' => 'Amount',
			'email' => 'Email',
			'status' => 'Status',
			'comment' => 'Comment',
			'created_At' => 'Created At',
			'modified_At' => 'Modified At',
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
		$criteria->compare('from_account',$this->from_account);
		$criteria->compare('to_account',$this->to_account);
		$criteria->compare('product',$this->product,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('created_At',$this->created_At,true);
		$criteria->compare('modified_At',$this->modified_At,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProfitWithdrawals the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
