<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class ProvisioningModify extends Base {
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
	private function _validateObject(){
		// Command required values
		if( empty($this->_dataObject->data->cookie) && empty($this->_dataObject->data->domain ) ) {
			throw new Exception( "oSRS Error - cookie and/or domain is not defined." );
		}

		if( !isset($this->_dataObject->data->affect_domains) || $this->_dataObject->data->affect_domains == "" ) {
			throw new Exception( "oSRS Error - affect_domains is not defined." );
		}
		if( !isset($this->_dataObject->data->data) || $this->_dataObject->data->data == "" ) {
			throw new Exception( "oSRS Error - data variable that defines the modify type is not defined." );

		}else{

			switch( $this->_dataObject->data->data ){
				case "ced_info":
					if( !$this->_allCedInfoCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "rsp_whois_info":
					if( !$this->_allRspWhoisInfoCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "trademark":
					if( !$this->_allTrademarkCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "change_ips_tag":
					if( !$this->_allChangeIpsTagCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "contact_info":
					if( !$this->_allContactInfoCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "domain_auth_info":
					if( !$this->_allDomainAuthInfoCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "expire_action":
					if( !$this->_allExpireActionCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "forwarding_email":
					if( !$this->_allForwardingEmailCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "nexus_info":
					if( !$this->_allNexusInfoCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "parkpage_state":
					if( !$this->_allParkpageStateCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "status":
					if( !$this->_allStatusCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "uk_whois_opt":
					if( !$this->_allUKWhoisOptCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				case "whois_privacy_state":
					if( !$this->_allWhoisPrivacyStateCheck( )) {
						throw new Exception( "oSRS Error - Incorrect call." );
					}
					break;
				default:
					throw new Exception( "oSRS Error - Unknown change type." );
					break;
			}
		}


		// Execute the command
		$this->_processRequest();
	}

	private function _allCedInfoCheck(){
		if( !isset($this->_dataObject->data->ced_info) || $this->_dataObject->data->ced_info == "" ) {
			throw new Exception( "oSRS Error - change type is ced_info but ced_info is not defined." );
		}

		if( !isset($this->_dataObject->data->ced_info->contact_type) || $this->_dataObject->data->ced_info->contact_type == "" ) {
			throw new Exception( "oSRS Error - change type is ced_info but contact_type is not defined." );
		}
		if( !isset($this->_dataObject->data->ced_info->id_number) || $this->_dataObject->data->ced_info->id_number == "" ) {
			throw new Exception( "oSRS Error - change type is ced_info but id_number is not defined." );
		}
		if( !isset($this->_dataObject->data->ced_info->legal_entity_type) || $this->_dataObject->data->ced_info->legal_entity_type == "" ) {
			throw new Exception( "oSRS Error - change type is ced_info but legal_entity_type is not defined." );
		}
		if( !isset($this->_dataObject->data->ced_info->locality_country) || $this->_dataObject->data->ced_info->locality_country == "" ) {
			throw new Exception( "oSRS Error - change type is ced_info but locality_country is not defined." );
		}
		if( !isset($this->_dataObject->data->ced_info->locality_state_prov) || $this->_dataObject->data->ced_info->locality_state_prov == "" ) {
			throw new Exception( "oSRS Error - change type is ced_info but locality_state_prov is not defined." );
		}

		return true;
	}


	private function _allRspWhoisInfoCheck(){
		if( !isset($this->_dataObject->data->all) || $this->_dataObject->data->all == "" ) {
			throw new Exception( "oSRS Error - change type is change_rsp_whois_info but all is not defined." );
		}
		if( !isset($this->_dataObject->data->flag) || $this->_dataObject->data->flag == "" ) {
			throw new Exception( "oSRS Error - change type is rsp_whois_info but flag is not defined." );
		}

		return true;
	}

	private function _allTrademarkCheck(){
		if( !isset($this->_dataObject->data->trademark) || $this->_dataObject->data->trademark == "" ) {
			throw new Exception( "oSRS Error - change type is trademark but trademark is not defined." );
		}
		return true;
	}

	private function _allChangeIpsTagCheck(){
		if( !isset($this->_dataObject->data->domain) || $this->_dataObject->data->domain == "" ) {
			throw new Exception( "oSRS Error - change type is change_ips_tag but domain is not defined." );
		}
		if( !isset($this->_dataObject->data->gaining_registrar_tag) || $this->_dataObject->data->gaining_registrar_tag == "" ) {
			throw new Exception( "oSRS Error - change type is change_ips_tag but gaining_registrar_tag is not defined." );
		}

		return true;
	}

	private function _allContactInfoCheck(){
		if( !isset($this->_dataObject->personal) || $this->_dataObject->personal == "" ) {
			throw new Exception( "oSRS Error - change type is contact_info but personal is not defined." );
		}
		if( !isset($this->_dataObject->data->contact_type) || $this->_dataObject->data->contact_type == "" ) {
			throw new Exception( "oSRS Error - change type is contact_info but contact_type is not defined." );
		}

		// Personal information
		$reqPers = array( "first_name", "last_name", "org_name", "address1", "city", "country", "postal_code", "phone", "email", "lang_pref" );
		for( $i = 0; $i < count($reqPers); $i++ ){
			if( $this->_dataObject->personal->$reqPers[$i] == "" ) {
				throw new Exception( "oSRS Error - change type is contact_info but  ". $reqPers[$i] ." is not defined in personal." );
			}
		}

		return true;
	}

	private function _allDomainAuthInfoCheck(){
		if( !isset($this->_dataObject->data->domain_auth_info) || $this->_dataObject->data->domain_auth_info == "" ) {
			throw new Exception( "oSRS Error - data type is domain_auth_info but a domain_auth_info value is not defined." );
		}

		return true;
	}

	private function _allExpireActionCheck(){
		if( !isset($this->_dataObject->data->auto_renew) || $this->_dataObject->data->auto_renew == "" ) {
			throw new Exception( "oSRS Error - data type is expire_action but auto_renew is not defined." );
		}
		if( !isset($this->_dataObject->data->let_expire) || $this->_dataObject->data->let_expire == "" ) {
			throw new Exception( "oSRS Error - data type is expire_action but let_expire is not defined." );
		}

		return true;
	}

	private function _allForwardingEmailCheck(){
		if( !isset($this->_dataObject->data->forwarding_email) || $this->_dataObject->data->forwarding_email == "" ) {
			throw new Exception( "oSRS Error - data type is forwarding_email but a forwarding_email is not defined." );
		}

		return true;
	}

	private function _allNexusInfoCheck(){
		if( !isset($this->_dataObject->data->nexus) || $this->_dataObject->data->nexus == "" ) {
			throw new Exception( "oSRS Error - data type is nexus_info but nexus is not defined." );
		}
		if( !isset($this->_dataObject->data->nexus->app_purpose) || $this->_dataObject->data->nexus->app_purpose == "" ) {
			throw new Exception( "oSRS Error - data type is nexus_info but app_purpose is not defined." );
		}
		if( !isset($this->_dataObject->data->nexus->category) || $this->_dataObject->data->nexus->category == "" ) {
			throw new Exception( "oSRS Error - data type is nexus_info but category is not defined." );
		}

		return true;
	}

	private function _allParkpageStateCheck(){
		if( !isset($this->_dataObject->data->domain) || $this->_dataObject->data->domain == "" ) {
			throw new Exception( "oSRS Error - data type is parkpage_state but domain is not defined." );
		}
		if( !isset($this->_dataObject->data->state) || $this->_dataObject->data->state == "" ) {
			throw new Exception( "oSRS Error - data type is parkpage_state but state is not defined." );
		}

		return true;
	}


	private function _allUKWhoisOptCheck(){
		if( !isset($this->_dataObject->data->reg_type) || $this->_dataObject->data->reg_type == "" ) {
			throw new Exception( "oSRS Error - change type is uk_whois_opt but reg_type is not defined." );
		}
		if( !isset($this->_dataObject->data->uk_whois_opt) || $this->_dataObject->data->uk_whois_opt == "" ) {
			throw new Exception( "oSRS Error - change type is uk_whois_opt but uk_whois_opt is not defined." );
		}

		return true;
	}

	private function _allStatusCheck(){
		if( !isset($this->_dataObject->data->lock_state) || $this->_dataObject->data->lock_state == "" ) {
			throw new Exception( "oSRS Error - data type is status but lock_state is not defined." );
		}
		if( !isset($this->_dataObject->data->domain_name) || $this->_dataObject->data->domain_name == "" ) {
			throw new Exception( "oSRS Error - data type is status but domain_name is not defined." );
		}

		return true;
	}

	private function _allWhoisPrivacyStateCheck(){
		if( !isset($this->_dataObject->data->state) || $this->_dataObject->data->state == "" ) {
			throw new Exception( "oSRS Error - change type is whois_privacy_state but state is not defined." );
		}

		return true;
	}

	// Post validation functions
	private function _processRequest(){
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'modify',
			'object' => 'DOMAIN',
			/* Commented by BC : RA : 24-6-2014 : To set same XML call as lookupGetDomain */
            /* 'cookie' => $this->_dataObject->data->cookie, */
            /* End : To set same XML call as lookupGetDomain */
			'attributes' => array(
				'affect_domains' => $this->_dataObject->data->affect_domains,
				'data' => $this->_dataObject->data->data
			)
		);

		if( isset($this->_dataObject->data->cookie) && $this->_dataObject->data->cookie != "" ) $cmd['cookie'] = $this->_dataObject->data->cookie;
		if( isset($this->_dataObject->data->domain) && $this->_dataObject->data->domain != "" ) $cmd['attributes']['domain']  = $this->_dataObject->data->domain;

		// Command optional values

		switch( $this->_dataObject->data->data ){
			case "ced_info":
				// ced_info data
				if(
					isset($this->_dataObject->data->ced_info->contact_type) &&
					$this->_dataObject->data->ced_info->contact_type != ""
				) {
					$cmd['attributes']['ced_info']['contact_type'] = $this->_dataObject->data->ced_info->contact_type;
				}
				if(
					isset($this->_dataObject->data->ced_info->id_number) &&
					$this->_dataObject->data->ced_info->id_number != ""
				) {
					$cmd['attributes']['ced_info']['id_number'] = $this->_dataObject->data->ced_info->id_number;
				}
				if(
					isset($this->_dataObject->data->ced_info->id_type) &&
					$this->_dataObject->data->ced_info->id_type != ""
				) {
					$cmd['attributes']['ced_info']['id_type'] = $this->_dataObject->data->ced_info->id_type;
				}
				if(
					isset($this->_dataObject->data->ced_info->id_type_info) &&
					$this->_dataObject->data->ced_info->id_type_info != ""
				) {
					$cmd['attributes']['ced_info']['id_type_info'] = $this->_dataObject->data->ced_info->id_type_info;
				}
				if(
					isset($this->_dataObject->data->ced_info->legal_entity_type) &&
					$this->_dataObject->data->ced_info->legal_entity_type != ""
				) {
					$cmd['attributes']['ced_info']['legal_entity_type'] = $this->_dataObject->data->ced_info->legal_entity_type;
				}
				if(
					isset($this->_dataObject->data->ced_info->legal_entity_type_info) &&
					$this->_dataObject->data->ced_info->legal_entity_type_info != ""
				) {
					$cmd['attributes']['ced_info']['legal_entity_type_info'] = $this->_dataObject->data->ced_info->legal_entity_type_info;
				}
				if(
					isset($this->_dataObject->data->ced_info->locality_city) &&
					$this->_dataObject->data->ced_info->locality_city != ""
				) {
					$cmd['attributes']['ced_info']['locality_city'] = $this->_dataObject->data->ced_info->locality_city;
				}
				if(
					isset($this->_dataObject->data->ced_info->locality_country) &&
					$this->_dataObject->data->ced_info->locality_country != ""
				) {
					$cmd['attributes']['ced_info']['locality_country'] = $this->_dataObject->data->ced_info->locality_country;
				}
				if(
					isset($this->_dataObject->data->ced_info->locality_state_prov) &&
					$this->_dataObject->data->ced_info->locality_state_prov != ""
				) {
					$cmd['attributes']['ced_info']['localicty_state_prov'] = $this->_dataObject->data->ced_info->locality_state_prov;
				}

				break;
			case "rsp_whois_info":
				//rsp_whois_info data
				if(
					isset($this->_dataObject->data->all) &&
					$this->_dataObject->data->all != ""
				) {
					$cmd['attributes']['all'] = $this->_dataObject->data->all;
				}
				if(
					isset($this->_dataObject->data->flag) &&
					$this->_dataObject->data->flag != ""
				) {
					$cmd['attributes']['flag'] = $this->_dataObject->data->flag;
				}
				break;
			case "trademark":
				//trademark data
				if(
					isset($this->_dataObject->data->trademark) &&
					$this->_dataObject->data->trademark != ""
				) {
					$cmd['attributes']['trademark'] = $this->_dataObject->data->trademark;
				}
				break;
			case "change_ips_tag":
				//change_ips_tag data

				if(
					isset($this->_dataObject->data->change_tag_all) &&
					$this->_dataObject->data->change_tag_all != ""
				) {
					$cmd['attributes']['change_tag_all'] = $this->_dataObject->data->change_tag_all;
				}
				if(
					isset($this->_dataObject->data->gaining_registrar_tag) &&
					$this->_dataObject->data->gaining_registrar_tag != ""
				) {
					$cmd['attributes']['gaining_registrar_tag'] = $this->_dataObject->data->gaining_registrar_tag;
				}
				if(
					isset($this->_dataObject->data->rsp_override) &&
					$this->_dataObject->data->rsp_override != ""
				) {
					$cmd['attributes']['rsp_override'] = $this->_dataObject->data->rsp_override;
				}
				break;
			case "contact_info":
				//contact_info data
				if(
					isset($this->_dataObject->data->report_email) &&
					$this->_dataObject->data->report_email != ""
				) {
					$cmd['attributes']['report_email'] = $this->_dataObject->data->report_email;
				}
				if(
					isset($this->_dataObject->data->contact_type) &&
					$this->_dataObject->data->contact_type != ""
				) {
					$contact_types=explode( ",",$this->_dataObject->data->contact_type );

					foreach( $contact_types as $contact_type ) {
						$cmd['attributes']['contact_set'][$contact_type] = $this->_createUserData();
					}
				}
				break;
			case "domain_auth_info":
				//domain_auth_info data
				if(
					isset($this->_dataObject->data->domain_auth_info) &&
					$this->_dataObject->data->domain_auth_info != ""
				) {
					$cmd['attributes']['domain_auth_info'] = $this->_dataObject->data->domain_auth_info;
				}
				break;
			case "expire_action":
				//expire_action data
				if(
					isset($this->_dataObject->data->auto_renew) &&
					$this->_dataObject->data->auto_renew != ""
				) {
					$cmd['attributes']['auto_renew'] = $this->_dataObject->data->auto_renew;
				}
				if(
					isset($this->_dataObject->data->let_expire) &&
					$this->_dataObject->data->let_expire != ""
				) {
					$cmd['attributes']['let_expire'] = $this->_dataObject->data->let_expire;
				}
				break;
			case "forwarding_email":
				if(
					isset($this->_dataObject->data->forwarding_email) &&
					$this->_dataObject->data->forwarding_email != ""
				) {
					$cmd['attributes']['forwarding_email'] = $this->_dataObject->data->forwarding_email;
				}
				break;
			case "nexus_info":
				//nexus_info data
				if(
					isset($this->_dataObject->data->nexus->app_purpose) &&
					$this->_dataObject->data->nexus->app_purpose != ""
				) {
					$cmd['attributes']['nexus']['app_purpose'] = $this->_dataObject->data->nexus->app_purpose;
				}
				if(
					isset($this->_dataObject->data->nexus->category) &&
					$this->_dataObject->data->nexus->category != ""
				) {
					$cmd['attributes']['nexus']['category'] = $this->_dataObject->data->nexus->category;
				}
				if(
					isset($this->_dataObject->data->nexus->validator) &&
					$this->_dataObject->data->nexus->validator != ""
				) {
					$cmd['attributes']['nexus']['validator'] = $this->_dataObject->data->nexus->validator;
				}
				break;
			case "parkpage_state":
				//parkpage_state
				if(
					isset($this->_dataObject->data->state) &&
					$this->_dataObject->data->state != ""
				) {
					$cmd['attributes']['state'] = $this->_dataObject->data->state;
				}
				break;
			case "status":
				//status data
				if(
					isset($this->_dataObject->data->lock_state) &&
					$this->_dataObject->data->lock_state != ""
				) {
					$cmd['attributes']['lock_state'] = $this->_dataObject->data->lock_state;
				}
				if(
					isset($this->_dataObject->data->domain_name) &&
					$this->_dataObject->data->domain_name != ""
				) {
					$cmd['attributes']['domain_name'] = $this->_dataObject->data->domain_name;
				}
				break;
			case "uk_whois_opt":
				//uk_whois_opt
				if(
					isset($this->_dataObject->data->reg_type) &&
					$this->_dataObject->data->reg_type != ""
				) {
					$cmd['attributes']['reg_type'] = $this->_dataObject->data->reg_type;
				}
				if(
					isset($this->_dataObject->data->uk_affect_domains) &&
					$this->_dataObject->data->uk_affect_domains != ""
				) {
					$cmd['attributes']['uk_affect_domains'] = $this->_dataObject->data->uk_affect_domains;
				}
				if(
					isset($this->_dataObject->data->uk_whois_opt) &&
					$this->_dataObject->data->uk_whois_opt != ""
				) {
					$cmd['attributes']['uk_whois_opt'] = $this->_dataObject->data->uk_whois_opt;
				}
				break;
			case "whois_privacy_state":
				//whois_privacy_state
				if(
					isset($this->_dataObject->data->state) &&
					$this->_dataObject->data->state != ""
				) {
					$cmd['attributes']['state'] = $this->_dataObject->data->state;
				}
				break;
			default:
				break;
		}

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode( $cmd );
		// Send XML
		$XMLresult = $this->send_cmd( $xmlCMD );
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode( $XMLresult );

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );



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
