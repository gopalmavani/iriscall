<?php
class CompanyGroupInfo extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'company_group_info';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('company_id, group_name, external_number, group_id_mytelephony', 'required'),
            array('company_id', 'numerical', 'integerOnly'=>true),
            array('group_name, external_number, comment', 'length', 'max'=>255),
            array('created_at, updated_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('company_id', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'company_id' => array(self::BELONGS_TO, 'OrganizationInfo', 'id'),
		);
	}

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'company_id' => 'Company Id',
            'group_name' => 'Group Name',
            'external_number' => 'External Number',
            'group_id_mytelephony' => 'Group Id Mytelephony',
            'comment'=> 'Comment',
            'created_at'=> 'Created Date',
            'updated_at'=> 'Updated Date',
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
        $criteria->compare('company_id',$this->company_id);
        $criteria->compare('group_name',$this->group_name,true);
        $criteria->compare('external_number',$this->external_number,true);
        $criteria->compare('group_id_mytelephony',$this->group_id_mytelephony,true);
        $criteria->compare('comment',$this->comment,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('updated_at',$this->updated_at,true);

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
