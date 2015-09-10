<?php

namespace opensrs\domains\transfer;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class TransferRsp2Rsp extends Base {
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
			!isset( $this->_dataObject->data->domain ) ||
			$this->_dataObject->data->domain == ""
		) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
		if(
			!isset( $this->_dataObject->data->grsp ) ||
			$this->_dataObject->data->grsp == ""
		) {
			throw new Exception( "oSRS Error - grsp is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'RSP2RSP_PUSH_TRANSFER',
			'object' => 'domain',
			'attributes' => array(
				'domain' => $this->_dataObject->data->domain,
				'grsp' => $this->_dataObject->data->grsp
			)
		);

		// Command optional values
		if(
			isset( $this->_dataObject->data->username ) &&
			$this->_dataObject->data->username != ""
		) {
			$cmd['attributes']['username'] = $this->_dataObject->data->username;
		}
		if(
			isset( $this->_dataObject->data->password ) &&
			$this->_dataObject->data->password != ""
		) {
			$cmd['attributes']['password'] = $this->_dataObject->data->password;
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