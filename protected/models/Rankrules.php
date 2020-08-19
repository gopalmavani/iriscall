<?php

/**
 * This is the model class for table "rankrules".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'rankrules':
 * @property integer $rankRulesId
 * @property integer $rankId
 * @property integer $ruleId
 * @property string $value1
 * @property string $value2
 * @property integer $isActive
 * @property string $created_at
 * @property string $modified_at

 */
class Rankrules extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'rankrules';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_at', 'required'),
            array('rankRulesId, rankId, ruleId, isActive', 'numerical', 'integerOnly'=>true),
            array('value1', 'length', 'max'=>1800),
            array('value2', 'length', 'max'=>900),
            array('modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('rankRulesId, rankId, ruleId, value1, value2, isActive, created_at, modified_at', 'safe', 'on'=>'search'),
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
            'rankRulesId' => 'Rank Rules',
            'rankId' => 'Rank',
            'ruleId' => 'Rule',
            'value1' => 'Value1',
            'value2' => 'Value2',
            'isActive' => 'Is Active',
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

        $criteria->compare('rankRulesId',$this->rankRulesId);
        $criteria->compare('rankId',$this->rankId);
        $criteria->compare('ruleId',$this->ruleId);
        $criteria->compare('value1',$this->value1,true);
        $criteria->compare('value2',$this->value2,true);
        $criteria->compare('isActive',$this->isActive);
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
     * @return Rankrules the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
