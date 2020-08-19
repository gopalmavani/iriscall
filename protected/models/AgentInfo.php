<?php

/**
 * This is the model class for table "agent_info".
 *
 * The followings are the available columns in table 'agent_info':
 * @property string $id
 * @property integer $agent_number
 * @property string $agent_name
 * @property string $asset_manager
 * @property string $asset_manager_logo
 * @property string $asset_manager_link
 * @property double $minimum_deposit
 * @property double $minimum_self_node_balance
 * @property double $minimum_profit_node_balance
 * @property integer $self_node_license_count
 * @property integer $profit_node_license_count
 * @property string $commission_distribution_mechanism
 * @property integer $wallet_reference_id
 * @property string $created_at
 * @property string $modified_at
 *
 * The followings are the available model relations:
 * @property AgentDetails[] $agentDetails
 * @property WalletMetaEntity $walletReference
 */
class AgentInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'agent_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_reference_id, created_at', 'required'),
			array('agent_number, self_node_license_count, profit_node_license_count, wallet_reference_id', 'numerical', 'integerOnly'=>true),
			array('minimum_deposit, minimum_self_node_balance, minimum_profit_node_balance', 'numerical'),
			array('agent_name, asset_manager, asset_manager_logo, asset_manager_link, commission_distribution_mechanism', 'length', 'max'=>200),
			array('modified_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, agent_number, agent_name, asset_manager, asset_manager_logo, asset_manager_link, minimum_deposit, minimum_self_node_balance, minimum_profit_node_balance, self_node_license_count, profit_node_license_count, commission_distribution_mechanism, wallet_reference_id, created_at, modified_at', 'safe', 'on'=>'search'),
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
			'agentDetails' => array(self::HAS_MANY, 'AgentDetails', 'agent_number'),
			'walletReference' => array(self::BELONGS_TO, 'WalletMetaEntity', 'wallet_reference_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'agent_number' => 'Agent Number',
			'agent_name' => 'Agent Name',
			'asset_manager' => 'Asset Manager',
			'asset_manager_logo' => 'Asset Manager Logo',
			'asset_manager_link' => 'Asset Manager Link',
			'minimum_deposit' => 'Minimum Deposit',
			'minimum_self_node_balance' => 'Minimum Self Node Balance',
			'minimum_profit_node_balance' => 'Minimum Profit Node Balance',
			'self_node_license_count' => 'Self Node License Count',
			'profit_node_license_count' => 'Profit Node License Count',
			'commission_distribution_mechanism' => 'Commission Distribution Mechanism',
			'wallet_reference_id' => 'Wallet Reference',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('agent_number',$this->agent_number);
		$criteria->compare('agent_name',$this->agent_name,true);
		$criteria->compare('asset_manager',$this->asset_manager,true);
		$criteria->compare('asset_manager_logo',$this->asset_manager_logo,true);
		$criteria->compare('asset_manager_link',$this->asset_manager_link,true);
		$criteria->compare('minimum_deposit',$this->minimum_deposit);
		$criteria->compare('minimum_self_node_balance',$this->minimum_self_node_balance);
		$criteria->compare('minimum_profit_node_balance',$this->minimum_profit_node_balance);
		$criteria->compare('self_node_license_count',$this->self_node_license_count);
		$criteria->compare('profit_node_license_count',$this->profit_node_license_count);
		$criteria->compare('commission_distribution_mechanism',$this->commission_distribution_mechanism);
		$criteria->compare('wallet_reference_id',$this->wallet_reference_id);
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
	 * @return AgentInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
