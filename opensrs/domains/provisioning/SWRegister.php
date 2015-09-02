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

	public function __construct ($formatString, $dataObject) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validate ();
	}

	public function __destruct () {
		parent::__destruct();
	}

	private function _validate () {
		// Command required values
		if (isset($this->_dataObject->data->domain) && $this->_dataObject->data->domain != "") {
			// find the TLD
			$this->_dataObject->data->domain = str_replace("www.", "", $this->_dataObject->data->domain);
			$tldarr = explode(".", strtolower($this->_dataObject->data->domain));
			$tld = end($tldarr);

			// Data validation with all the additional options
			$this->_allTimeRequired();

			if( !$this->meetsSpecialRequirementsForTld( $tld ) ){
				throw new Exception( $tld . " needs special requirements." );
			}

			// Call the process function
			$this->_processRequest ($tld);
		} else {
			throw new Exception( "oSRS Error - Domain is not defined." );
			die();
		}
	}

	protected function meetsSpecialRequirementsForTld( $tld ){
		$meetsRequirements = true;

		$specialRequirementsClass = '\OpenSRS\domains\provisioning\specialrequirements\\' . strtoupper($tld);

		if(class_exists($specialRequirementsClass)){
			$specialRequirements = new $specialRequirementsClass();

			$meetsRequirements = $specialRequirements->meetsSpecialRequirements( $this->_dataObject );
		}

		return $meetsRequirements;
	}

	// Personal Information
	private function _allTimeRequired(){
		$reqPers = array("first_name", "last_name", "org_name", "address1", "city", "state", "country", "postal_code", "phone", "email", "lang_pref");
		foreach ($reqPers as $reqPer) {
			if ($this->_dataObject->personal->$reqPer == "") {
				throw new Exception( "oSRS Error - ". $reqPer ." is not defined." );
			}
		}

		$reqDatas = array("reg_type", "reg_username", "reg_password", "domain", "custom_nameservers", "period", "custom_tech_contact", "custom_nameservers");
		foreach ($reqDatas as $reqData) {
			if ($this->_dataObject->data->$reqData == "") {
				throw new Exception( "oSRS Error - ". $reqData ." is not defined." );
			}
		}
	}


	// ccTLD specific validation
	private function _ccTLD_ca () {
		$subtest = true;
		$reqData = array("isa_trademark", "lang_pref", "legal_type");
		for ($i = 0; $i < count($reqData); $i++){
			if ($this->_dataObject->data->$reqData[$i] == "") {
				throw new Exception( "oSRS Error - ". $reqData[$i] ." is not defined." );
				$subtest = false;
			}
		}
		return $subtest;
	}

	// ccTLD specific validation
	private function _ccTLD_au () {
		$subtest = true;
		$reqDatas = array("registrant_name",  "eligibility_type");

		$tld = explode(".", strtolower($this->_dataObject->data->domain), 2);

		if ($tld == "au")
			$reqDatas = array_merge($reqDatas, array("registrant_id", "registrant_id_type"));

		foreach($reqDatas as $reqData) {
			if ($this->_dataObject->au_registrant_info->$reqData == "") {
				throw new Exception( "oSRS Error - ". $reqData ." is not defined." );
				$subtest = false;
			}
		}
		return $subtest;
	}

	private function _ccTLD_br () {
		$subtest = true;
		if ($this->_dataObject->br_registrant_info->br_register_number == "") {
			throw new Exception( "oSRS Error - Registrer number not defined" );
			$subtest = false;
		}
		return $subtest;
	}

	private function _ccTLD_pro () {
		$subtest = true;
		if ($this->_dataObject->professional_data->profession == "") {
			throw new Exception( "oSRS Error - Profession not defined" );
			$subtest = false;
		}
		return $subtest;
	}

	private function _ccTLD_it () {
		$subtest = true;
		$reqDatas = array("reg_code", "entity_type");
		foreach ($reqDatas as $reqData) {
			if ($this->_dataObject->it_registrant_info->$reqData == "") {
				throw new Exception( "oSRS Error - ". $reqData ." is not defined." );
				$subtest = false;
			}
		}
		return $subtest;
	}

	private function _ccTLD_asia () {
		$subtest = true;
		$reqDatas = array("contact_type", "id_number", "id_type", "legal_entity_type", "locality_country");
		foreach($reqDatas as $reqData) {
			if ($this->_dataObject->cedinfo->$reqData == "") {
				throw new Exception( "oSRS Error - ". $reqData ." is not defined." );
				$subtest = false;
			}
		}
		return $subtest;
	}

	private function _ccTLD_be () {
		$subtest = true;
		$reqData = array("lang", "owner_confirm_address");
		for ($i = 0; $i < count($reqData); $i++){
			if ($this->_dataObject->data->$reqData[$i] == "") {
				throw new Exception( "oSRS Error - ". $reqData[$i] ." is not defined." );
				$subtest = false;
			}
		}
		return $subtest;
	}

	private function _ccTLD_de () {
		$subtest = true;
		$reqData = array("owner_confirm_address");
		for ($i = 0; $i < count($reqData); $i++){
			if ($this->_dataObject->data->$reqData[$i] == "") {
				throw new Exception( "oSRS Error - ". $reqData[$i] ." is not defined." );
				$subtest = false;
			}
		}
		return $subtest;
	}

	private function _ccTLD_eu () {
		$subtest = true;
		$reqDatas = array("eu_country", "lang", "owner_confirm_address");
		foreach($reqDatas as $reqData) {
			if ($this->_dataObject->data->$reqData == "") {
				throw new Exception( "oSRS Error - ". $reqData ." is not defined." );
				$subtest = false;
			}
		}
		return $subtest;
	}

	private function _ccTLD_us () {
		$subtest = true;
		$reqDatas = array("app_purpose", "category");
		foreach($reqDatas as $reqData) {
			if ($this->_dataObject->nexus->$reqData == "") {
				throw new Exception( "oSRS Error - ". $reqData ." is not defined." );
				$subtest = false;
			}
		}
		return $subtest;
	}

	private function _ccTLD_name () {
		$subtest = true;
		$reqData = array("forwarding_email");
		for ($i = 0; $i < count($reqData); $i++){
			if ($this->_dataObject->data->$reqData[$i] == "") {
				throw new Exception( "oSRS Error - ". $reqData[$i] ." is not defined." );
				$subtest = false;
			}
		}
		return $subtest;
	}

	// Post validation functions
	private function _processRequest ($ccTLD){
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

		foreach($reqDatas as $reqData) {
			if(isset($this->_dataObject->data->$reqData) && $this->_dataObject->data->$reqData != "")
				$cmd['attributes'][$reqData] = $this->_dataObject->data->$reqData;
		}


		// NS records
		if ($this->_dataObject->data->custom_nameservers == 1){
			$passArray = array();
			for ($j=1; $j<=10; $j++){
				$tns = "name". $j;
				$tso = "sortorder". $j;
				$temHolder = array();

				if (isset($this->_dataObject->data->$tns)){
					if ($this->_dataObject->data->$tns != ""){
						$temHolder['name'] = $this->_dataObject->data->$tns;
						$temHolder['sortorder'] = $this->_dataObject->data->$tso;
						array_push($passArray, $temHolder);
					}
				}
			}
			$cmd['attributes']['nameserver_list'] = $passArray;
		}


		// ccTLD specific
		if ($ccTLD == "ca") {
			$cmd['attributes']['isa_trademark'] = $this->_dataObject->data->isa_trademark;
			$cmd['attributes']['lang_pref'] = $this->_dataObject->data->lang_pref;
			$cmd['attributes']['legal_type'] = strtoupper($this->_dataObject->data->legal_type);

			if (isset($this->_dataObject->data->ca_link_domain) && $this->_dataObject->data->ca_link_domain != "")
				$cmd['attributes']['ca_link_domain'] = $this->_dataObject->data->ca_link_domain;

			if (isset($this->_dataObject->data->cwa) && $this->_dataObject->data->cwa != "")
				$cmd['attributes']['cwa'] = $this->_dataObject->data->cwa;

			if (isset($this->_dataObject->data->domain_description) && $this->_dataObject->data->domain_description != "")
				$cmd['attributes']['domain_description'] = $this->_dataObject->data->domain_description;

			if (isset($this->_dataObject->data->rant_agrees) && $this->_dataObject->data->rant_agrees != "")
				$cmd['attributes']['rant_agrees'] = $this->_dataObject->data->rant_agrees;

			if (isset($this->_dataObject->data->rant_no) && $this->_dataObject->data->rant_no != "")
				$cmd['attributes']['rant_no'] = $this->_dataObject->data->rant_no;
		}

		if ($ccTLD == "asia") {
			$reqDatasASIA = array("contact_type", "id_number", "id_type", "legal_entity_type", "locality_country", "id_type_info", 
				"legal_entity_type_info","locality_city", "locality_state_prov"
				);

			foreach($reqDatasASIA as $reqData) {
				if(isset($this->_dataObject->cedinfo->$reqData) && $this->_dataObject->cedinfo->$reqData != "")
					$cmd['attribugtes']['tld_data']['ced_info'][$reqData] = $this->_dataObject->cedinfo->$reqData;
			}
		}

		if ($ccTLD == "au") {
			$reqDatasAU = array("registrant_name", "eligibility_type", "registrant_id", "registrant_id_type", "eligibility_name", 
				"eligibility_id", "eligibility_id_type", "eligibility_reason"
				);

			foreach($reqDatasAU as $reqData) {
				if(isset($this->_dataObject->au_registrant_info->$reqData) && $this->_dataObject->au_registrant_info->$reqData != "")
					$cmd['attributes']['tld_data']['au_registrant_info'][$reqData] = $this->_dataObject->au_registrant_info->$reqData;
			}
		}

		if ($ccTLD == "it") {
			if (isset($this->_dataObject->it_registrant_info->nationality_code) && $this->_dataObject->it_registrant_info->nationality_code != "")
				$cmd['attributes']['tld_data']['it_registrant_info']['nationality_code'] = $this->_dataObject->it_registrant_info->nationality_code;

			$cmd['attributes']['tld_data']['it_registrant_info']['reg_code'] = $this->_dataObject->it_registrant_info->reg_code;
			$cmd['attributes']['tld_data']['it_registrant_info']['entity_type'] = $this->_dataObject->it_registrant_info->entity_type;
		}


		if ($ccTLD == "eu"){
			$cmd['attributes']['country'] = strtoupper($this->_dataObject->data->eu_country);
			$cmd['attributes']['lang'] = $this->_dataObject->data->lang;
			$cmd['attributes']['owner_confirm_address'] = $this->_dataObject->data->owner_confirm_address;
		}

		if ($ccTLD == "be"){
			$cmd['attributes']['lang'] = $this->_dataObject->data->lang;
			$cmd['attributes']['owner_confirm_address'] = $this->_dataObject->data->owner_confirm_address;
		}

		if ($ccTLD == "br"){
			$cmd['attributes']['tld_data']['br_register_number'] = $this->_dataObject->br_registrant_info->br_register_number;
		}

		if ($ccTLD == "de"){
			$cmd['attributes']['owner_confirm_address'] = $this->_dataObject->data->owner_confirm_address;
		}

		if ($ccTLD == "name") {
			$cmd['attributes']['tld_data']['forwarding_email'] = $this->_dataObject->data->forwarding_email;
		}

		if ($ccTLD == "us") {
			$cmd['attributes']['tld_data']['nexus']['app_purpose'] = $this->_dataObject->nexus->app_purpose;
			$cmd['attributes']['tld_data']['nexus']['category'] = $this->_dataObject->nexus->category;
			if (isset($this->_dataObject->nexus->validator) && $this->_dataObject->nexus->validator != "") $cmd['attributes']['tld_data']['nexus']['validator'] = $this->_dataObject->nexus->validator;
		}

		if ($ccTLD == "pro") {
			$reqDatasPRO = array("authority", "authority_website", "license_number", "profession");
			foreach($reqDatasPRO as $reqData) {
				if(isset($this->_dataObject->professional_data->$reqData) && $this->_dataObject->professional_data->$reqData != "")
					$cmd['attributes']['tld_data']['professional_data'][$reqData] = $this->_dataObject->professional_data->$reqData;
			}
		}


		// Process the call
		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML
		$arrayResult = $this->_opsHandler->decode($XMLresult);		// Flip XML to Array

		/* Added by BC : NG : 16-7-2014 : To set error message for Insufficient Funds */
		if(isset($arrayResult['attributes']['forced_pending']) and $arrayResult['attributes']['forced_pending'] != "" and $arrayResult['is_success'] == 1)
		{
			$arrayResult['is_success'] = 0;
            if($arrayResult['response_text'] == 'Registration successful')    // Get Resonse Text 'Registration successful'  when insufficient fund
            $arrayResult['response_text'] = "Insufficient Funds";
        }
        /* End : To set error message for Insufficient Funds */

		// Results
        $this->resultFullRaw = $arrayResult;
        if (isset($arrayResult['attributes'])){
        	$this->resultRaw = $arrayResult['attributes'];
        } else {
        	$this->resultRaw = $arrayResult;
        }
        $this->resultFullFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
        $this->resultFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
    }

    private function _createUserData( $contact_type = 'personal' ){
    	if(!isset($this->_dataObject->$contact_type)){
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
