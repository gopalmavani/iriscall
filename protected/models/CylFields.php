<?php

/**
 * This is the model class for table "cyl_fields".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'cyl_fields':
 * @property string $field_id
 * @property string $field_name
 * @property integer $table_id
 * @property integer $admin_rights
 * @property integer $display_status
 * @property string $admin_label
 * @property string $admin_input
 * @property integer $field_length
 * @property string $field_type
 * @property string $field_input_type
 * @property integer $is_unique
 * @property integer $is_required
 * @property integer $incremental_start
 * @property string $validation_rule
 * @property string $default_value
 * @property integer $is_custom
 * @property string $description
 * @property string $created_date
 * @property string $modified_date

 */
class CylFields extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cyl_fields';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('table_id, admin_rights', 'required'),
			array('table_id, admin_rights, display_status, field_length, is_unique, is_required, incremental_start, is_custom', 'numerical', 'integerOnly'=>true),
			array('field_name, field_type', 'length', 'max'=>80),
			array('admin_input', 'length', 'max'=>50),
			array('field_input_type, validation_rule, default_value', 'length', 'max'=>255),
			array('description', 'length', 'max'=>100),
			array('admin_label, created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('field_id, field_name, table_id, admin_rights, display_status, admin_label, admin_input, field_length, field_type, field_input_type, is_unique, is_required, incremental_start, validation_rule, default_value, is_custom, description, created_date, modified_date', 'safe', 'on'=>'search'),
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
			'field_id' => 'Field',
			'field_name' => 'Field Name',
			'table_id' => 'Table',
			'admin_rights' => 'Admin Rights',
			'display_status' => 'Display Status',
			'admin_label' => 'Admin Label',
			'admin_input' => 'Admin Input',
			'field_length' => 'Field Length',
			'field_type' => 'Field Type',
			'field_input_type' => 'Field Input Type',
			'is_unique' => 'Is Unique',
			'is_required' => 'Is Required',
			'incremental_start' => 'Incremental Start',
			'validation_rule' => 'Validation Rule',
			'default_value' => 'Default Value',
			'is_custom' => 'Is Custom',
			'description' => 'Description',
			'created_date' => 'Created Date',
			'modified_date' => 'Modified Date',
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

		$criteria->compare('field_id',$this->field_id,true);
		$criteria->compare('field_name',$this->field_name,true);
		$criteria->compare('table_id',$this->table_id);
		$criteria->compare('admin_rights',$this->admin_rights);
		$criteria->compare('display_status',$this->display_status);
		$criteria->compare('admin_label',$this->admin_label,true);
		$criteria->compare('admin_input',$this->admin_input,true);
		$criteria->compare('field_length',$this->field_length);
		$criteria->compare('field_type',$this->field_type,true);
		$criteria->compare('field_input_type',$this->field_input_type,true);
		$criteria->compare('is_unique',$this->is_unique);
		$criteria->compare('is_required',$this->is_required);
		$criteria->compare('incremental_start',$this->incremental_start);
		$criteria->compare('validation_rule',$this->validation_rule,true);
		$criteria->compare('default_value',$this->default_value,true);
		$criteria->compare('is_custom',$this->is_custom);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('modified_date',$this->modified_date,true);

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
	 * @return CylFields the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
