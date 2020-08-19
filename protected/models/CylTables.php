<?php

/**
 * This is the model class for table "cyl_tables".
 *
 * @author Yuvraj Jhala <png625@gmail.com>
 *
 * The followings are the available columns in table 'cyl_tables':
 * @property string $table_id
 * @property string $table_name
 * @property string $module_name
 * @property integer $isMenu
 * @property string $menu_icon
 * @property integer $menu_order
 * @property string $menu_name
 * @property string $action
 * @property integer $is_editable
 * @property integer $display_status
 * @property integer $parent_item
 * @property string $created_date
 * @property string $modified_date

 */
class CylTables extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cyl_tables';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('module_name', 'required'),
			array('isMenu, menu_order, is_editable, display_status, parent_item', 'numerical', 'integerOnly'=>true),
			array('table_name', 'length', 'max'=>255),
			array('module_name, menu_icon, menu_name, action', 'length', 'max'=>50),
			array('created_date, modified_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('table_id, table_name, module_name, isMenu, menu_icon, menu_order, menu_name, action, is_editable, display_status, parent_item, created_date, modified_date', 'safe', 'on'=>'search'),
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
			'table_id' => 'Table',
			'table_name' => 'Table Name',
			'module_name' => 'Module Name',
			'isMenu' => 'Is Menu',
			'menu_icon' => 'Menu Icon',
			'menu_order' => 'Menu Order',
			'menu_name' => 'Menu Name',
			'action' => 'Action',
			'is_editable' => 'Is Editable',
			'display_status' => 'Display Status',
			'parent_item' => 'Parent Item',
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

		$criteria->compare('table_id',$this->table_id,true);
		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('module_name',$this->module_name,true);
		$criteria->compare('isMenu',$this->isMenu);
		$criteria->compare('menu_icon',$this->menu_icon,true);
		$criteria->compare('menu_order',$this->menu_order);
		$criteria->compare('menu_name',$this->menu_name,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('is_editable',$this->is_editable);
		$criteria->compare('display_status',$this->display_status);
		$criteria->compare('parent_item',$this->parent_item);
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
	 * @return CylTables the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
