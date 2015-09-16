<?php

namespace opensrs\domains\nameserver;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class NameserverAdvancedUpdate extends Base {
	public $action = "advanced_update_nameservers";
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
			( !isset($dataObject->cookie ) ||
				$dataObject->cookie == "") &&
			( !isset($dataObject->attributes->domain ) ||
				$dataObject->attributes->domain == "")
		) {
			throw new Exception( "oSRS Error - cookie / domain is not defined." );
		}
		if(
			isset( $dataObject->cookie ) &&
			$dataObject->cookie != "" &&
		  	isset( $dataObject->attributes->domain ) &&
		  	$dataObject->attributes->domain != ""
	  	) {
			throw new Exception( "oSRS Error - Both cookie and domain cannot be set in one call." );
		}

		if(
			!isset( $dataObject->attributes->op_type ) ||
			$dataObject->attributes->op_type == ""
		) {
			throw new Exception( "oSRS Error - op_type is not defined." );
		}
	}
}