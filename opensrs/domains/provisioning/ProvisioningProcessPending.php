<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class ProvisioningProcessPending extends Base {
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
			!isset( $this->_dataObject->data->order_id ) ||
			$this->_dataObject->data->order_id == ""
		) {
			throw new Exception( "oSRS Error - order_id is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'process_pending',
			'object' => 'domain',
			'attributes' => array(
				'order_id' => $this->_dataObject->data->order_id
			)
		);

		// Command optional values
		if(
			isset( $this->_dataObject->data->owner_address ) &&
			$this->_dataObject->data->owner_address != ""
		) {
			$cmd['attributes']['owner_address'] = $this->_dataObject->data->owner_address;
		}
		if(
			isset( $this->_dataObject->data->command ) &&
			$this->_dataObject->data->command != ""
		) {
			$cmd['attributes']['command'] = $this->_dataObject->data->command;
		}
		if(
			isset( $this->_dataObject->data->fax_received ) &&
			$this->_dataObject->data->fax_received != ""
		) {
			$cmd['attributes']['fax_received'] = $this->_dataObject->data->fax_received;
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