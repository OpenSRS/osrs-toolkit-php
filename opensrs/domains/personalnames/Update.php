<?php

namespace opensrs\domains\personalnames;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class Update extends Base {
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

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'UPDATE',
			'object' => 'SURNAME',
			'attributes' => array(
				'domain' => $this->_dataObject->data->domain
			)
		);

		// Command optional values
		if(
			isset( $this->_dataObject->data->mailbox_type ) &&
			$this->_dataObject->data->mailbox_type != ""
		) {
			$cmd['attributes']['mailbox']['mailbox_type'] = $this->_dataObject->data->mailbox_type;
		}
		if(
			isset( $this->_dataObject->data->password ) &&
			$this->_dataObject->data->password != ""
		) {
			$cmd['attributes']['mailbox']['password'] = $this->_dataObject->data->password;
		}
		if(
			isset( $this->_dataObject->data->disable_forward_email ) &&
			$this->_dataObject->data->disable_forward_email != ""
		) {
			$cmd['attributes']['mailbox']['disable_forward_email'] = $this->_dataObject->data->disable_forward_email;
		}
		if(
			isset( $this->_dataObject->data->forward_email ) &&
			$this->_dataObject->data->forward_email != ""
		) {
			$cmd['attributes']['mailbox']['forward_email'] = $this->_dataObject->data->forward_email;
		}
		if(
			isset( $this->_dataObject->data->type ) &&
			$this->_dataObject->data->type != ""
		) {
			$cmd['attributes']['dnsRecords'][0]['type'] = $this->_dataObject->data->type;
		}
		if(
			isset( $this->_dataObject->data->name ) &&
			$this->_dataObject->data->name != ""
		) {
			$cmd['attributes']['dnsRecords'][0]['name'] = $this->_dataObject->data->name;
		}
		if(
			isset( $this->_dataObject->data->content ) &&
			$this->_dataObject->data->content != ""
		) {
			$cmd['attributes']['dnsRecords'][0]['content'] = $this->_dataObject->data->content;
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
