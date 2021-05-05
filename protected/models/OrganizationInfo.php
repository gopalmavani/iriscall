<?php

/**
 * This is the model class for table "user_info".
 *
 * The followings are the available columns in table 'user_info':
 * @property integer $organisation_id
 * @property string $name
 * @property string $shortened_name
 * @property string $language
 * @property string $sip_domain
 * @property string $domain_name
 * @property string $call_pickup_within_group
 * @property string $trunk_clutch
 * @property integer $trunk_username
 * @property string $pbx
 * @property string $created_at
 *
 */
class OrganizationInfo extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'company_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('organisation_id, name, shortened_name, language, sip_domain, call_pickup_within_group, trunk_clutch, trunk_username, pbx, created_at', 'required'),
            //array('organisation_id, call_pickup_within_group', 'integerOnly'=>true),
            array('name, shortened_name, language, sip_domain, domain_name, trunk_clutch, trunk_username, pbx','length', 'max'=>50),
            array('created_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('organisation_id', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'organisation_id' => 'Organisation id',
            'name' => 'Name',
            'shortened_name' => 'Shortened Name',
            'language' => 'Language',
            'sip_domain' => 'Sip Domain',
            'domain_name' => 'Domain Name',
            'call_pickup_within_group' => 'Call Pickup within Group',
            'trunk_clutch' => 'Trunk Clutch',
            'trunk_username' => 'Trunk Urername',
            'pbx'=> 'PBX',
            'created_at'=> 'Created Date',
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

        $criteria->compare('organisation_id',$this->organisation_id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('shortened_name',$this->shortened_name,true);
        $criteria->compare('language',$this->language,true);
        $criteria->compare('sip_domain',$this->sip_domain,true);
        $criteria->compare('domain_name',$this->domain_name,true);
        $criteria->compare('call_pickup_within_group',$this->call_pickup_within_group,true);
        $criteria->compare('trunk_clutch',$this->trunk_clutch,true);
        $criteria->compare('trunk_username',$this->trunk_username);
        $criteria->compare('language',$this->language,true);
        $criteria->compare('pbx',$this->pbx,true);
        $criteria->compare('created_at',$this->created_at,true);

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
