<?php

namespace opensrs\domains\authentication;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - 
 */
 
class ChangePassword extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct ($formatString, $dataObject) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject ();
	}

	public function __destruct () {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject (){
		if (!isset($this->_dataObject->data->reg_password)) {
			throw new Exception("oSRS Error - New Password is not defined.");
		}

		// Execute the command
		$this->_processRequest ();
	}

	// Post validation functions
	private function _processRequest (){
		$cmd = array(
			"protocol" => "XCP",
			"action" => "CHANGE",
			"object" => "PASSWORD",
//			"registrant_ip" => "12.34.56.78",
			"attributes" => array (
				"reg_password" => $this->_dataObject->data->reg_password
			)
		);
		
		// Command optional values
		if (isset($this->_dataObject->data->cookie) && $this->_dataObject->data->cookie != "") $cmd['cookie'] = $this->_dataObject->data->cookie;
		if (isset($this->_dataObject->data->domain) && $this->_dataObject->data->domain != "") $cmd['domain'] = $this->_dataObject->data->domain;
		
		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML
		$arrayResult = $this->_opsHandler->decode($XMLresult);		// Flip XML to Array

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
	}
}