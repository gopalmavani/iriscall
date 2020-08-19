<?php

/**
 * This is the model class for table "api_trades".
 *
 * The followings are the available columns in table 'api_trades':
 * @property integer $id
 * @property integer $login
 * @property integer $agent_number
 * @property string $ticket
 * @property string $symbol
 * @property string $type
 * @property double $lots
 * @property double $open_price
 * @property string $open_time
 * @property double $close_price
 * @property string $close_time
 * @property double $profit
 * @property double $commission
 * @property double $agent_commission
 * @property string $comment
 * @property string $magic_number
 * @property double $stop_loss
 * @property double $take_profit
 * @property double $swap
 * @property string $reason
 * @property integer $is_accounted_for
 * @property string $created_at
 * @property string $modified_at
 */
class ApiTrades extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'api_trades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, is_accounted_for, agent_number', 'numerical', 'integerOnly'=>true),
			array('lots, open_price, close_price, profit, commission, agent_commission, stop_loss, take_profit, swap', 'numerical'),
			array('ticket, symbol, type, magic_number', 'length', 'max'=>100),
			array('comment, reason', 'length', 'max'=>500),
			array('open_time, close_time, created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, login, agent_number, ticket, symbol, type, lots, open_price, open_time, close_price, close_time, profit, commission, agent_commission, comment, magic_number, stop_loss, take_profit, swap, reason, is_accounted_for, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'agent_number' => 'Agent Number',
			'ticket' => 'Ticket',
			'symbol' => 'Symbol',
			'type' => 'Type',
			'lots' => 'Lots',
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
			'is_accounted_for' => 'Is Accounted For',
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
		$criteria->compare('login',$this->login);
		$criteria->compare('agent_number',$this->agent_number);
		$criteria->compare('ticket',$this->ticket,true);
		$criteria->compare('symbol',$this->symbol,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('lots',$this->lots);
		$criteria->compare('open_price',$this->open_price);
		$criteria->compare('open_time',$this->open_time,true);
		$criteria->compare('close_price',$this->close_price);
		$criteria->compare('close_time',$this->close_time,true);
		$criteria->compare('profit',$this->profit);
		$criteria->compare('commission',$this->commission);
		$criteria->compare('agent_commission',$this->agent_commission);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('magic_number',$this->magic_number,true);
		$criteria->compare('stop_loss',$this->stop_loss);
		$criteria->compare('take_profit',$this->take_profit);
		$criteria->compare('swap',$this->swap);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('is_accounted_for',$this->is_accounted_for);
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
	 * @return ApiTrades the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
