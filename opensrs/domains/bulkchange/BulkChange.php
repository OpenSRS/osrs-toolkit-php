<?php

namespace opensrs\domains\bulkchange;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - 
 */
 
class BulkChange extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	protected $changeTypeHandle = null;

	public function __construct ($formatString, $dataObject) {
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
		if (!isset($this->_dataObject->data->change_items) || $this->_dataObject->data->change_items == "") {
			throw new Exception("oSRS Error - change_items is not defined.");
		}



		// if (!isset($this->_dataObject->data->change_type) || $this->_dataObject->data->change_type == "") {
		// 	throw new Exception("oSRS Error - change_type is not defined.");
		// }else{

		// 	switch($this->_dataObject->data->change_type){
		// 		case "availability_check":
		// 			break;
		// 		case "domain_renew":
		// 			if(!$this->_allDomainRenewCheck())
		// 			break;
		// 		case "push_domains":
		// 			if(!$this->_allPushDomainsCheck())
		// 			break;
		// 		case "dns_zone":
		// 			if(!$this->_allDnsZoneCheck())
		// 			break;
		// 		case "dns_zone_record":
		// 			if(!$this->_allDnsZoneRecordCheck())
		// 			break;
		// 		case "domain_contacts":
		// 			if(!$this->_allDomainContactsCheck())
		// 			break;
		// 		case "domain_forwarding":
		// 			if(!$this->_allDomainForwardingCheck())
		// 			break;
		// 		case "domain_lock":
		// 			if(!$this->_allDomainLockCheck())
		// 			break;
		// 		case "domain_parked_pages":
		// 			if(!$this->_allDomainParkedPagesCheck())
		// 			break;
		// 		case "domain_nameservers":
		// 			if(!$this->_allDomainNameserversCheck())
		// 			break;
		// 		case "whois_privacy":
		// 			if(!$this->_allWhoisPrivacyCheck())
		// 			break;
		// 		default:
		// 			throw new Exception("oSRS Error - Unknown change type.");
		// 			break;
		// 	}
		// }

		// Execute the command
		$this->_processRequest();
	}

	public function getFriendlyClassName( $string ){
		return ucwords(strtolower(preg_replace("/[^a-z0-9]+/i", "_", $string)));
	}

	protected function loadChangeTypeClass( $change_type ){
		$changeTypeClassName = $this->getFriendlyClassName( $change_type );

		$changeTypeClass = '\OpenSRS\domains\bulkchange\changetype\\' . $changeTypeClassName;

		if(class_exists($changeTypeClass)){
			$this->changeTypeHandle = new $changeTypeClass();
		}
		else {
			$this->changeTypeHandle = false;
		}
	}

	protected function validateChangeType( $string ){
		if(null === $this->changeTypeHandle){
			$this->loadChangeTypeClass( $string );
		}

		return $this->changeTypeHandle->validateChangeType( $this->_dataObject );
	}

	private function _allDomainRenewCheck(){
		if(!isset($this->_dataObject->data->period) && $this->_dataObject->data->period == "" && 
		!isset($this->_dataObject->data->let_expire) && $this->_dataObject->data->let_expire == "" && 
		!isset($this->_dataObject->data->auto_renew) && $this->_dataObject->data->auto_renew == "" ) {

			throw new Exception("oSRS Error - change type is domain_renew but at least one of period, let_expire or auto_renew has to be defined.");
		}

		return true;
	}

	private function _allPushDomainsCheck(){
		if (!isset($this->_dataObject->data->gaining_reseller_username) || $this->_dataObject->data->gaining_reseller_username == "") {
			throw new Exception("oSRS Error - change type is dns_zone but gaining_reseller_username is not defined.");
		}

		return true;
	}

	private function _allDnsZoneCheck(){
		if (!isset($this->_dataObject->data->apply_to_domains) || $this->_dataObject->data->apply_to_domains == "") {
			throw new Exception("oSRS Error - change type is dns_zone but apply_to_domains is not defined.");
		}
		if (!isset($this->_dataObject->data->dns_action) || $this->_dataObject->data->dns_action == "") {
			throw new Exception("oSRS Error - change type is dns_zone but dns_action is not defined.");
		}
		return true;
	}

	private function _allDnsZoneRecordCheck(){
		if (!isset($this->_dataObject->data->dns_action) || $this->_dataObject->data->dns_action == "") {
			throw new Exception("oSRS Error - change type is dns_zone_record but dns_action is not defined.");
		}
		if (!isset($this->_dataObject->data->dns_record_type) || $this->_dataObject->data->dns_record_type == "") {
			throw new Exception("oSRS Error - change type is dns_zone_record but dns_record_type is not defined.");
		}
		if (!isset($this->_dataObject->data->dns_record_data) || $this->_dataObject->data->dns_record_data == "") {
			throw new Exception("oSRS Error - change type is dns_zone_record but dns_record_data is not defined.");
		}
		return true;
	}

	private function _allDomainContactsCheck(){
		if (!isset($this->_dataObject->data->type) || $this->_dataObject->data->type == "") {
			throw new Exception("oSRS Error - change type is domain_contacts but type is not defined.");
		}
		if (!isset($this->_dataObject->personal) || $this->_dataObject->personal == "") {
			throw new Exception("oSRS Error - change type is domain_contacts but personal is not defined.");
		}
		return true;
	}

	private function _allDomainForwardingCheck(){
		if (!isset($this->_dataObject->data->op_type) || $this->_dataObject->data->op_type == "") {
			throw new Exception("oSRS Error - change type is domain_forwarding but op_type is not defined.");
		}
		return true;
	}
	
	private function _allDomainLockCheck(){
		if (!isset($this->_dataObject->data->op_type) || $this->_dataObject->data->op_type == "") {
			throw new Exception("oSRS Error - change type is domain_lock but op_type is not defined.");
		}
		return true;
	}

	private function _allDomainNameserversCheck(){
		if (!isset($this->_dataObject->data->op_type) || $this->_dataObject->data->op_type == "") {
			throw new Exception("oSRS Error - change type is domain_nameservers but op_type is not defined.");
		}
		if(!isset($this->_dataObject->data->add_ns) && $this->_dataObject->data->add_ns == "" && 
		!isset($this->_dataObject->data->remove_ns) && $this->_dataObject->data->remove_ns == "" && 
		!isset($this->_dataObject->data->assign_ns) && $this->_dataObject->data->assign_ns == "" ) {

			throw new Exception("oSRS Error - change type is domain_nameservers but at least one of add_ns, remove_ns or assign_ns has to be defined.");
		}
		return true;
	}

	private function _allDomainParkedPagesCheck(){
		if (!isset($this->_dataObject->data->op_type) || $this->_dataObject->data->op_type == "") {
			throw new Exception("oSRS Error - change type is domain_parked_pages but op_type is not defined.");
		}
		return true;
	}

	private function _allWhoisPrivacyCheck(){
		if (!isset($this->_dataObject->data->op_type) || $this->_dataObject->data->op_type == "") {
			throw new Exception("oSRS Error - change type is whois_privacy but op_type is not defined.");
		}
		return true;
	}

	// Post validation functions
	private function _processRequest (){
		$this->_dataObject->data->change_items = explode (",", $this->_dataObject->data->change_items);
	
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'submit_bulk_change',
			'object' => 'bulk_change',
			'attributes' => array (
				'change_type' => $this->_dataObject->data->change_type,
				'change_items' => $this->_dataObject->data->change_items
			)
		);
		
		// Command optional values
		if (isset($this->_dataObject->data->apply_to_locked_domains) && $this->_dataObject->data->apply_to_locked_domains != "") 
			$cmd['attributes']['apply_to_locked_domains'] = $this->_dataObject->data->apply_to_locked_domains;
		if (isset($this->_dataObject->data->contact_email) && $this->_dataObject->data->contact_email != "") 
			$cmd['attributes']['contact_email'] = $this->_dataObject->data->contact_email;
		if (isset($this->_dataObject->data->apply_to_all_reseller_items) && $this->_dataObject->data->apply_to_all_reseller_items!= "") 
			$cmd['attributes']['apply_to_all_reseller_items'] = $this->_dataObject->data->apply_to_all_reseller_items;

		switch($this->_dataObject->data->change_type){
			case "availability_check":
				break;
			case "domain_renew":
				if (isset($this->_dataObject->data->period) && $this->_dataObject->data->period!= "") 
					$cmd['attributes']['period'] = $this->_dataObject->data->period;
				if (isset($this->_dataObject->data->let_expire) && $this->_dataObject->data->let_expire!= "") 
					$cmd['attributes']['let_expire'] = $this->_dataObject->data->let_expire;
				if (isset($this->_dataObject->data->auto_renew) && $this->_dataObject->data->auto_renew!= "") 
					$cmd['attributes']['auto_renew'] = $this->_dataObject->data->auto_renew;
				if (isset($this->_dataObject->data->affiliate_id) && $this->_dataObject->data->affiliate_id!= "") 
					$cmd['attributes']['affiliate_id'] = $this->_dataObject->data->affiliate_id;
				break;
			case "push_domains":
				if (isset($this->_dataObject->data->gaining_reseller_username) && $this->_dataObject->data->gaining_reseller_username!= "") 
					$cmd['attributes']['gaining_reseller_username'] = $this->_dataObject->data->gaining_reseller_username;
				break;
			case "dns_zone":
				if (isset($this->_dataObject->data->apply_to_domains) && $this->_dataObject->data->apply_to_domains!= "") 
					$cmd['attributes']['apply_to_domains'] = $this->_dataObject->data->apply_to_domains;
				if (isset($this->_dataObject->data->dns_action) && $this->_dataObject->data->dns_action!= "") 
					$cmd['attributes']['dns_action'] = $this->_dataObject->data->dns_action;
				if (isset($this->_dataObject->data->dns_template) && $this->_dataObject->data->dns_template!= "") 
					$cmd['attributes']['dns_template'] = $this->_dataObject->data->dns_template;
				if (isset($this->_dataObject->data->only_if) && $this->_dataObject->data->only_if!= "") 
					$cmd['attributes']['only_if'] = $this->_dataObject->data->only_if;
				if (isset($this->_dataObject->data->force_dns_nameservers) && $this->_dataObject->data->force_dns_nameservers!= "") 
					$cmd['attributes']['force_dns_nameservers'] = $this->_dataObject->data->force_dns_nameservers;
				break;
			case "dns_zone_record":
				if(isset($this->_dataObject->data->dns_action) && $this->_dataObject->data->dns_action!= "") 
					$cmd['attributes']['dns_action'] = $this->_dataObject->data->dns_action;
				if(isset($this->_dataObject->data->dns_record_type) && $this->_dataObject->data->dns_record_type!= "") 
					$cmd['attributes']['dns_record_type'] = $this->_dataObject->data->dns_record_type;
				if(isset($this->_dataObject->data->dns_record_data->ip_address) && $this->_dataObject->data->dns_record_data->ip_address!= "") 
					$cmd['attributes']['dns_record_data']['ip_address'] = $this->_dataObject->data->dns_record_data->ip_address;
				if(isset($this->_dataObject->data->dns_record_data->subdomain) && $this->_dataObject->data->dns_record_data->subdomain!= "") 
					$cmd['attributes']['dns_record_data']['subdomain'] = $this->_dataObject->data->dns_record_data->subdomain;
				if(isset($this->_dataObject->data->dns_record_data->ipv6_address) && $this->_dataObject->data->dns_record_data->ipv6_address!= "") 
					$cmd['attributes']['dns_record_data']['ipv6_address'] = $this->_dataObject->data->dns_record_data->ipv6_address;
				if(isset($this->_dataObject->data->dns_record_data->hostname) && $this->_dataObject->data->dns_record_data->hostname!= "") $
					$cmd['attributes']['dns_record_data']['hostname'] = $this->_dataObject->data->dns_record_data->hostname;
				if(isset($this->_dataObject->data->dns_record_data->priority) && $this->_dataObject->data->dns_record_data->priority!= "") 
					$cmd['attributes']['dns_record_data']['priority'] = $this->_dataObject->data->dns_record_data->priority;
				if(isset($this->_dataObject->data->dns_record_data->weight) && $this->_dataObject->data->dns_record_data->weight!= "") 
					$cmd['attributes']['dns_record_data']['weight'] = $this->_dataObject->data->dns_record_data->weight;
				if(isset($this->_dataObject->data->dns_record_data->port) && $this->_dataObject->data->dns_record_data->port!= "") 
					$cmd['attributes']['dns_record_data']['port'] = $this->_dataObject->data->dns_record_data->port;
				if(isset($this->_dataObject->data->dns_record_data->text) && $this->_dataObject->data->dns_record_data->text!= "") 
					$cmd['attributes']['dns_record_data']['text'] = $this->_dataObject->data->dns_record_data->text;
				if(isset($this->_dataObject->data->only_if) && $this->_dataObject->data->only_if!= "") 
					$cmd['attributes']['only_if'] = $this->_dataObject->data->only_if;
				break;
			case "domain_contacts":
				// Allows for multiple contact changes with the same data
				if (isset($this->_dataObject->data->type) && $this->_dataObject->data->type!= "" && 
				    isset($this->_dataObject->personal) && $this->_dataObject->personal!= ""){

					$contact_types=explode (",", $this->_dataObject->data->type);

					$i=0;
					foreach($contact_types as $contact_type){
						$cmd['attributes']['contacts'][$i]['type'] = $contact_type;
						$cmd['attributes']['contacts'][$i]['set'] = $this->_createUserData();
						$i++;
					}
				}
				break;
			case "domain_forwarding":
				if (isset($this->_dataObject->data->op_type) && $this->_dataObject->data->op_type!= "") 
					$cmd['attributes']['op_type'] = $this->_dataObject->data->op_type;
				break;
			case "domain_lock":
				if (isset($this->_dataObject->data->op_type) && $this->_dataObject->data->op_type!= "") 
					$cmd['attributes']['op_type'] = $this->_dataObject->data->op_type;
				break;
			case "domain_parked_pages":
				if (isset($this->_dataObject->data->op_type) && $this->_dataObject->data->op_type!= "") 
					$cmd['attributes']['op_type'] = $this->_dataObject->data->op_type;
				break;
			case "domain_nameservers":
				if (isset($this->_dataObject->data->op_type) && $this->_dataObject->data->op_type!= "") 
					$cmd['attributes']['op_type'] = $this->_dataObject->data->op_type;
				if (isset($this->_dataObject->data->add_ns) && $this->_dataObject->data->add_ns!= "") 
					$cmd['attributes']['add_ns'] = explode(",",$this->_dataObject->data->add_ns);
				if (isset($this->_dataObject->data->remove_ns) && $this->_dataObject->data->remove_ns!= "") 
					$cmd['attributes']['remove_ns'] = explode(",",$this->_dataObject->data->remove_ns);
				if (isset($this->_dataObject->data->assign_ns) && $this->_dataObject->data->assign_ns!= "") 
					$cmd['attributes']['assign_ns'] = explode(",",$this->_dataObject->data->assign_ns);
				break;
			case "whois_privacy":
				if (isset($this->_dataObject->data->op_type) && $this->_dataObject->data->op_type!= "") 
					$cmd['attributes']['op_type'] = $this->_dataObject->data->op_type;
				break;
			default:
				break;
		}

		

		
	
		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML
		$arrayResult = $this->_opsHandler->decode($XMLresult);		// Flip XML to Array

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
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
