<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class ProvisioningModify extends Base {
	public $action = "modify";
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
		if( empty($dataObject->cookie) && empty($dataObject->attributes->domain ) ) {
			throw new Exception( "oSRS Error - cookie and/or domain is not defined." );
		}

		if( !isset($dataObject->attributes->affect_domains) || $dataObject->attributes->affect_domains == "" ) {
			throw new Exception( "oSRS Error - affect_domains is not defined." );
		}
		if( !isset($dataObject->attributes->data) || $dataObject->attributes->data == "" ) {
			throw new Exception( "oSRS Error - data variable that defines the modify type is not defined." );
		}
	}
}
