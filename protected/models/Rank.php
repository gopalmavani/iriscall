<?php

/**
 * This is the model class for table "rank".
 *
 * The followings are the available columns in table 'rank':
 * @property integer $rankId
 * @property string $rankName
 * @property string $rankIcon
 * @property string $descriptions
 * @property integer $userPaidOut
 * @property string $created_at
 * @property string $modified_at
 * @property string $rankAbbreviation
 * @property integer $level
 *
 * The followings are the available model relations:
 * @property Rankrules[] $rankrules
 */
class Rank extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'rank';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description, abbreviation', 'required'),
            array('name', 'length', 'max'=>50),
            //array('icon', 'file', 'allowEmpty'=>true, 'types'=>'jpg,jpeg,gif,png'),
            array('abbreviation', 'length', 'max'=>10),
            array('modified_at, created_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, description, abbreviation', 'safe', 'on'=>'search'),
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
            'userInfo' => array(self::HAS_MANY, 'UserInfo', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Rank',
            'name' => 'Name',
            'icon' => 'Icon',
            'description' => 'Description',
            'abbreviation' => 'Abbreviation',
            'created_at' => 'Created Date',
            'modified_at' => 'Modified Date',
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

        $criteria->compare('id',$this->rankId);
        $criteria->compare('name',$this->rankName,true);
        $criteria->compare('description',$this->descriptions,true);
        $criteria->compare('abbreviation',$this->userPaidOut);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Rank the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
