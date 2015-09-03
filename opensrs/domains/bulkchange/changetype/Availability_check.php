<?php

namespace opensrs\domains\bulkchange\changetype;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data - 
 */

class Availability_check extends Base {
	protected $change_type = 'availability_check';

	public function __construct(){
		parent::__construct();
	}

	public function __deconstruct(){
		parent::__deconstruct();
	}

	public function validateChangeType( $dataObject ){
		// availability_check has no special validation
		// to do
		return true;
	}
}