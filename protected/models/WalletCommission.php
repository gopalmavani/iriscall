<?php

/**
 * This is the model class for table "wallet_commission".
 *
 * The followings are the available columns in table 'wallet_commission':
 * @property integer $wallet_comm_id
 * @property integer $user_id
 * @property integer $wallet_type_id
 * @property double $amount
 * @property integer $from_level
 * @property integer $from_user_id
 * @property integer $from_node_id
 * @property integer $to_node_id
 * @property integer $month
 * @property integer $year
 * @property integer $transaction_type
 * @property string $transaction_comment
 * @property integer $transaction_status
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property UserInfo $fromUser
 * @property UserInfo $user
 * @property WalletTypeEntity $walletType
 */
class WalletCommission extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wallet_commission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, wallet_type_id, amount', 'required'),
			array('user_id, wallet_type_id, from_level, from_user_id, from_node_id, to_node_id, month, year, transaction_type, transaction_status', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('transaction_comment, created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wallet_comm_id, user_id, wallet_type_id, amount, from_level, from_user_id, from_node_id, to_node_id, month, year, transaction_type, transaction_comment, transaction_status, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'fromUser' => array(self::BELONGS_TO, 'UserInfo', 'from_user_id'),
			'user' => array(self::BELONGS_TO, 'UserInfo', 'user_id'),
			'walletType' => array(self::BELONGS_TO, 'WalletTypeEntity', 'wallet_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wallet_comm_id' => 'Wallet Comm',
			'user_id' => 'User',
			'wallet_type_id' => 'Wallet Type',
			'amount' => 'Amount',
			'from_level' => 'From Level',
			'from_user_id' => 'From User',
			'from_node_id' => 'From Node',
			'to_node_id' => 'To Node',
			'month' => 'Month',
			'year' => 'Year',
			'transaction_type' => 'Transaction Type',
			'transaction_comment' => 'Transaction Comment',
			'transaction_status' => 'Transaction Status',
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

		$criteria->compare('wallet_comm_id',$this->wallet_comm_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('wallet_type_id',$this->wallet_type_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('from_level',$this->from_level);
		$criteria->compare('from_user_id',$this->from_user_id);
		$criteria->compare('from_node_id',$this->from_node_id);
		$criteria->compare('to_node_id',$this->to_node_id);
		$criteria->compare('month',$this->month);
		$criteria->compare('year',$this->year);
		$criteria->compare('transaction_type',$this->transaction_type);
		$criteria->compare('transaction_comment',$this->transaction_comment,true);
		$criteria->compare('transaction_status',$this->transaction_status);
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
	 * @return WalletCommission the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
