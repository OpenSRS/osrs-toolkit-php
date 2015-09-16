<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

class ProvisioningRenew extends Base {
	public $action = "renew";
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

	// Validate the object
	public function _validateObject( $dataObject ) {
		// Command required values
		if(
			!isSet( $dataObject->attributes->auto_renew ) ||
			$dataObject->attributes->auto_renew == ""
		) {
			throw new Exception( "oSRS Error - auto_renew is not defined." );
		}
		if(
			!isSet( $dataObject->attributes->currentexpirationyear ) ||
			$dataObject->attributes->currentexpirationyear == ""
		) {
			throw new Exception( "oSRS Error - currentexpirationyear is not defined." );
		}
		if(
			!isSet( $dataObject->attributes->domain ) ||
			$dataObject->attributes->domain == ""
		) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
		if(
			!isSet( $dataObject->attributes->handle ) ||
			$dataObject->attributes->handle == ""
		) {
			throw new Exception( "oSRS Error - handle is not defined." );
		}
		if(
			!isSet( $dataObject->attributes->period ) ||
			$dataObject->attributes->period == ""
		) {
			throw new Exception( "oSRS Error - period is not defined." );
		}
	}
}