<?php

/**
 * This is the model class for table "cdr_info".
 *
 * The followings are the available columns in table 'user_info':
 * @property integer $organisation_id
 * @property string $callid
 * @property string $start_time
 * @property string $answer_time
 * @property string $end_time
 * @property string $timezone
 * @property string $from_type
 * @property string $from_id
 * @property integer $from_number
 * @property string $from_name
 * @property string $to_number
 * @property string $end_reason
 * @property string $unit_cost
 * @property string $date
 * @property string $created_at
 *
 */
class CallDataRecordsInfo extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cdr_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('organisation_id, callid, start_time, timezone, date, created_at', 'required'),
            array('organisation_id', 'integerOnly'=>true),
            array('callid, from_type, from_id, from_number, from_name, to_number, end_reason','length', 'max'=>255),
            array('timezone, unit_cost, date','length', 'max'=>20),
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
            'organisation_id' => 'Organisation Id',
            'callid' => 'Call Id',
            'start_time' => 'Start time',
            'answer_time' => 'Answer time',
            'end_time' => 'End time',
            'timezone' => 'Timezone',
            'from_type' => 'From',
            'from_id' => 'From Id',
            'from_number' => 'From Number',
            'from_name' => 'From Name',
            'to_number'=> 'To',
            'end_reason'=> 'Reason',
            'unit_cost'=> 'Cost',
            'date'=> 'Date',
            'created_at'=> 'created',
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
        $criteria->compare('callid',$this->callid,true);
        $criteria->compare('start_time',$this->start_time,true);
        $criteria->compare('answer_time',$this->answer_time,true);
        $criteria->compare('end_time',$this->end_time,true);
        $criteria->compare('timezone',$this->timezone,true);
        $criteria->compare('from_type',$this->from_type,true);
        $criteria->compare('from_id',$this->from_id,true);
        $criteria->compare('from_number',$this->from_number);
        $criteria->compare('from_name',$this->from_name,true);
        $criteria->compare('to_number',$this->to_number,true);
        $criteria->compare('end_reason',$this->end_reason,true);
        $criteria->compare('unit_cost',$this->unit_cost,true);
        $criteria->compare('date',$this->date,true);
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
