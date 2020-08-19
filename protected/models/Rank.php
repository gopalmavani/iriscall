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
            array('rankName, rankIcon, descriptions, created_at, rankAbbreviation, level', 'required'),
            array('userPaidOut, level', 'numerical', 'integerOnly'=>true),
            array('rankName', 'length', 'max'=>100),
            array('rankIcon, rankAbbreviation', 'length', 'max'=>150),
            array('descriptions', 'length', 'max'=>250),
            array('modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rankId, rankName, rankIcon, descriptions, userPaidOut, created_at, modified_at, rankAbbreviation, level', 'safe', 'on'=>'search'),
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
            'rankrules' => array(self::HAS_MANY, 'Rankrules', 'rankId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'rankId' => 'Rank',
            'rankName' => 'Rank Name',
            'rankIcon' => 'Rank Icon',
            'descriptions' => 'Descriptions',
            'userPaidOut' => 'User Paid Out',
            'created_at' => 'Created Date',
            'modified_at' => 'Modified Date',
            'rankAbbreviation' => 'Rank Abbreviation',
            'level' => 'Level',
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

        $criteria->compare('rankId',$this->rankId);
        $criteria->compare('rankName',$this->rankName,true);
        $criteria->compare('rankIcon',$this->rankIcon,true);
        $criteria->compare('descriptions',$this->descriptions,true);
        $criteria->compare('userPaidOut',$this->userPaidOut);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('modified_at',$this->modified_at,true);
        $criteria->compare('rankAbbreviation',$this->rankAbbreviation,true);
        $criteria->compare('level',$this->level);

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
