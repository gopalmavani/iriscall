<?php

/**
 * This is the model class for table "voucher_info".
 *
 * The followings are the available columns in table 'voucher_info':
 * @property string $id
 * @property string $voucher_name
 * @property integer $reference_id
 * @property string $reference_data
 * @property string $voucher_code
 * @property string $voucher_origin
 * @property string $start_time
 * @property string $end_time
 * @property integer $voucher_status
 * @property string $type
 * @property string $value
 * @property string $redeemed_at
 * @property integer $user_id
 * @property string $user_name
 * @property string $email
 * @property string $voucher_comment
 * @property integer $order_info_id
 * @property string $created_at
 * @property string $modified_at
 */
class VoucherInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'voucher_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('voucher_status, created_at', 'required'),
			array('reference_id, voucher_status, user_id, order_info_id', 'numerical', 'integerOnly'=>true),
			array('voucher_name, reference_data, voucher_code, type, value, user_name, email', 'length', 'max'=>50),
			array('voucher_origin', 'length', 'max'=>128),
			array('start_time, end_time, redeemed_at, voucher_comment, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, voucher_name, reference_id, reference_data, voucher_code, voucher_origin, start_time, end_time, voucher_status, type, value, redeemed_at, user_id, user_name, email, voucher_comment, order_info_id, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'voucher_name' => 'Voucher Name',
			'reference_id' => 'Reference',
			'reference_data' => 'Reference Data',
			'voucher_code' => 'Voucher Code',
			'voucher_origin' => 'Voucher Origin',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'voucher_status' => 'Voucher Status',
			'type' => 'Type',
			'value' => 'Value',
			'redeemed_at' => 'Redeemed At',
			'user_id' => 'User',
			'user_name' => 'User Name',
			'email' => 'Email',
			'voucher_comment' => 'Voucher Comment',
			'order_info_id' => 'Order Info',
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
		$criteria->compare('voucher_name',$this->voucher_name,true);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('reference_data',$this->reference_data,true);
		$criteria->compare('voucher_code',$this->voucher_code,true);
		$criteria->compare('voucher_origin',$this->voucher_origin,true);
		$criteria->compare('start_time',$this->start_time,true);
		$criteria->compare('end_time',$this->end_time,true);
		$criteria->compare('voucher_status',$this->voucher_status);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('redeemed_at',$this->redeemed_at,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('voucher_comment',$this->voucher_comment,true);
		$criteria->compare('order_info_id',$this->order_info_id);
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
	 * @return VoucherInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
