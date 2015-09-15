<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

class ProvisioningCancelActivate extends Base {
	public $action = "cancel_active_process";
	public $object = "domain";

	public $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct( $formatString, $dataObject, $returnFullResponse = true ) {
		parent::__construct();

		$this->_formatHolder = $formatString;

		$this->_validateObject( $dataObject );

		$this->send( $dataObject, $returnFullResponse );
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	public function _validateObject( $dataObject ) {
		if(
			(!isset($dataObject->attributes->order_id) ||
				$dataObject->attributes->order_id == "") &&
			(!isset($dataObject->attributes->domain) ||
				$dataObject->attributes->domain == "" )
		) {
			throw new Exception( "oSRS Error - order_id / domain is not defined." );
		}
		if(
			isset( $dataObject->attributes->order_id ) &&
			$dataObject->attributes->order_id != "" &&
	  		isset( $dataObject->attributes->domain ) &&
	  		$dataObject->attributes->domain != ""
  		) {
			throw new Exception( "oSRS Error - Both order_id and domain cannot be set in one call." );
		}
	}
}
