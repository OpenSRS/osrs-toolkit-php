<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

class GetDomainsByExpiry extends Base {
	public $action = "get_domains_by_expiredate";
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

	public function __destruct () {
		parent::__destruct();
	}

	// Validate the object
	public function _validateObject( $dataObject ){
		if (!isset($dataObject->attributes->exp_from)) {
			throw new Exception( "oSRS Error - exp_from is not defined." );
		}

		if (!isset($dataObject->attributes->exp_to)) {
			throw new Exception( "oSRS Error - exp_to is not defined." );
		}
	}
}
