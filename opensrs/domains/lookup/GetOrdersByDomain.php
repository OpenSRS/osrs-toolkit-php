<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  - none -
 *
 *  Optional Data:
 *  data - owner_email, admin_email, billing_email, tech_email, del_from, del_to, exp_from, exp_to, page, limit
 */

class GetOrdersByDomain extends Base {
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
		if (!isset($this->_dataObject->data->domain)) {
			throw new Exception( "oSRS Error - Domain is not defined.", E_USER_WARNING);
			$allPassed = false;
		}

		// Execute the command
		$this->_processRequest ();
	}

	// Post validation functions
	private function _processRequest (){
		$cmd = array(
			"protocol" => "XCP",
			"action" => "GET_ORDERS_BY_DOMAIN",
			"object" => "DOMAIN",
			"attributes" => array (
				'domain' => $this->_dataObject->data->domain
				)
			);
		
		// Command optional values
		if (isset($this->_dataObject->data->page) && $this->_dataObject->data->page != "") $cmd['attributes']['page'] = $this->_dataObject->data->page;
		if (isset($this->_dataObject->data->order_from) && $this->_dataObject->data->order_from != "") $cmd['attributes']['order_from'] = $this->_dataObject->data->order_from;
		if (isset($this->_dataObject->data->status) && $this->_dataObject->data->status != "") $cmd['attributes']['status'] = $this->_dataObject->data->status;
		if (isset($this->_dataObject->data->type) && $this->_dataObject->data->type != "") $cmd['attributes']['type'] = $this->_dataObject->data->type;
		if (isset($this->_dataObject->data->limit) && $this->_dataObject->data->limit != "") $cmd['attributes']['limit'] = $this->_dataObject->data->limit;
		if (isset($this->_dataObject->data->order_to) && $this->_dataObject->data->order_to != "") $cmd['attributes']['order_to'] = $this->_dataObject->data->order_to;

		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML
		$arrayResult = $this->_opsHandler->decode($XMLresult);		// Flip XML to Array

		// Results
		$this->resultFullRaw = $arrayResult;
		if (isset($arrayResult['attributes'])){
			$this->resultRaw = $arrayResult['attributes'];
		} else {
			$this->resultRaw = $arrayResult;
		}
		$this->resultFullFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
	}
}
