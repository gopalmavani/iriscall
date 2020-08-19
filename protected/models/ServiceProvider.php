<?php

/**
 * This is the model class for table "service_provider".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'service_provider':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $email
 * @property string $phone_no
 * @property string $image
 * @property integer $no_of_clients_sametime
 * @property string $created_at
 * @property string $modified_at

 */
class ServiceProvider extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'service_provider';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('no_of_clients_sametime', 'numerical', 'integerOnly'=>true),
            array('name, email', 'length', 'max'=>100),
            array('description', 'length', 'max'=>20000),
            array('phone_no', 'length', 'max'=>20),
            array('image', 'length', 'max'=>500),
            array('created_at,modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, description, email, phone_no, image, no_of_clients_sametime, created_at, modified_at', 'safe', 'on'=>'search'),
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
            'description' => 'Description',
            'email' => 'Email',
            'phone_no' => 'Phone No',
            'image' => 'Image',
            'no_of_clients_sametime' => 'No Of Clients Sametime',
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
        $criteria->compare('description',$this->description,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('phone_no',$this->phone_no,true);
        $criteria->compare('image',$this->image,true);
        $criteria->compare('no_of_clients_sametime',$this->no_of_clients_sametime);
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
     * @return ServiceProvider the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
