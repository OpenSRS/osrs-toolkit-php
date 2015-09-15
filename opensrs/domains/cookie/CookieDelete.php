<?php

namespace opensrs\domains\cookie;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class CookieDelete extends Base {
	public $action = "DELETE";
	public $object = "COOKIE";

	public $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct( $formatString, $dataObject ) {
		parent::__construct();

		$this->_formatHolder = $formatString;

		$this->_validateObject( $dataObject );

		$this->send( $dataObject );
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	public function _validateObject( $dataObject ) {
		print_r($dataObject);
		if( !isset($dataObject->cookie ) ) {
			throw new Exception( "oSRS Error - cookie is not defined." );
		}

		if( !isset($dataObject->attributes->cookie ) ) {
			throw new Exception( "oSRS Error - cookie is not defined." );
		}

		if( !isset($dataObject->attributes->domain ) ) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
	}
}
