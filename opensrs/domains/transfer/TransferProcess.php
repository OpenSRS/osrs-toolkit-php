<?php

namespace opensrs\domains\transfer;

use OpenSRS\Base;
use OpenSRS\Exception;

class TransferProcess extends Base {
	public $action = "process_transfer";
	public $object = "transfer";

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
			!isset( $dataObject->attributes->order_id ) ||
			$dataObject->attributes->order_id == ""
		) {
			throw new Exception( "oSRS Error - order_id is not defined." );
		}
		if(
			!isset( $dataObject->attributes->reseller ) ||
			$dataObject->attributes->reseller == ""
		) {
			throw new Exception( "oSRS Error - reseller is not defined." );
		}
	}
}