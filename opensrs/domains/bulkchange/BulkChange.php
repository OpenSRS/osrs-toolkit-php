<?php

namespace opensrs\domains\bulkchange;

use OpenSRS\Base;
use OpenSRS\Exception;

class BulkChange extends Base {
    public $action = "submit_bulk_change";
    public $object = "bulk_change";

    public $_formatHolder = "";
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

	protected $changeTypeHandle = null;

    public function __construct( $formatString, $dataObject, $returnFullResponse = true, $send = true ) {
        parent::__construct();

        $this->_formatHolder = $formatString;

        if($send){
	        $this->_validateObject( $dataObject );

	        $this->send( $dataObject, $returnFullResponse );
        }
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

		// run validation for change_type
		$this->validateChangeType( $dataObject->attributes->change_type, $dataObject );
	}

	public function getFriendlyClassName( $string ) {
		return preg_replace("/[ ]/", "", ucwords( strtolower( preg_replace( "/[^a-z0-9]+/i", " ", $string ) ) ) );
	}

	public function loadChangeTypeClass( $change_type ) {
		$changeTypeClassName = $this->getFriendlyClassName( $change_type );

		$changeTypeClass = "\\OpenSRS\\domains\\bulkchange\\changetype\\$changeTypeClassName";

		if( class_exists($changeTypeClass ) ) {
			return new $changeTypeClass();
		}
		else {
			throw new Exception( "The class $changeTypeClass does not exist or cannot be found" );
		}
	}

	public function validateChangeType( $change_type, $dataObject ) {
		$changeTypeClass = $this->loadChangeTypeClass( $change_type );

		return $changeTypeClass->validateChangeType( $dataObject );
	}
}
