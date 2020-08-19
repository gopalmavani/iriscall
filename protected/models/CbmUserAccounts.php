<?php

/**
 * This is the model class for table "cbm_user_accounts".
 *
 * The followings are the available columns in table 'cbm_user_accounts':
 * @property string $user_account_id
 * @property string $user_account_num
 * @property string $login
 * @property string $type
 * @property string $email_address
 * @property string $beneficiary
 * @property integer $agent_num
 * @property double $balance
 * @property double $equity
 * @property double $max_balance
 * @property double $max_equity
 * @property integer $matrix_node_num
 * @property integer $matrix_id
 * @property string $user_ownership
 * @property string $added_to_matrix_at
 * @property string $created_at
 * @property string $modified_at
 * @property string $previous_login
 * @property integer $cluster_id
 */
class CbmUserAccounts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cbm_user_accounts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('agent_num, matrix_node_num, matrix_id, cluster_id', 'numerical', 'integerOnly'=>true),
			array('balance, equity, max_balance, max_equity', 'numerical'),
			array('user_account_num', 'length', 'max'=>45),
			array('login', 'length', 'max'=>11),
			array('email_address, beneficiary', 'length', 'max'=>100),
			array('user_ownership, type', 'length', 'max'=>50),
			array('previous_login', 'length', 'max'=>20),
			array('type, added_to_matrix_at, created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('user_account_id, user_account_num, login, type, email_address, beneficiary, agent_num, balance, equity, max_balance, max_equity, matrix_node_num, matrix_id, user_ownership, added_to_matrix_at, created_at, modified_at, previous_login, cluster_id', 'safe', 'on'=>'search'),
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
			'user_account_id' => 'User Account',
			'user_account_num' => 'User Account Num',
			'login' => 'Login',
			'type' => 'Type',
			'email_address' => 'Email Address',
			'beneficiary' => 'Beneficiary',
			'agent_num' => 'Agent Num',
			'balance' => 'Balance',
			'equity' => 'Equity',
			'max_balance' => 'Max Balance',
			'max_equity' => 'Max Equity',
			'matrix_node_num' => 'Matrix Node Num',
			'matrix_id' => 'Matrix',
			'user_ownership' => 'User Ownership',
			'added_to_matrix_at' => 'Added To Matrix At',
			'created_at' => 'Created At',
			'modified_at' => 'Modified At',
			'previous_login' => 'Previous Login',
			'cluster_id' => 'Cluster',
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

		$criteria->compare('user_account_id',$this->user_account_id,true);
		$criteria->compare('user_account_num',$this->user_account_num,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('beneficiary',$this->beneficiary,true);
		$criteria->compare('agent_num',$this->agent_num);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('equity',$this->equity);
		$criteria->compare('max_balance',$this->max_balance);
		$criteria->compare('max_equity',$this->max_equity);
		$criteria->compare('matrix_node_num',$this->matrix_node_num);
		$criteria->compare('matrix_id',$this->matrix_id);
		$criteria->compare('user_ownership',$this->user_ownership,true);
		$criteria->compare('added_to_matrix_at',$this->added_to_matrix_at,true);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('previous_login',$this->previous_login,true);
		$criteria->compare('cluster_id',$this->cluster_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CbmUserAccounts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
