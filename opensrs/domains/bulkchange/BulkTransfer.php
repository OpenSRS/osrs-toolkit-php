<?php

namespace opensrs\domains\bulkchange;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - 
 */

class BulkTransfer extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct($formatString, $dataObject) {
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
		if(
			!isset($this->_dataObject->data->custom_tech_contact) || 
			$this->_dataObject->data->custom_tech_contact == ""
		) {
			throw new Exception("oSRS Error - custom_tech_contact is not defined.");
		}
		if(
			!isset($this->_dataObject->data->domain_list) || 
			$this->_dataObject->data->domain_list == ""
		) {
			throw new Exception("oSRS Error - domain_list is not defined.");
		}
		if(
			!isset($this->_dataObject->data->reg_username) || 
			$this->_dataObject->data->reg_username == ""
		) {
			throw new Exception("oSRS Error - reg_username is not defined.");
		}
		if(
			!isset($this->_dataObject->data->reg_password) || 
			$this->_dataObject->data->reg_password == ""
		) {
			throw new Exception("oSRS Error - reg_password is not defined.");
		}

		$this->_allTimeRequired();

		$this->_processRequest();
	}

	private function _allTimeRequired(){
		$reqPers = array("first_name", "last_name", "org_name", "address1", "city", "state", "country", "postal_code", "phone", "email", "lang_pref");

		foreach($reqPers as $reqPer){
			if($this->_dataObject->personal->$reqPer == "") {
				throw new Exception("oSRS Error - ". $reqPer ." is not defined.");
			}
		}

		return true;
	}

	// Post validation functions
	private function _processRequest(){
		$domain_list = explode(",", $this->_dataObject->data->domain_list);

		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'bulk_transfer',
			'object' => 'domain',
			'attributes' => array(
				'contact_set' => array(
					'owner' => $this->_createUserData(),
					'admin' => $this->_createUserData(),
					'billing' => $this->_createUserData(),
					'tech' => $this->_createUserData()
					),
				'reg_username' => $this->_dataObject->data->reg_username,
				'reg_domain' => $this->_dataObject->data->reg_domain,
				'reg_password' => $this->_dataObject->data->reg_password,
				'custom_tech_contact' => $this->_dataObject->data->custom_tech_contact,
				'domain_list' => $domain_list
				)
			);
		
		// Command optional values

		if(
			isset($this->_dataObject->data->reg_domain) ||
			$this->_dataObject->data->reg_domain != ""
		) {
			$cmd['attributes']['reg_domain'] = $this->_dataObject->data->reg_domain;
		}
		
		if(
			isset($this->_dataObject->data->affiliate_id) &&
			$this->_dataObject->data->affiliate_id != ""
		) {
			$cmd['attributes']['affiliate_id'] = $this->_dataObject->data->affiliate_id;
		}
		if(
			isset($this->_dataObject->data->handle) &&
			$this->_dataObject->data->handle != ""
		) {
			$cmd['attributes']['handle'] = $this->_dataObject->data->handle;
		}
		if(
			isset($this->_dataObject->data->registrant_ip) &&
			$this->_dataObject->data->registrant_ip != ""
		) {
			$cmd['attributes']['registrant_ip'] = $this->_dataObject->data->registrant_ip;
		}
		
		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode($cmd);
		// Send XML
		$XMLresult = $this->send_cmd($xmlCMD);
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode($XMLresult);		

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
