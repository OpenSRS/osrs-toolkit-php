<?php

namespace opensrs\domains\subreseller;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class SubresellerCreate extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct( $formatString, $dataObject ) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject() {
		$reqPers = array( "first_name", "last_name", "org_name", "address1", "city", "state", "country", "postal_code", "phone", "email", "lang_pref" );
		for( $i = 0; $i < count($reqPers); $i++ ) {
			if( 
				!isset($this->_dataObject->personal->{$reqPers[$i]}) ||
				$this->_dataObject->personal->{$reqPers[$i]} == ""
			) {
				throw new Exception( "oSRS Error - ". $reqPers[$i] ." is not defined." );
			}
		}

		$reqData = array( "ccp_enabled", "low_balance_email", "password", "pricing_plan", "status", "system_status_email", "username" );
		for( $i = 0; $i < count($reqData); $i++ ) {
			if(
				!isset($this->_dataObject->data->{$reqData[$i]}) ||
				$this->_dataObject->data->{$reqData[$i]} == ""
			) {
				throw new Exception( "oSRS Error - ". $reqData[$i] ." is not defined." );
			}
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'CREATE',
			'object' => 'SUBRESELLER',
			'attributes' => array(
				'ccp_enabled' => $this->_dataObject->data->ccp_enabled,
				'contact_set' => array(
					'owner' => $this->_createUserData( 'personal' ),
					'admin' => $this->_createUserData( 'admin' ),
					'billing' => $this->_createUserData( 'billing' ),
					'tech' => $this->_createUserData( 'tech' )
				),
				'low_balance_email' => $this->_dataObject->data->low_balance_email,
				'password' => $this->_dataObject->data->password,
				'pricing_plan' => $this->_dataObject->data->pricing_plan,
				'status' => $this->_dataObject->data->status,
				'system_status_email' => $this->_dataObject->data->system_status_email,
				'username' => $this->_dataObject->data->username
			)
		);

		// Command optional values
		if(
			isset( $this->_dataObject->data->payment_email ) &&
			$this->_dataObject->data->payment_email != ""
		) {
			$cmd['attributes']['payment_email'] = $this->_dataObject->data->payment_email;
		}
		if(
			isset( $this->_dataObject->data->url ) &&
			$this->_dataObject->data->url != ""
		) {
			$cmd['attributes']['url'] = $this->_dataObject->data->url;
		}
		if(
			isset( $this->_dataObject->data->nameservers ) &&
			$this->_dataObject->data->nameservers != ""
		) {
			// 'fqdn1' => 'parking1.mdnsservice.com'
			$tmpArray = explode( ",", $this->_dataObject->data->nameservers );
			for( $i=0; $i<count($tmpArray); $i++ ) {
				$cmd['attributes']['nameservers']['fqdn'. ( $i+1 )] = $tmpArray[$i];
			}
		}

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode( $cmd );
		// Send XML
		$XMLresult = $this->send_cmd( $xmlCMD );
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode( $XMLresult );

		// Results
		$this->resultFullRaw = $arrayResult;
        if( isset($arrayResult['attributes'] )) {
            $this->resultRaw = $arrayResult['attributes'];
        } else {
			$this->resultRaw = $arrayResult;
		}
		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}

    private function _createUserData( $contact_type = 'personal' ) {
    	if( !isset( $this->_dataObject->$contact_type ) ) {
    		$contact_type = 'personal';
    		// throw new Exception( "Contact type '$contact_type' is not set");
    	}
		$userArray = array(
			"first_name" => $this->_dataObject->$contact_type->first_name,
			"last_name" => $this->_dataObject->$contact_type->last_name,
			"org_name" => $this->_dataObject->$contact_type->org_name,
			"address1" => $this->_dataObject->$contact_type->address1,
			"address2" => $this->_dataObject->$contact_type->address2,
			"address3" => $this->_dataObject->$contact_type->address3,
			"city" => $this->_dataObject->$contact_type->city,
			"state" => $this->_dataObject->$contact_type->state,
			"postal_code" => $this->_dataObject->$contact_type->postal_code,
			"country" => $this->_dataObject->$contact_type->country,
			"phone" => $this->_dataObject->$contact_type->phone,
			"fax" => $this->_dataObject->$contact_type->fax,
			"email" => $this->_dataObject->$contact_type->email,
			"url" => $this->_dataObject->$contact_type->url,
			"lang_pref" => $this->_dataObject->$contact_type->lang_pref
		);
		return $userArray;
	}
}