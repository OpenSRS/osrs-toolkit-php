<?php

namespace opensrs\domains\provisioning\specialrequirements;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data - 
 */

class IT extends Base {
	protected $tld = 'it';
	protected $requiredFields = array(
		"reg_code",
		"entity_type"
		);

	public function __construct(){
		parent::__construct();
	}

	public function __deconstruct(){
		parent::__deconstruct();
	}

	public function meetsSpecialRequirements( $dataObject ){
		return $this->validateSpecialFields( $dataObject ) && !$this->needsSpecialRequirements( $dataObject );
	}

	public function validateSpecialFields( $dataObject ){
		// Make sure all required fields defined in
		// $this->requiredFields array are assigned
		// values
		foreach($this->requiredFields as $reqData) {
			if ($dataObject->it_registrant_info->$reqData == "") {
				throw new Exception( "oSRS Error - ". $reqData[$i] ." is not defined." );
			}
		}

		return true;
	}

	public function needsSpecialRequirements( $dataObject ){
		return false;
	}
}