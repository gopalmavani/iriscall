<?php

/**
 * This is the model class for table "product_subscription".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'product_subscription':
 * @property integer $s_id
 * @property integer $user_id
 * @property string $user_name
 * @property string $email
 * @property string $product_name
 * @property string $product_details
 * @property double $subscription_price
 * @property integer $duration
 * @property integer $duration_denomination
 * @property string $starts_at
 * @property string $next_renewal_date
 * @property integer $payment_mode
 * @property integer $subscription_status
 * @property string $created_at
 * @property string $modified_at

 */
class ProductSubscription extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'product_subscription';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('starts_at', 'required'),
            array('s_id, user_id, duration, duration_denomination, payment_mode, subscription_status', 'numerical', 'integerOnly'=>true),
            array('subscription_price', 'numerical'),
            array('user_name, email', 'length', 'max'=>150),
            array('product_name', 'length', 'max'=>240),
            array('product_details', 'length', 'max'=>300),
            array('next_renewal_date, created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('s_id, user_id, user_name, email, product_name, product_details, subscription_price, duration, duration_denomination, starts_at, next_renewal_date, payment_mode, subscription_status, created_at, modified_at', 'safe', 'on'=>'search'),
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
            's_id' => 'S',
            'user_id' => 'User',
            'user_name' => 'User Name',
            'email' => 'Email',
            'product_name' => 'Product Name',
            'product_details' => 'Product Details',
            'subscription_price' => 'Subscription Price',
            'duration' => 'Duration',
            'duration_denomination' => 'Duration Denomination',
            'starts_at' => 'Starts At',
            'next_renewal_date' => 'Next Renewal Date',
            'payment_mode' => 'Payment Mode',
            'subscription_status' => 'Subscription Status',
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

        $criteria->compare('s_id',$this->s_id);
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('user_name',$this->user_name,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('product_name',$this->product_name,true);
        $criteria->compare('product_details',$this->product_details,true);
        $criteria->compare('subscription_price',$this->subscription_price);
        $criteria->compare('duration',$this->duration);
        $criteria->compare('duration_denomination',$this->duration_denomination);
        $criteria->compare('starts_at',$this->starts_at,true);
        $criteria->compare('next_renewal_date',$this->next_renewal_date,true);
        $criteria->compare('payment_mode',$this->payment_mode);
        $criteria->compare('subscription_status',$this->subscription_status);
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
     * @return ProductSubscription the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
