<?php
/*
 *  Required object values:
 *  data - 
 */
 
class provSWregister extends openSRS_base {
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
		if (isSet($this->_dataObject->data->domain) && $this->_dataObject->data->domain != "") {
			// find the TLD
			$this->_dataObject->data->domain = str_replace("www.", "", $this->_dataObject->data->domain);
			$tldarr = explode(".", strtolower($this->_dataObject->data->domain));
			$tld = end($tldarr);

			// Data validation with all the additional options
			$allPassed = true;
			$allPassed = $this->_allTimeRequired ();

			// The following TLDs require additional option values
			$special_tlds = array("ca", "asia", "be", "de", "eu", "it", "name", "us", "au", "pro", "br");

			if (in_array($tld, $special_tlds)) {
				$_ccTLD = "_ccTLD_" . $tld;
        		$allPassed = $this->$_ccTLD();
 			  	trigger_error($tld . " needs special requirements.");
      		}

			// Call the process function
			if ($allPassed) {
				$this->_processRequest ($tld);
			} else {
				trigger_error ("oSRS Error - Incorrect call.", E_USER_WARNING);
			}
		} else {
			trigger_error ("oSRS Error - Domain is not defined.", E_USER_ERROR);
			die();
		}
	}
	
	// Personal Information
	private function _allTimeRequired(){
		$subtest = true;
		
		$reqPers = array("first_name", "last_name", "org_name", "address1", "city", "state", "country", "postal_code", "phone", "email", "lang_pref");
		foreach ($reqPers as $reqPer) {
		  if ($this->_dataObject->personal->$reqPer == "") {
				trigger_error ("oSRS Error - ". $reqPer ." is not defined.", E_USER_WARNING);
				$subtest = false;
			}
		}
		
		$reqDatas = array("reg_type", "reg_username", "reg_password", "domain", "custom_nameservers", "period", "custom_tech_contact", "custom_nameservers");
		foreach ($reqDatas as $reqData) {
			if ($this->_dataObject->data->$reqData == "") {
				trigger_error ("oSRS Error - ". $reqData ." is not defined.", E_USER_WARNING);
				$subtest = false;
			}
		}
		
		return $subtest;
	}
	
	
	// ccTLD specific validation
	private function _ccTLD_ca () {
		$subtest = true;
		$reqData = array("isa_trademark", "lang_pref", "legal_type");
		for ($i = 0; $i < count($reqData); $i++){
			if ($this->_dataObject->data->$reqData[$i] == "") {
				trigger_error ("oSRS Error - ". $reqData[$i] ." is not defined.", E_USER_WARNING);
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
				trigger_error ("oSRS Error - ". $reqData ." is not defined.", E_USER_WARNING);
				$subtest = false;
			}
		}
		return $subtest;
	}

	private function _ccTLD_br () {
        $subtest = true;
        if ($this->_dataObject->br_registrant_info->br_register_number == "") {
            trigger_error ("oSRS Error - Registrer number not defined", E_USER_WARNING);
            $subtest = false;
        }
        return $subtest;
    }
 	
 	private function _ccTLD_pro () {
        $subtest = true;
        if ($this->_dataObject->professional_data->profession == "") {
            trigger_error ("oSRS Error - Profession not defined", E_USER_WARNING);
            $subtest = false;
        }
        return $subtest;
    }

	private function _ccTLD_it () {
		$subtest = true;
		$reqDatas = array("reg_code", "entity_type");
		foreach ($reqDatas as $reqData) {
			if ($this->_dataObject->it_registrant_info->$reqData == "") {
				trigger_error ("oSRS Error - ". $reqData ." is not defined.", E_USER_WARNING);
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
				trigger_error ("oSRS Error - ". $reqData ." is not defined.", E_USER_WARNING);
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
				trigger_error ("oSRS Error - ". $reqData[$i] ." is not defined.", E_USER_WARNING);
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
				trigger_error ("oSRS Error - ". $reqData[$i] ." is not defined.", E_USER_WARNING);
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
				trigger_error ("oSRS Error - ". $reqData ." is not defined.", E_USER_WARNING);
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
				trigger_error ("oSRS Error - ". $reqData ." is not defined.", E_USER_WARNING);
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
				trigger_error ("oSRS Error - ". $reqData[$i] ." is not defined.", E_USER_WARNING);
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
					'owner' => $this->_createUserData(),
					'admin' => $this->_createUserData(),
					'billing' => $this->_createUserData(),
					'tech' => $this->_createUserData()
				)
			)
		);


		// Command optional values

		$reqDatas = array("affiliate_id", "auto_renew", "change_contact", "custom_transfer_nameservers", "dns_template",
			"encoding_type", "f_lock_domain", "f_parkp", "f_whois_privacy", "handle", "link_domains", "master_order_id",
			"nameserver_list", "premium_price_to_verify", "reg_domain"
			);

		foreach($reqDatas as $reqData) {
			if(isSet($this->_dataObject->data->$reqData) && $this->_dataObject->data->$reqData != "")
				$cmd['attributes'][$reqData] = $this->_dataObject->data->$reqData;
		}

	
		// NS records
		if ($this->_dataObject->data->custom_nameservers == 1){
			$passArray = array();
			for ($j=1; $j<=10; $j++){
				$tns = "name". $j;
				$tso = "sortorder". $j;
				$temHolder = array();

				if (isSet($this->_dataObject->data->$tns)){
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
			if (isSet($this->_dataObject->data->ca_link_domain) && $this->_dataObject->data->ca_link_domain != "") $cmd['attributes']['ca_link_domain'] = $this->_dataObject->data->ca_link_domain;
			if (isSet($this->_dataObject->data->cwa) && $this->_dataObject->data->cwa != "") $cmd['attributes']['cwa'] = $this->_dataObject->data->cwa;
			if (isSet($this->_dataObject->data->domain_description) && $this->_dataObject->data->domain_description != "") $cmd['attributes']['domain_description'] = $this->_dataObject->data->domain_description;
			if (isSet($this->_dataObject->data->rant_agrees) && $this->_dataObject->data->rant_agrees != "") $cmd['attributes']['rant_agrees'] = $this->_dataObject->data->rant_agrees;
			if (isSet($this->_dataObject->data->rant_no) && $this->_dataObject->data->rant_no != "") $cmd['attributes']['rant_no'] = $this->_dataObject->data->rant_no;
		}
		
		if ($ccTLD == "asia") {
			$reqDatas = array("contact_type", "id_number", "id_type", "legal_entity_type", "locality_country", "id_type_info", 
				"legal_entity_type_info","locality_city", "locality_state_prov"
			);

			foreach($reqDatasASIA as $reqData) {
				if(isSet($this->_dataObject->cedinfo->data->$reqData) && $this->_dataObject->data->$reqData != "")
					$cmd['attributes']['tld_data']['ced_info'][$reqData] = $this->_dataObject->data->$reqData;
			}
		}
		
		if ($ccTLD == "au") {
			$reqDatasAU = array("registrant_name", "eligibility_type", "registrant_id", "registrant_id_type", "eligibility_name", 
				"eligibility_id", "eligibility_id_type", "eligibility_reason"
			);

			foreach($reqDatasAU as $reqData) {
				if(isSet($this->_dataObject->au_registrant_info->$reqData) && $this->_dataObject->au_registrant_info->$reqData != "")
					$cmd['attributes']['tld_data']['au_registrant_info'][$reqData] = $this->_dataObject->au_registrant_info->$reqData;
			}
		}

		if ($ccTLD == "it") {
			if (isSet($this->_dataObject->it_registrant_info->nationality_code) && $this->_dataObject->it_registrant_info->nationality_code != "")
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
			if (isSet($this->_dataObject->nexus->validator) && $this->_dataObject->nexus->validator != "") $cmd['attributes']['tld_data']['nexus']['validator'] = $this->_dataObject->nexus->validator;
		}

		if ($ccTLD == "pro") {
			$reqDatasPRO = array("authority", "authority_website", "license_number", "profession");
			foreach($reqDatasPRO as $reqData) {
				if(isSet($this->_dataObject->professional_data->$reqData) && $this->_dataObject->professional_data->$reqData != "")
					$cmd['attributes']['tld_data']['professional_data'][$reqData] = $this->_dataObject->professional_data->$reqData;
			}
		}
		
		
		// Process the call
		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML
		$arrayResult = $this->_opsHandler->decode($XMLresult);		// Flip XML to Array

		// Results
		$this->resultFullRaw = $arrayResult;
                if (isSet($arrayResult['attributes'])){
                    $this->resultRaw = $arrayResult['attributes'];
                } else {
			$this->resultRaw = $arrayResult;
		}
		$this->resultFullFormatted = convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
	}
	
	private function _createUserData(){
		$userArray = array(
			"first_name" => $this->_dataObject->personal->first_name,
			"last_name" => $this->_dataObject->personal->last_name,
			"org_name" => $this->_dataObject->personal->org_name,
			"address1" => $this->_dataObject->personal->address1,
			"address2" => $this->_dataObject->personal->address2,
			"address3" => $this->_dataObject->personal->address3,
			"city" => $this->_dataObject->personal->city,
			"state" => $this->_dataObject->personal->state,
			"postal_code" => $this->_dataObject->personal->postal_code,
			"country" => $this->_dataObject->personal->country,
			"phone" => $this->_dataObject->personal->phone,
			"fax" => $this->_dataObject->personal->fax,
			"email" => $this->_dataObject->personal->email,
			"url" => $this->_dataObject->personal->url,
			"lang_pref" => $this->_dataObject->personal->lang_pref
		);
		return $userArray;
	}
}
