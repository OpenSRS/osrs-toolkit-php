<?php

namespace opensrs\domains\bulkchange;

use OpenSRS\Base;
use OpenSRS\Exception;

class BulkSubmit extends Base {
    public $action = "submit";
    public $object = "bulk_change";

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
			!isset( $dataObject->attributes->change_items ) ||
			$dataObject->attributes->change_items == ""
		) {
			throw new Exception( "oSRS Error - change_items is not defined." );
		}

		if(
			!isset( $dataObject->attributes->change_type ) ||
			$dataObject->attributes->change_type == ""
		) {
			throw new Exception( "oSRS Error - change_type is not defined." );
		}

		if(
			!isset( $dataObject->attributes->op_type ) ||
			$dataObject->attributes->op_type == ""
		) {
			throw new Exception( "oSRS Error - op_type is not defined." );
		}
	}
}
