<?php

namespace opensrs\domains\subreseller;

use OpenSRS\Base;
use OpenSRS\Exception;

class SubresellerModify extends Base {
	public $action = "modify";
	public $object = "subreseller";

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
		$reqData = array(
			"ccp_enabled", "low_balance_email", "password",
			"pricing_plan", "status", "system_status_email",
			"username"
			);

		for( $i = 0; $i < count($reqData); $i++ ) {
			if(
				!isset($dataObject->attributes->{$reqData[$i]}) ||
				$dataObject->attributes->{$reqData[$i]} == ""
			) {
				throw new Exception( "oSRS Error - ". $reqData[$i] ." is not defined." );
			}
		}
	}
}