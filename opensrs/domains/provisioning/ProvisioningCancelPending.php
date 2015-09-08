<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class ProvisioningCancelPending extends Base {
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
			!isset( $this->_dataObject->data->to_date ) ||
			$this->_dataObject->data->to_date == ""
		) {
			throw new Exception( "oSRS Error - to_date is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'cancel_pending_orders',
			'object' => 'order',
			'attributes' => array(
				'to_date' => $this->_dataObject->data->to_date
			)
		);

		// Command optional values
		if(
			isset( $this->_dataObject->data->status ) &&
			$this->_dataObject->data->status != ""
		) {
			$cmd['attributes']['status'] = explode( ",", $this->_dataObject->data->status );
		}

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode( $cmd );
		// Send XML
		$XMLresult = $this->send_cmd( $xmlCMD );
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode( $XMLresult );

		// Results
		$this->resultFullRaw = $arrayResult;

        if( isset($arrayResult['attributes'] )) {
            $this->resultRaw = $arrayResult['attributes'];
        } else {
			$this->resultRaw = $arrayResult;
		}

		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}
}