<?php

namespace opensrs\domains\nameserver;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class Get extends Base {
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
			( !isset($this->_dataObject->data->cookie ) ||
				$this->_dataObject->data->cookie == "") &&
			( !isset($this->_dataObject->data->bypass ) ||
				$this->_dataObject->data->bypass == "")
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
			!isset( $this->_dataObject->data->name ) ||
			$this->_dataObject->data->name == ""
		) {
			 throw new Exception( "oSRS Error - name is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'get',
			'object' => 'nameserver',
//			'cookie' => $this->_dataObject->data->cookie,
//			'registrant_ip' => '12.34.56.78',
			'attributes' => array(
				'name' => $this->_dataObject->data->name
			)
		);

		// Cookie / bypass
		if(
			isset( $this->_dataObject->data->cookie ) &&
			$this->_dataObject->data->cookie != ""
		) {
			$cmd['cookie'] = $this->_dataObject->data->cookie;
		}
		if(
			isset( $this->_dataObject->data->bypass ) &&
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
		if(
			isset( $arrayResult['attributes'] )
		) {
			$this->resultRaw = $arrayResult['attributes'];
		} else {
			$this->resultRaw = $arrayResult;
		}
		$this->resultFullFormatted = convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}
}