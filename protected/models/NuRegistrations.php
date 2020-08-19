<?php

/**
 * This is the model class for table "nu_registrations".
 *
 * The followings are the available columns in table 'nu_registrations':
 * @property integer $id
 * @property integer $user_id
 * @property string $firstname_user1
 * @property string $middlename_user1
 * @property string $lastname_user1
 * @property string $fullname_user1
 * @property string $firstname_user2
 * @property string $middlename_user2
 * @property string $lastname_user2
 * @property string $fullname_user2
 * @property string $house_num
 * @property string $street
 * @property string $region
 * @property string $city
 * @property string $postcode
 * @property string $country
 * @property integer $agree_terms_conditions
 * @property integer $agree_risks
 * @property integer $agree_fund_source
 * @property string $fund_sources
 * @property double $initial_funding_amount
 * @property string $comment
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property NuKyc[] $nuKycs
 * @property UserInfo $user
 */
class NuRegistrations extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'nu_registrations';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, firstname_user1, lastname_user1, house_num, street, city, postcode, country, agree_terms_conditions, agree_risks, agree_fund_source, fund_sources, created_at', 'required'),
            array('user_id, agree_terms_conditions, agree_risks, agree_fund_source', 'numerical', 'integerOnly'=>true),
            array('initial_funding_amount', 'numerical'),
            array('firstname_user1, middlename_user1, lastname_user1, firstname_user2, middlename_user2, lastname_user2', 'length', 'max'=>80),
            array('fullname_user1, fullname_user2, fund_sources', 'length', 'max'=>1000),
            array('house_num', 'length', 'max'=>100),
            array('street, region, city', 'length', 'max'=>255),
            array('postcode, country', 'length', 'max'=>20),
            array('comment, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, firstname_user1, middlename_user1, lastname_user1, fullname_user1, firstname_user2, middlename_user2, lastname_user2, fullname_user2, house_num, street, region, city, postcode, country, agree_terms_conditions, agree_risks, agree_fund_source, fund_sources, initial_funding_amount, comment, created_at, modified_at', 'safe', 'on'=>'search'),
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
            'nuKycs' => array(self::HAS_MANY, 'NuKyc', 'registration_id'),
            'user' => array(self::BELONGS_TO, 'UserInfo', 'user_id'),
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
            'firstname_user1' => 'Firstname User1',
            'middlename_user1' => 'Middlename User1',
            'lastname_user1' => 'Lastname User1',
            'fullname_user1' => 'Fullname User1',
            'firstname_user2' => 'Firstname User2',
            'middlename_user2' => 'Middlename User2',
            'lastname_user2' => 'Lastname User2',
            'fullname_user2' => 'Fullname User2',
            'house_num' => 'House Num',
            'street' => 'Street',
            'region' => 'Region',
            'city' => 'City',
            'postcode' => 'Postcode',
            'country' => 'Country',
            'agree_terms_conditions' => 'Agree Terms Conditions',
            'agree_risks' => 'Agree Risks',
            'agree_fund_source' => 'Agree Fund Source',
            'fund_sources' => 'Fund Sources',
            'initial_funding_amount' => 'Initial Funding Amount',
            'comment' => 'Comment',
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
        $criteria->compare('firstname_user1',$this->firstname_user1,true);
        $criteria->compare('middlename_user1',$this->middlename_user1,true);
        $criteria->compare('lastname_user1',$this->lastname_user1,true);
        $criteria->compare('fullname_user1',$this->fullname_user1,true);
        $criteria->compare('firstname_user2',$this->firstname_user2,true);
        $criteria->compare('middlename_user2',$this->middlename_user2,true);
        $criteria->compare('lastname_user2',$this->lastname_user2,true);
        $criteria->compare('fullname_user2',$this->fullname_user2,true);
        $criteria->compare('house_num',$this->house_num,true);
        $criteria->compare('street',$this->street,true);
        $criteria->compare('region',$this->region,true);
        $criteria->compare('city',$this->city,true);
        $criteria->compare('postcode',$this->postcode,true);
        $criteria->compare('country',$this->country,true);
        $criteria->compare('agree_terms_conditions',$this->agree_terms_conditions);
        $criteria->compare('agree_risks',$this->agree_risks);
        $criteria->compare('agree_fund_source',$this->agree_fund_source);
        $criteria->compare('fund_sources',$this->fund_sources,true);
        $criteria->compare('initial_funding_amount',$this->initial_funding_amount);
        $criteria->compare('comment',$this->comment,true);
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
     * @return NuRegistrations the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}