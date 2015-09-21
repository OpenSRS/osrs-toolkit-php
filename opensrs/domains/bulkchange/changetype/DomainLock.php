<?php

namespace opensrs\domains\bulkchange\changetype;

use OpenSRS\Base;
use OpenSRS\Exception;

class DomainLock extends Base {
	protected $change_type = 'domain_lock';
	protected $checkFields = array(
		'op_type'
		);

	public function __construct() {
		parent::__construct();
	}

	public function __deconstruct() {
		parent::__deconstruct();
	}

	public function validateChangeType( $dataObject ) {
		foreach( $this->checkFields as $field ) {
			if( !isset( $dataObject->data->$field ) || !$dataObject->data->$field ) {
				throw new Exception( "oSRS Error - change type is {$this->change_type} but $field is not defined." );
			}
		}

		return true;
	}
}
