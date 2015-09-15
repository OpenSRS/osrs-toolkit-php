<?php

namespace opensrs\domains\forwarding;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class ForwardingSet extends Base {
	public $action = "set_domain_forwarding";
	public $object = "domain";

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
		// Command required values
		if(
			( !isset($dataObject->cookie) || !$dataObject->cookie ) &&
			( !isset($dataObject->attributes->domain) || !$dataObject->attributes->domain )
		) {
			throw new Exception( "oSRS Error - cookie or domain is not defined." );
		}
		if(
			isset($dataObject->cookie) &&
			isset($dataObject->attributes->domain) &&
			$dataObject->cookie &&
			$dataObject->attributes->domain
		) {
			throw new Exception( "oSRS Error - Both cookie and domain cannot be set in one call." );
		}
		if(
			!isset( $dataObject->attributes->subdomain ) ||
			!$dataObject->attributes->subdomain
		) {
			throw new Exception( "oSRS Error - subdomain is not defined." );
		}
	}
}
