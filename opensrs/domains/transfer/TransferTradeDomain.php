<?php

namespace opensrs\domains\transfer;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class TransferTradeDomain extends Base {
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
			!isset( $this->_dataObject->data->first_name ) ||
			$this->_dataObject->data->first_name == ""
		) {
			throw new Exception( "oSRS Error - first_name is not defined." );
		}
		if(
			!isset( $this->_dataObject->data->last_name ) ||
			$this->_dataObject->data->last_name == ""
		) {
			throw new Exception( "oSRS Error - last_name is not defined." );
		}
		if(
			!isset( $this->_dataObject->data->domain ) ||
			$this->_dataObject->data->domain == ""
		) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
		if(
			!isset( $this->_dataObject->data->email ) ||
			$this->_dataObject->data->email == ""
		) {
			throw new Exception( "oSRS Error - email is not defined." );
		}
		if(
			!isset( $this->_dataObject->data->org_name ) ||
			$this->_dataObject->data->org_name == ""
		) {
			throw new Exception( "oSRS Error - org_name is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'TRADE_DOMAIN',
			'object' => 'DOMAIN',
			'attributes' => array(
				'first_name' => $this->_dataObject->data->first_name,
				'last_name' => $this->_dataObject->data->last_name,
				'domain' => $this->_dataObject->data->domain,
				'email' => $this->_dataObject->data->email,
				'org_name' => $this->_dataObject->data->org_name
			)
		);

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