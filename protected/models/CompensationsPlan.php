<?php

/**
 * This is the model class for table "compensations_plan".
 *
 * The followings are the available columns in table 'compensations_plan':
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property string $table_name
 * @property string $icon
 * @property integer $ref_id
 * @property string $created_at
 * @property string $modified_at
 */
class CompensationsPlan extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'compensations_plan';
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
            array('ref_id', 'numerical', 'integerOnly'=>true),
            array('name, status, table_name, icon', 'length', 'max'=>150),
            array('modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, status, table_name, icon, ref_id, created_at, modified_at', 'safe', 'on'=>'search'),
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
            'name' => 'Name',
            'status' => 'Status',
            'table_name' => 'Table Name',
            'icon' => 'Icon',
            'ref_id' => 'Ref',
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
        $criteria->compare('name',$this->name,true);
        $criteria->compare('status',$this->status,true);
        $criteria->compare('table_name',$this->table_name,true);
        $criteria->compare('icon',$this->icon,true);
        $criteria->compare('ref_id',$this->ref_id);
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
     * @return CompensationsPlan the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
