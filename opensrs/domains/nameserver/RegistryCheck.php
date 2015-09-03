<?php

namespace opensrs\domains\nameserver;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class RegistryCheck extends Base {
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
			!isset( $this->_dataObject->data->fqdn ) ||
			$this->_dataObject->data->fqdn == ""
		) {
			throw new Exception( "oSRS Error - fqdn is not defined." );
		}
		if(
			!isset( $this->_dataObject->data->tld ) ||
			$this->_dataObject->data->tld == ""
		) {
			throw new Exception( "oSRS Error - tld is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'REGISTRY_CHECK_NAMESERVER',
			'object' => 'NAMESERVER',
			'attributes' => array(
				'fqdn' => $this->_dataObject->data->fqdn,
				'tld' => $this->_dataObject->data->tld
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