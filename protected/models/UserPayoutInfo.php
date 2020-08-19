<?php

/**
 * This is the model class for table "user_payout_info".
 *
 * The followings are the available columns in table 'user_payout_info':
 * @property integer $id
 * @property integer $user_id
 * @property string $bank_name
 * @property string $bank_building_num
 * @property string $bank_street
 * @property string $bank_region
 * @property string $bank_city
 * @property string $bank_postcode
 * @property string $bank_country
 * @property string $account_name
 * @property string $iban
 * @property string $bic_code
 * @property string $created_at
 * @property string $modified_at
 */
class UserPayoutInfo extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_payout_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, bank_name, created_at', 'required'),
            array('user_id', 'numerical', 'integerOnly'=>true),
            array('bank_name, bank_building_num, account_name', 'length', 'max'=>100),
            array('bank_street, bank_region, bank_city, bank_postcode, bank_country, iban, bic_code', 'length', 'max'=>80),
            array('modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, bank_name, bank_building_num, bank_street, bank_region, bank_city, bank_postcode, bank_country, account_name, iban, bic_code, created_at, modified_at', 'safe', 'on'=>'search'),
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
            'user_id' => 'User',
            'bank_name' => 'Bank Name',
            'bank_building_num' => 'Bank Building Num',
            'bank_street' => 'Bank Street',
            'bank_region' => 'Bank Region',
            'bank_city' => 'Bank City',
            'bank_postcode' => 'Bank Postcode',
            'bank_country' => 'Bank Country',
            'account_name' => 'Account Name',
            'iban' => 'Iban',
            'bic_code' => 'Bic Code',
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
        $criteria->compare('user_id',$this->user_id);
        $criteria->compare('bank_name',$this->bank_name,true);
        $criteria->compare('bank_building_num',$this->bank_building_num,true);
        $criteria->compare('bank_street',$this->bank_street,true);
        $criteria->compare('bank_region',$this->bank_region,true);
        $criteria->compare('bank_city',$this->bank_city,true);
        $criteria->compare('bank_postcode',$this->bank_postcode,true);
        $criteria->compare('bank_country',$this->bank_country,true);
        $criteria->compare('account_name',$this->account_name,true);
        $criteria->compare('iban',$this->iban,true);
        $criteria->compare('bic_code',$this->bic_code,true);
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
     * @return UserPayoutInfo the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}