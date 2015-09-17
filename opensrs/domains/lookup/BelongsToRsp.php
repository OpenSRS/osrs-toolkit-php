<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

class BelongsToRsp extends Base {
	public $action = "belongs_to_rsp";
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
	public function _validateObject( $dataObject ){
		if (!isset($dataObject->attributes->domain)) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
	}
}
