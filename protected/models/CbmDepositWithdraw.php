<?php

/**
 * This is the model class for table "cbm_deposit_withdraw".
 *
 * The followings are the available columns in table 'cbm_deposit_withdraw':
 * @property integer $id
 * @property integer $login
 * @property integer $ticket
 * @property string $symbol
 * @property string $email
 * @property string $api_type
 * @property float $lots
 * @property string $type
 * @property float $open_price
 * @property string $open_time
 * @property float $close_price
 * @property string $close_time
 * @property float $profit
 * @property float $commission
 * @property float $agent_commission
 * @property string $comment
 * @property integer $magic_number
 * @property float $stop_loss
 * @property float  $take_profit
 * @property float  $swap
 * @property string $reason
 * @property string $created_at
 * @property string $modified_at
 * @property integer $is_accounted_for
 */
class CbmDepositWithdraw extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cbm_deposit_withdraw';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, ticket, api_type, type, comment, created_at', 'required'),
			array('login, ticket, magic_number, is_accounted_for, lots, open_price, close_price, profit, commission, agent_commission', 'numerical', 'integerOnly'=>true),
			array('symbol, email, stop_loss, take_profit, swap', 'length', 'max'=>100),
			array('api_type, type', 'length', 'max'=>50),
			array('comment', 'length', 'max'=>200),
			array('reason', 'length', 'max'=>500),
			array('open_time, close_time, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login, ticket, symbol, email, api_type, lots, type, open_price, open_time, close_price, close_time, profit, commission, agent_commission, comment, magic_number, stop_loss, take_profit, swap, reason, created_at, modified_at, is_accounted_for', 'safe', 'on'=>'search'),
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
			'login' => 'Login',
			'ticket' => 'Ticket',
			'symbol' => 'Symbol',
			'email' => 'Email',
			'api_type' => 'Api Type',
			'lots' => 'Lots',
			'type' => 'Type',
			'open_price' => 'Open Price',
			'open_time' => 'Open Time',
			'close_price' => 'Close Price',
			'close_time' => 'Close Time',
			'profit' => 'Profit',
			'commission' => 'Commission',
			'agent_commission' => 'Agent Commission',
			'comment' => 'Comment',
			'magic_number' => 'Magic Number',
			'stop_loss' => 'Stop Loss',
			'take_profit' => 'Take Profit',
			'swap' => 'Swap',
			'reason' => 'Reason',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'is_accounted_for' => 'Is Accounted For',
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
		$criteria->compare('login',$this->login);
		$criteria->compare('ticket',$this->ticket);
		$criteria->compare('symbol',$this->symbol,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('api_type',$this->api_type,true);
		$criteria->compare('lots',$this->lots);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('open_price',$this->open_price);
		$criteria->compare('open_time',$this->open_time,true);
		$criteria->compare('close_price',$this->close_price);
		$criteria->compare('close_time',$this->close_time,true);
		$criteria->compare('profit',$this->profit);
		$criteria->compare('commission',$this->commission);
		$criteria->compare('agent_commission',$this->agent_commission);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('magic_number',$this->magic_number);
		$criteria->compare('stop_loss',$this->stop_loss);
		$criteria->compare('take_profit',$this->take_profit);
		$criteria->compare('swap',$this->swap);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('is_accounted_for',$this->is_accounted_for);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CbmDepositWithdraw the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
