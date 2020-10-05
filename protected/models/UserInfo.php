<?php

/**
 * This is the model class for table "user_info".
 *
 * The followings are the available columns in table 'user_info':
 * @property integer $user_id
 * @property string $full_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $email
 * @property string $api_token
 * @property string $date_of_birth
 * @property integer $gender
 * @property string $language
 * @property string $sponsor_id
 * @property integer $is_enabled
 * @property integer $is_active
 * @property string $created_at
 * @property string $modified_at
 * @property string $business_name
 * @property string $vat_number
 * @property string $busAddress_building_num
 * @property string $busAddress_street
 * @property string $busAddress_region
 * @property string $busAddress_city
 * @property string $busAddress_postcode
 * @property string $busAddress_country
 * @property string $business_phone
 * @property string $building_num
 * @property string $street
 * @property string $region
 * @property string $city
 * @property string $postcode
 * @property string $country
 * @property string $phone
 * @property integer $is_delete
 * @property string $image
 * @property string $role
 * @property string $token
 * @property integer $notification_mail
 * @property integer $marketting_mail
 * @property string $auth
 * @property integer $terms_conditions
 * @property integer $affiliate_disclosure
 * @property integer $privacy_disclosure
 * @property integer $reserve_wallet_commission_status
 * @property integer $organization_id
 *
 * The followings are the available model relations:
 * @property OrderCart[] $orderCarts
 * @property OrderInfo[] $orderInfos
 * @property UserPayoutInfo[] $userPayoutInfos
 * @property Wallet[] $wallets
 */
class UserInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('full_name, first_name, last_name, building_num, street, city, postcode, country, phone', 'required'),
			array('gender, is_enabled, is_active, is_delete, notification_mail, marketting_mail, terms_conditions, affiliate_disclosure, privacy_disclosure, reserve_wallet_commission_status, organization_id', 'numerical', 'integerOnly'=>true),
			array('full_name, first_name, middle_name, last_name, email, api_token, sponsor_id, business_name, vat_number, busAddress_building_num, busAddress_street, busAddress_region, busAddress_city, busAddress_country, business_phone, building_num, street, region, city, country, phone, role', 'length', 'max'=>80),
			array('language', 'length', 'max'=>1000),
			array('busAddress_postcode, postcode', 'length', 'max'=>20),
			array('image, token, auth', 'length', 'max'=>255),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_id, full_name, first_name, middle_name, last_name, email, api_token, date_of_birth, gender, language, sponsor_id, is_enabled, is_active, created_at, modified_at, business_name, vat_number, busAddress_building_num, busAddress_street, busAddress_region, busAddress_city, busAddress_postcode, busAddress_country, business_phone, building_num, street, region, city, postcode, country, phone, is_delete, image, role, token, notification_mail, marketting_mail, auth, terms_conditions, affiliate_disclosure, privacy_disclosure, reserve_wallet_commission_status, organization_id', 'safe', 'on'=>'search'),
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
			'nuClientDepositWithdraws' => array(self::HAS_MANY, 'NuClientDepositWithdraw', 'user_id'),
			'nuKycs' => array(self::HAS_MANY, 'NuKyc', 'user_id'),
			'nuRegistrations' => array(self::HAS_MANY, 'NuRegistrations', 'user_id'),
			'orderCarts' => array(self::HAS_MANY, 'OrderCart', 'user_id'),
			'orderInfos' => array(self::HAS_MANY, 'OrderInfo', 'user_id'),
			'userLicenseCounts' => array(self::HAS_MANY, 'UserLicenseCount', 'user_id'),
			'userLicenses' => array(self::HAS_MANY, 'UserLicenses', 'user_id'),
			'userPayoutInfos' => array(self::HAS_MANY, 'UserPayoutInfo', 'user_id'),
			'wallets' => array(self::HAS_MANY, 'Wallet', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'full_name' => 'Full Name',
			'first_name' => 'First Name',
			'middle_name' => 'Middle Name',
			'last_name' => 'Last Name',
			'email' => 'Email',
			'api_token' => 'API Token',
			'date_of_birth' => 'Date Of Birth',
			'gender' => 'Gender',
			'language' => 'Language',
			'sponsor_id' => 'Sponsor',
			'is_enabled' => 'Is Enabled',
			'is_active' => 'Is Active',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'business_name' => 'Business Name',
			'vat_number' => 'Vat Number',
			'busAddress_building_num' => 'Bus Address Building Num',
			'busAddress_street' => 'Bus Address Street',
			'busAddress_region' => 'Bus Address Region',
			'busAddress_city' => 'Bus Address City',
			'busAddress_postcode' => 'Bus Address Postcode',
			'busAddress_country' => 'Bus Address Country',
			'business_phone' => 'Business Phone',
			'building_num' => 'Building Num',
			'street' => 'Street',
			'region' => 'Region',
			'city' => 'City',
			'postcode' => 'Postcode',
			'country' => 'Country',
			'phone' => 'Phone',
			'is_delete' => 'Is Delete',
			'image' => 'Image',
			'role' => 'Role',
			'token' => 'Token',
			'notification_mail' => 'Notification Mail',
			'marketting_mail' => 'Marketting Mail',
			'auth' => 'Auth',
			'terms_conditions' => 'Terms Conditions',
			'affiliate_disclosure' => 'Affiliate Disclosure',
			'privacy_disclosure' => 'Privacy Disclosure',
			'reserve_wallet_commission_status' => 'Reserve Wallet Commission Status',
			'organization_id' => 'Organization Id',
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

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('api_token',$this->api_token,true);
		$criteria->compare('date_of_birth',$this->date_of_birth,true);
		$criteria->compare('gender',$this->gender);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('sponsor_id',$this->sponsor_id,true);
		$criteria->compare('is_enabled',$this->is_enabled);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('business_name',$this->business_name,true);
		$criteria->compare('vat_number',$this->vat_number,true);
		$criteria->compare('busAddress_building_num',$this->busAddress_building_num,true);
		$criteria->compare('busAddress_street',$this->busAddress_street,true);
		$criteria->compare('busAddress_region',$this->busAddress_region,true);
		$criteria->compare('busAddress_city',$this->busAddress_city,true);
		$criteria->compare('busAddress_postcode',$this->busAddress_postcode,true);
		$criteria->compare('busAddress_country',$this->busAddress_country,true);
		$criteria->compare('business_phone',$this->business_phone,true);
		$criteria->compare('building_num',$this->building_num,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('is_delete',$this->is_delete);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('notification_mail',$this->notification_mail);
		$criteria->compare('marketting_mail',$this->marketting_mail);
		$criteria->compare('auth',$this->auth,true);
		$criteria->compare('terms_conditions',$this->terms_conditions);
		$criteria->compare('affiliate_disclosure',$this->affiliate_disclosure);
		$criteria->compare('privacy_disclosure',$this->privacy_disclosure);
		$criteria->compare('reserve_wallet_commission_status',$this->reserve_wallet_commission_status);
		$criteria->compare('organization_id',$this->organization_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
