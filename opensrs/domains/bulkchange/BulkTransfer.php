<?php

namespace opensrs\domains\bulkchange;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class BulkTransfer extends Base {
    public $action = "bulk_transfer";
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
			!isset( $dataObject->attributes->custom_tech_contact ) ||
			$dataObject->attributes->custom_tech_contact == ""
		) {
			throw new Exception( "oSRS Error - custom_tech_contact is not defined." );
		}
		if(
			!isset( $dataObject->attributes->domain_list ) ||
			$dataObject->attributes->domain_list == ""
		) {
			throw new Exception( "oSRS Error - domain_list is not defined." );
		}
		if(
			!isset( $dataObject->attributes->reg_username ) ||
			$dataObject->attributes->reg_username == ""
		) {
			throw new Exception( "oSRS Error - reg_username is not defined." );
		}
		if(
			!isset( $dataObject->attributes->reg_password ) ||
			$dataObject->attributes->reg_password == ""
		) {
			throw new Exception( "oSRS Error - reg_password is not defined." );
		}
	}
}
