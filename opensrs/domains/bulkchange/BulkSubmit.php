<?php

namespace opensrs\domains\bulkchange;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class BulkSubmit extends Base {
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
			!isset( $this->_dataObject->data->change_items ) ||
			$this->_dataObject->data->change_items == ""
		) {
			throw new Exception( "oSRS Error - change_items is not defined." );
		}
				
		if(
			!isset( $this->_dataObject->data->change_type ) ||
			$this->_dataObject->data->change_type == ""
		) {
			throw new Exception( "oSRS Error - change_type is not defined." );
		}

		if(
			!isset( $this->_dataObject->data->op_type ) ||
			$this->_dataObject->data->op_type == ""
		) {
			throw new Exception( "oSRS Error - op_type is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions

	private function _processRequest() {

        $this->_dataObject->data->change_items = explode( ",", $this->_dataObject->data->change_items );

		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'submit',
			'object' => 'bulk_change',
			'attributes' => array(
				'change_items' => $this->_dataObject->data->change_items,
				'change_type' => $this->_dataObject->data->change_type,
				'op_type' => $this->_dataObject->data->op_type,
			)
		);
		
		// Command optional values
		if(
			isset( $this->_dataObject->data->contact_email ) &&
			$this->_dataObject->data->contact_email != ""
		) {
				$cmd['attributes']['contact_email'] = $this->_dataObject->data->contact_email;
		}
		if(
			isset( $this->_dataObject->data->apply_to_locked_domains ) &&
			$this->_dataObject->data->apply_to_locked_domains != ""
		) {
				$cmd['attributes']['apply_to_locked_domains'] = $this->_dataObject->data->apply_to_locked_domains;
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
