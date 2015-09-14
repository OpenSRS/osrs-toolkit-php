<?php

namespace opensrs\domains\authentication;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class AuthenticationChangeOwnership extends Base {
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

		// $bc = new \OpenSRS\backwardcompatibility\dataconversion\domains\authentication\AuthenticationChangeOwnership;

		// $this->_dataObject = $bc->convertDataObject( $dataObject );

		// $this->send();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject() {
		if( !isset($this->_dataObject->data->cookie ) ) {
			throw new Exception( "oSRS Error - cookie is not defined." );
		}

		if( !isset($this->_dataObject->data->username ) ) {
			throw new Exception( "oSRS Error - username is not defined." );
		}

		if( !isset($this->_dataObject->data->password ) ) {
			throw new Exception( "oSRS Error - password is not defined." );
		}

		// Execute the command
			$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			"protocol" => "XCP",
			"action" => "CHANGE",
			"object" => "OWNERSHIP",
			"cookie" => $this->_dataObject->data->cookie,
//			"registrant_ip" => "12.34.56.78",
			"attributes" => array(
				"username" => $this->_dataObject->data->username,
				"password" => $this->_dataObject->data->password
			)
		);

		// Command optional values
		if(
			isset( $this->_dataObject->data->move_all ) &&
			$this->_dataObject->data->move_all != ""
		) {
			$cmd['attributes']['move_all'] = $this->_dataObject->data->move_all;
		}
		if(
			isset( $this->_dataObject->data->reg_domain ) &&
			$this->_dataObject->data->reg_domain != ""
		) {
			$cmd['attributes']['reg_domain'] = $this->_dataObject->data->reg_domain;
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