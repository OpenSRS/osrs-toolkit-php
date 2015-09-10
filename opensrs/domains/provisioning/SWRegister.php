<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class SWRegister extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;
	protected $specialRequirements = null;

	public function __construct( $formatString, $dataObject ) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validate();
	}

	public function __destruct() {
		parent::__destruct();
	}

	private function _validate() {
		// Command required values
		if( isset( $this->_dataObject->data->domain ) && $this->_dataObject->data->domain != "" ) {
			// find the TLD
			$this->_dataObject->data->domain = str_replace( "www.", "", $this->_dataObject->data->domain );
			$tldarr = explode( ".", strtolower($this->_dataObject->data->domain ) );
			$tld = end( $tldarr );

			// Data validation with all the additional options
			$this->_allTimeRequired();

			if( !$this->meetsSpecialRequirementsForTld( $tld ) ) {
				throw new Exception( $tld . " needs special requirements." );
			}

			// Call the process function
			$this->_processRequest( $tld );
		} else {
			throw new Exception( "oSRS Error - Domain is not defined." );
			die();
		}
	}

	public function getTldFriendlyName( $tld ) {
		return strtoupper( preg_replace("/[^a-z0-9]+/i", "_", $tld ) );
	}

	protected function loadSpecialRequirementsClass( $tld ) {
		$tldFriendlyName = $this->getTldFriendlyName( $tld );

		$specialRequirementsClass = '\OpenSRS\domains\provisioning\specialrequirements\\' . $tldFriendlyName;

		if( class_exists($specialRequirementsClass ) ) {
			$this->specialRequirements = new $specialRequirementsClass();
		}
		else {
			$this->specialRequirements = false;
		}
	}

	public function meetsSpecialRequirementsForTld( $tld ) {
		$meetsRequirements = true;

		if( null === $this->specialRequirements ) {
			$this->loadSpecialRequirementsClass( $tld );
		}

		if( $this->specialRequirements ) {
			$meetsRequirements = $this->specialRequirements->meetsSpecialRequirements( $this->_dataObject );
		}

		return $meetsRequirements;
	}

	public function setSpecialRequestFieldsForTld( $tld, $requestData ) {
		$returnData = null;

		if( null === $this->specialRequirements ) {
			$this->loadSpecialRequirementsClass( $tld );
		}

		if( $this->specialRequirements ) {
			$returnData = $this->specialRequirements->setSpecialRequestFieldsForTld( $this->_dataObject, $requestData );
		}

		return !is_null( $returnData ) ? $returnData : $requestData;
	}

	// Personal Information
	private function _allTimeRequired() {
		$reqPers = array( "first_name", "last_name", "org_name", "address1", "city", "state", "country", "postal_code", "phone", "email", "lang_pref" );
		foreach( $reqPers as $reqPer ) {
			if( $this->_dataObject->personal->$reqPer == "" ) {
				throw new Exception( "oSRS Error - ". $reqPer ." is not defined." );
			}
		}

		$reqDatas = array( "reg_type", "reg_username", "reg_password", "domain", "custom_nameservers", "period", "custom_tech_contact", "custom_nameservers" );
		foreach( $reqDatas as $reqData ) {
			if( $this->_dataObject->data->$reqData == "" ) {
				throw new Exception( "oSRS Error - ". $reqData ." is not defined." );
			}
		}
	}

	// Post validation functions
	private function _processRequest( $ccTLD ) {
		// Compile the command
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'SW_REGISTER',
			'object' => 'DOMAIN',
			'attributes' => array(
				'reg_type' => $this->_dataObject->data->reg_type,
				'reg_username' => $this->_dataObject->data->reg_username,
				'reg_password' => $this->_dataObject->data->reg_password,
				'domain' => $this->_dataObject->data->domain,
				'custom_nameservers' => $this->_dataObject->data->custom_nameservers,
				'period' => $this->_dataObject->data->period,
				'custom_tech_contact' => $this->_dataObject->data->custom_tech_contact,
				'custom_nameservers' => $this->_dataObject->data->custom_nameservers,
				'contact_set' => array(
					'owner' => $this->_createUserData( 'owner' ),
					'admin' => $this->_createUserData( 'admin' ),
					'billing' => $this->_createUserData( 'billing' ),
					'tech' => $this->_createUserData('tech' )
					)
				)
			);


		// Command optional values

		$reqDatas = array("affiliate_id", "auto_renew", "change_contact", "custom_transfer_nameservers", "dns_template",
			"encoding_type", "f_lock_domain", "f_parkp", "f_whois_privacy", "handle", "link_domains", "master_order_id",
			"nameserver_list", "premium_price_to_verify", "reg_domain"
			);

		foreach( $reqDatas as $reqData ) {
			if( isset( $this->_dataObject->data->$reqData ) && $this->_dataObject->data->$reqData != "" )
				$cmd['attributes'][$reqData] = $this->_dataObject->data->$reqData;
		}


		// NS records
		if( $this->_dataObject->data->custom_nameservers == 1 ) {
			$passArray = array();
			for( $j=1; $j<=10; $j++ ) {
				$tns = "name". $j;
				$tso = "sortorder". $j;
				$temHolder = array();

				if( isset($this->_dataObject->data->$tns ) ) {
					if( $this->_dataObject->data->$tns != "" ) {
						$temHolder['name'] = $this->_dataObject->data->$tns;
						$temHolder['sortorder'] = $this->_dataObject->data->$tso;
						array_push( $passArray, $temHolder );
					}
				}
			}
			$cmd['attributes']['nameserver_list'] = $passArray;
		}


		$cmd = $this->setSpecialRequestFieldsForTld( $ccTLD, $cmd );

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode( $cmd );
		// Send XML
		$XMLresult = $this->send_cmd( $xmlCMD );
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode( $XMLresult );

		/* Added by BC : NG : 16-7-2014 : To set error message for Insufficient Funds */
		if( isset( $arrayResult['attributes']['forced_pending'] ) and $arrayResult['attributes']['forced_pending'] != "" and $arrayResult['is_success'] == 1 )
		{
			$arrayResult['is_success'] = 0;
            if( $arrayResult['response_text'] == 'Registration successful' )    // Get Resonse Text 'Registration successful'  when insufficient fund
            $arrayResult['response_text'] = "Insufficient Funds";
        }
        /* End : To set error message for Insufficient Funds */

		// Results
        $this->resultFullRaw = $arrayResult;
        if( isset($arrayResult['attributes'] ) ) {
        	$this->resultRaw = $arrayResult['attributes'];
        } else {
        	$this->resultRaw = $arrayResult;
        }
        $this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
        $this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
    }

    private function _createUserData( $contact_type = 'personal' ) {
    	if( !isset($this->_dataObject->$contact_type ) ) {
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
