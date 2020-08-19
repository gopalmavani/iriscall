<?php

/**
 * This is the model class for table "booking".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'booking':
 * @property integer $booking_id
 * @property string $event_id
 * @property string $username
 * @property string $email
 * @property string $mobile_number
 * @property string $address
 * @property string $user_id
 * @property string $price
 * @property string $coupon_code
 * @property string $created_at
 * @property string $modified_at

 */
class Booking extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'booking';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('event_id, username, email,price, created_at, modified_at', 'required'),
            array('event_id, username, email, mobile_number, user_id, price, coupon_code', 'length', 'max'=>255),
            array('address', 'length', 'max'=>355),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('booking_id, event_id, username, email, mobile_number, address, user_id, price, coupon_code, created_at, modified_at', 'safe', 'on'=>'search'),
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
            'booking_id' => 'Booking',
            'event_id' => 'Event',
            'username' => 'Username',
            'email' => 'Email',
            'mobile_number' => 'Mobile Number',
            'address' => 'Address',
            'user_id' => 'User',
            'price' => 'Price',
            'coupon_code' => 'Coupon Code',
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

        $criteria->compare('booking_id',$this->booking_id);
        $criteria->compare('event_id',$this->event_id,true);
        $criteria->compare('username',$this->username,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('mobile_number',$this->mobile_number,true);
        $criteria->compare('address',$this->address,true);
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('price',$this->price,true);
        $criteria->compare('coupon_code',$this->coupon_code,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('modified_at',$this->modified_at,true);

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
     * @return Booking the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
