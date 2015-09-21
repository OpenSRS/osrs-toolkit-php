<?php

namespace opensrs\domains\authentication;

use OpenSRS\Base;
use OpenSRS\Exception;

class AuthenticationSendAuthCode extends Base {
	public $action = "send_authcode";
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
		if( !isset($dataObject->attributes->domain_name ) ) {
			throw new Exception( "oSRS Error - domain_name is not defined." );
		}
	}
}