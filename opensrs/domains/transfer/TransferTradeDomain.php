<?php

namespace opensrs\domains\transfer;

use OpenSRS\Base;
use OpenSRS\Exception;

class TransferTradeDomain extends Base {
	public $action = "trade_domain";
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
	public function _validateObject( $dataObject ) {
		// Command required values
		if(
			!isset( $dataObject->attributes->first_name ) ||
			$dataObject->attributes->first_name == ""
		) {
			throw new Exception( "oSRS Error - first_name is not defined." );
		}
		if(
			!isset( $dataObject->attributes->last_name ) ||
			$dataObject->attributes->last_name == ""
		) {
			throw new Exception( "oSRS Error - last_name is not defined." );
		}
		if(
			!isset( $dataObject->attributes->domain ) ||
			$dataObject->attributes->domain == ""
		) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
		if(
			!isset( $dataObject->attributes->email ) ||
			$dataObject->attributes->email == ""
		) {
			throw new Exception( "oSRS Error - email is not defined." );
		}
		if(
			!isset( $dataObject->attributes->org_name ) ||
			$dataObject->attributes->org_name == ""
		) {
			throw new Exception( "oSRS Error - org_name is not defined." );
		}
	}
}