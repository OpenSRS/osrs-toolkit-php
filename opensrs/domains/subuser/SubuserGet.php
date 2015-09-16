<?php

namespace opensrs\domains\subuser;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class SubuserGet extends Base {
	public $action = "get";
	public $object = "subuser";

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
		// Command required values
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
			!isset( $dataObject->attributes->username ) ||
			$dataObject->attributes->username == ""
		) {
			throw new Exception( "oSRS Error - username is not defined." );
		}
	}
}