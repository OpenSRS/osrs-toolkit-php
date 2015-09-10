<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class ProvisioningRenew extends Base {
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
			!isSet( $this->_dataObject->data->auto_renew ) ||
			$this->_dataObject->data->auto_renew == ""
		) {
			throw new Exception( "oSRS Error - auto_renew is not defined." );
		}
		if(
			!isSet( $this->_dataObject->data->currentexpirationyear ) ||
			$this->_dataObject->data->currentexpirationyear == ""
		) {
			throw new Exception( "oSRS Error - currentexpirationyear is not defined." );
		}
		if(
			!isSet( $this->_dataObject->data->domain ) ||
			$this->_dataObject->data->domain == ""
		) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
		if(
			!isSet( $this->_dataObject->data->handle ) ||
			$this->_dataObject->data->handle == ""
		) {
			throw new Exception( "oSRS Error - handle is not defined." );
		}
		if(
			!isSet( $this->_dataObject->data->period ) ||
			$this->_dataObject->data->period == ""
		) {
			throw new Exception( "oSRS Error - period is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'renew',
			'object' => 'DOMAIN',
			'attributes' => array(
			    'auto_renew' => $this->_dataObject->data->auto_renew,
			    'currentexpirationyear' => $this->_dataObject->data->currentexpirationyear,
			    'domain' => $this->_dataObject->data->domain,
			    'handle' => $this->_dataObject->data->handle,
			    'period' => $this->_dataObject->data->period
			)
		);

		// Command optional values
		if(
			isSet( $this->_dataObject->data->f_parkp ) &&
			$this->_dataObject->data->f_parkp != ""
		) {
			$cmd['attributes']['f_parkp'] = $this->_dataObject->data->f_parkp;
		}
		if(
			isSet( $this->_dataObject->data->affiliate_id ) &&
			$this->_dataObject->data->affiliate_id != ""
		) {
			$cmd['attributes']['affiliate_id'] = $this->_dataObject->data->affiliate_id;
		}

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode( $cmd );
		// Send XML
		$XMLresult = $this->send_cmd( $xmlCMD );
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode( $XMLresult );

		// Results
		$this->resultFullRaw = $arrayResult;
                if( isSet($arrayResult['attributes'] )) {
                    $this->resultRaw = $arrayResult['attributes'];
                } else {
			$this->resultRaw = $arrayResult;
		}
		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}
}