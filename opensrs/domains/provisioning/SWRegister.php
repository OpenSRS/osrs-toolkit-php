<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

class SWRegister extends Base {
	public $action = "sw_register";
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

	public function customResponseHandling( $arrayResult ){
		/* Added by BC : NG : 16-7-2014 : To set error message for Insufficient Funds */
		if( isset( $arrayResult['attributes']['forced_pending'] ) and $arrayResult['attributes']['forced_pending'] != "" and $arrayResult['is_success'] == 1 )
		{
			$arrayResult['is_success'] = 0;

			// Get Resonse Text 'Registration successful'  when insufficient fund
            if( $arrayResult['response_text'] == 'Registration successful' ) {
	            $arrayResult['response_text'] = "Insufficient Funds";
            }
        }

        return $arrayResult;
 	}

	// Validate the object
	public function _validateObject( $dataObject ) {
		if( !isset($dataObject->attributes->domain ) ) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
		if( !isset($dataObject->attributes->custom_nameservers ) ) {
			throw new Exception( "oSRS Error - custom_nameservers is not defined." );
		}
		if( !isset($dataObject->attributes->custom_tech_contact ) ) {
			throw new Exception( "oSRS Error - custom_tech_contact is not defined." );
		}
		if( !isset($dataObject->attributes->handle ) ) {
			throw new Exception( "oSRS Error - handle is not defined." );
		}
		if( !isset($dataObject->attributes->period ) ) {
			throw new Exception( "oSRS Error - period is not defined." );
		}
		if( !isset($dataObject->attributes->reg_username ) ) {
			throw new Exception( "oSRS Error - reg_username is not defined." );
		}
		if( !isset($dataObject->attributes->reg_password ) ) {
			throw new Exception( "oSRS Error - reg_password is not defined." );
		}
		if( !isset($dataObject->attributes->reg_type ) ) {
			throw new Exception( "oSRS Error - reg_type is not defined." );
		}
	}
}
