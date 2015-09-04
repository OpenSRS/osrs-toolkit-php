<?php

namespace opensrs\domains\personalnames;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class SURegister extends Base {
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
		if( !isset($this->_dataObject->data->domain) || $this->_dataObject->data->domain == "" ) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
		if( !isset($this->_dataObject->data->mailbox_type) || $this->_dataObject->data->mailbox_type == "" ) {
			throw new Exception( "oSRS Error - mailbox_type is not defined." );
		}
		if( !isset($this->_dataObject->data->password) || $this->_dataObject->data->password == "" ) {
			throw new Exception( "oSRS Error - password is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'SU_REGISTER',
			'object' => 'SURNAME',
			'attributes' => array(
				'domain' => $this->_dataObject->data->domain,
				'mailbox' => array(
					'mailbox_type' => $this->_dataObject->data->mailbox_type,
					'password' => $this->_dataObject->data->password
				)
			)
		);

		// Command optional values
		if(
			isset( $this->_dataObject->data->forward_email ) &&
			$this->_dataObject->data->forward_email != ""
		) {
			$cmd['attributes']['mailbox']['forward_email'] = $this->_dataObject->data->forward_email;
		}

		$content = "";
		$name = "";
		$type = "";

		if(
			isset( $this->_dataObject->data->content ) &&
			$this->_dataObject->data->content != ""
		) {
			$content = $this->_dataObject->data->content;
		}
		if(
			isset( $this->_dataObject->data->name ) &&
			$this->_dataObject->data->name != ""
		) {
			$name = $this->_dataObject->data->name;
		}
		if(
			isset( $this->_dataObject->data->type ) &&
			$this->_dataObject->data->type != ""
		) {
			$type = $this->_dataObject->data->type;
		}

		if( $content != "" && $name != "" && $type != "" ) {
			$cmd['attributes']['dnsRecords']['content'] = $content;
			$cmd['attributes']['dnsRecords']['name'] = $name;
			$cmd['attributes']['dnsRecords']['type'] = $type;
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