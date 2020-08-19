<?php

class NetellerModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application


		//PRODUCTION
		/*	define('NETELLERPAYMENT_URL', "https://api.neteller.com/");
            define('NETELLERCLIENT_ID', "");
            define('NETELLECLIENT_SECRET', "");
        */
		// import the module-level models and components
		$this->setImport(array(
			'neteller.models.*',
			'neteller.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;

	}
}
