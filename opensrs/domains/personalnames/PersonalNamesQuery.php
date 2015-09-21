<?php

namespace opensrs\domains\personalnames;

use OpenSRS\Base;
use OpenSRS\Exception;

class PersonalNamesQuery extends Base {
	public $action = "query";
	public $object = "surname";

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
			!isset( $dataObject->attributes->domain ) ||
			$dataObject->attributes->domain == ""
		) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
	}
}