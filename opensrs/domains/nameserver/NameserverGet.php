<?php

namespace opensrs\domains\nameserver;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class NameserverGet extends Base {
	public $action = "get";
	public $object = "nameserver";

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
			 throw new Exception( "oSRS Error - cookie / bypass is not defined." );
		}
		if(
			isset( $dataObject->cookie ) &&
			$dataObject->cookie != "" &&
	  		isset( $dataObject->attributes->domain ) &&
	  		$dataObject->attributes->domain != ""
  		) {
			 throw new Exception( "oSRS Error - Both cookie and bypass cannot be set in one call." );
		}
		if(
			!isset( $dataObject->attributes->name ) ||
			$dataObject->attributes->name == ""
		) {
			 throw new Exception( "oSRS Error - name is not defined." );
		}
	}
}