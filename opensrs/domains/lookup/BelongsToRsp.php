<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - domain
 */

class BelongsToRsp extends openSRS_base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct($formatString, $dataObject) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject(){
		if (!isset($this->_dataObject->data->domain)) {
			throw new Exception( "oSRS Error - Search domain string not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest(){
		$cmd = array(
			"protocol" => "XCP",
			"action" => "belongs_to_rsp",
			"object" => "domain",
			"attributes" => array (
				"domain" => $this->_dataObject->data->domain
				)
			);

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
