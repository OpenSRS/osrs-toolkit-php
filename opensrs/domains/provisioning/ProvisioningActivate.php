<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class ProvisioningActivate extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct( $formatString, $dataObject ) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject() {
		// Command required values
		if(
			(!isset($this->_dataObject->data->cookie) ||
				$this->_dataObject->data->cookie == "") &&
			(!isset($this->_dataObject->data->bypass) ||
				$this->_dataObject->data->bypass == "" )
		) {
			throw new Exception( "oSRS Error - cookie / bypass is not defined." );
		}
		if(
			isset( $this->_dataObject->data->cookie ) &&
			$this->_dataObject->data->cookie != "" &&
	  		isset( $this->_dataObject->data->bypass ) &&
	  		$this->_dataObject->data->bypass != ""
  		) {
			throw new Exception( "oSRS Error - Both cookie and bypass cannot be set in one call." );
		}
		if(
			!isset( $this->_dataObject->data->domainname )
		) {
			throw new Exception( "oSRS Error - domainname is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			"protocol" => "XCP",
			"action" => "activate",
			"object" => "domain",
//			"cookie" => $this->_dataObject->data->cookie,
			"attributes" => array(
				'domainname' => $this->_dataObject->data->domainname
			)
		);

		// Cookie / bypass
		if(
			isset($this->_dataObject->data->cookie) &&
			$this->_dataObject->data->cookie != ""
		) {
			$cmd['cookie'] = $this->_dataObject->data->cookie;
		}
		if(
			isset($this->_dataObject->data->bypass) &&
			$this->_dataObject->data->bypass != ""
		) {
			$cmd['domain'] = $this->_dataObject->data->bypass;
		}

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode( $cmd );
		// Send XML
		$XMLresult = $this->send_cmd( $xmlCMD );
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode( $XMLresult );

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}
}