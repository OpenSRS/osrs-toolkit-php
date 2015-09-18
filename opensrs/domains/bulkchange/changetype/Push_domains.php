<?php

namespace opensrs\domains\bulkchange\changetype;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class Push_domains extends Base {
	protected $change_type = 'push_domains';
	protected $checkFields = array(
		'gaining_reseller_username'
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