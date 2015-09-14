<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class SWRegister extends Base {
	public $action = "SW_REGISTER";
	public $object = "DOMAIN";

	public $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;
	protected $specialRequirements = null;

	public function __construct( $formatString, $dataObject ) {
		parent::__construct();

		$this->_formatHolder = $formatString;

		if(!isset($dataObject->attributes)){
			$bc = new \OpenSRS\backwardcompatibility\dataconversion\domains\provisioning\SWRegister;

			$dataObject = $bc->convertDataObject( $dataObject );
		}

		$this->send( $dataObject );
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
}
