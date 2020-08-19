<?php

/**
 * This is the model class for table "wallet".
 *
 * The followings are the available columns in table 'wallet':
 * @property integer $wallet_id
 * @property integer $user_id
 * @property integer $wallet_type_id
 * @property integer $transaction_type
 * @property integer $reference_id
 * @property string $reference_num
 * @property string $transaction_comment
 * @property integer $denomination_id
 * @property integer $transaction_status
 * @property integer $portal_id
 * @property double $amount
 * @property double $updated_balance
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property Denomination $denomination
 * @property Portals $portal
 * @property WalletMetaEntity $reference
 * @property UserInfo $user
 * @property WalletTypeEntity $walletType
 */
class Wallet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wallet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, wallet_type_id, reference_id, reference_num, denomination_id, portal_id, amount', 'required'),
			array('user_id, wallet_type_id, transaction_type, reference_id, denomination_id, transaction_status, portal_id', 'numerical', 'integerOnly'=>true),
			array('amount, updated_balance', 'numerical'),
			array('reference_num', 'length', 'max'=>80),
			array('transaction_comment, created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wallet_id, user_id, wallet_type_id, transaction_type, reference_id, reference_num, transaction_comment, denomination_id, transaction_status, portal_id, amount, updated_balance, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'denomination' => array(self::BELONGS_TO, 'Denomination', 'denomination_id'),
			'portal' => array(self::BELONGS_TO, 'Portals', 'portal_id'),
			'reference' => array(self::BELONGS_TO, 'WalletMetaEntity', 'reference_id'),
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
			'wallet_id' => 'Wallet',
			'user_id' => 'User',
			'wallet_type_id' => 'Wallet Type',
			'transaction_type' => 'Transaction Type',
			'reference_id' => 'Reference',
			'reference_num' => 'Reference Num',
			'transaction_comment' => 'Transaction Comment',
			'denomination_id' => 'Denomination',
			'transaction_status' => 'Transaction Status',
			'portal_id' => 'Portal',
			'amount' => 'Amount',
			'updated_balance' => 'Updated Balance',
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

		$criteria->compare('wallet_id',$this->wallet_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('wallet_type_id',$this->wallet_type_id);
		$criteria->compare('transaction_type',$this->transaction_type);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('reference_num',$this->reference_num,true);
		$criteria->compare('transaction_comment',$this->transaction_comment,true);
		$criteria->compare('denomination_id',$this->denomination_id);
		$criteria->compare('transaction_status',$this->transaction_status);
		$criteria->compare('portal_id',$this->portal_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('updated_balance',$this->updated_balance);
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
	 * @return Wallet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
