<?php

namespace opensrs\domains\cookie;

use OpenSRS\Base;
use OpenSRS\Exception;

class CookieUpdate extends Base {
	public $action = "update";
	public $object = "cookie";

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
		if( !isset($dataObject->attributes->reg_username ) ) {
			throw new Exception( "oSRS Error - reg_username is not defined." );
		}

		if( !isset($dataObject->attributes->reg_password ) ) {
			throw new Exception( "oSRS Error - reg_password is not defined." );
		}

		if( !isset($dataObject->attributes->domain ) ) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}

		if( !isset($dataObject->attributes->domain_new ) ) {
			throw new Exception( "oSRS Error - domain_new is not defined." );
		}

		if( !isset($dataObject->cookie ) ) {
			throw new Exception( "oSRS Error - cookie is not defined." );
		}
	}
}
