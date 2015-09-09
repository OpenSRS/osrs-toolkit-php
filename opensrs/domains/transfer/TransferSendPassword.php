<?php

namespace opensrs\domains\transfer;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class TransferSendPassword extends Base {
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
			!isset( $this->_dataObject->data->domain_name ) || 
			$this->_dataObject->data->domain_name == ""
		) {
			throw new Exception( "oSRS Error - domain_name is not defined." );
		}
				
		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'send_password',
			'object' => 'transfer',
			'attributes' => array(
				'domain_name' => $this->_dataObject->data->domain_name
			)
		);
		
		$xmlCMD = $this->_opsHandler->encode( $cmd );					// Flip Array to XML
		$XMLresult = $this->send_cmd( $xmlCMD );						// Send XML
		$arrayResult = $this->_opsHandler->decode( $XMLresult );		// Flip XML to Array

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}
}