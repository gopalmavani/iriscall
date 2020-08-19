<?php

/**
 * This is the model class for table "notification_manager".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'notification_manager':
 * @property integer $id
 * @property string $title_html
 * @property string $body_html
 * @property string $type_of_notification
 * @property integer $sender_Id
 * @property integer $isAdmin
 * @property string $url
 * @property integer $is_unread
 * @property integer $is_delete
 * @property string $created_at
 * @property string $modified_at

 */
class NotificationManager extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'notification_manager';
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
            array('sender_Id, isAdmin, is_unread, is_delete', 'numerical', 'integerOnly'=>true),
            array('type_of_notification', 'length', 'max'=>150),
            array('url', 'length', 'max'=>765),
            array('title_html, body_html, modified_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title_html, body_html, type_of_notification, sender_Id, isAdmin, url, is_unread, is_delete, created_at, modified_at', 'safe', 'on'=>'search'),
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
            'title_html' => 'Title Html',
            'body_html' => 'Body Html',
            'type_of_notification' => 'Type Of Notification',
            'sender_Id' => 'Sender',
            'isAdmin' => 'Is Admin',
            'url' => 'Url',
            'is_unread' => 'Is Unread',
            'is_delete' => 'Is Delete',
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
        $criteria->compare('title_html',$this->title_html,true);
        $criteria->compare('body_html',$this->body_html,true);
        $criteria->compare('type_of_notification',$this->type_of_notification,true);
        $criteria->compare('sender_Id',$this->sender_Id);
        $criteria->compare('isAdmin',$this->isAdmin);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('is_unread',$this->is_unread);
        $criteria->compare('is_delete',$this->is_delete);
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
     * @return NotificationManager the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
