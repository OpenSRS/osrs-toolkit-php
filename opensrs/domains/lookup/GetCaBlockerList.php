<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - domain - .CA only
 */

class GetCaBlockerList extends Base {
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
		$this->_validateObject ();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	public function _validateObject( $dataObject ){
		if (!isset($this->_dataObject->data->domain)) {
			throw new Exception("oSRS Error - Search domain string not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest(){
		$cmd = array(
			"protocol" => "XCP",
			"action" => "get_ca_blocker_list",
			"object" => "domain",
			"attributes" => array (
				"domain" => $this->_dataObject->data->domain
				)
			);

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode($cmd);
		// Send XML
		$XMLresult = $this->send_cmd($xmlCMD);
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode($XMLresult);

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}
}
