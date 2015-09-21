<?php

namespace opensrs\domains\nameserver;

use OpenSRS\Base;
use OpenSRS\Exception;

class NameserverRegistryAdd extends Base {
	public $action = "registry_add_ns";
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
			!isset( $dataObject->attributes->fqdn ) ||
			$dataObject->attributes->fqdn == ""
		) {
			throw new Exception( "oSRS Error - fqdn is not defined." );
		}
		if(
			!isset( $dataObject->attributes->tld ) ||
			$dataObject->attributes->tld == ""
		) {
			throw new Exception( "oSRS Error - tld is not defined." );
		}
		if(
			!isset( $dataObject->attributes->all ) ||
			$dataObject->attributes->all == ""
		) {
			throw new Exception( "oSRS Error - all is not defined." );
		}
	}
}