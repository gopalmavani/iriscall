<?php

/**
 * This is the model class for table "cdr_cost_rules".
 *
 * @property integer $start_with
 * @property string $digit
 * @property integer $from_number_start_with
 * @property string $from_number_digit
 * @property double $cost
 * @property string $country
 * @property string $comment
 * @property string $created_at
 *
 */
class CdrCostRulesInfo extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cdr_cost_rules';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('start_with, digit, cost, country, created_at', 'required'),
            array('digit,from_number_digit', 'numerical', 'integerOnly'=>true),
            array('cost', 'numerical'),
            array('start_with,from_number_start_with','length', 'max'=>30),
            array('country','length', 'max'=>20),
            array('created_at, modified_at', 'safe'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'start_with' => 'Start with',
            'digit' => 'Digit',
            'from_number_start_with' => 'From Start with',
            'from_number_digit' => 'From Digit',
            'cost' => 'Cost',
            'country' => 'Country',
            'comment'=> 'Comment',
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
        $criteria->compare('start_with',$this->start_with,true);
        $criteria->compare('digit',$this->digit);
        $criteria->compare('from_number_start_with',$this->from_number_start_with,true);
        $criteria->compare('from_number_digit',$this->from_number_digit);
        $criteria->compare('cost',$this->cost,true);
        $criteria->compare('country',$this->country,true);
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
     * @return UserInfo the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
