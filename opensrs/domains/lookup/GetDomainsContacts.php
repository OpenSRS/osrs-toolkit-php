<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  - none -
 *
 *  Optional Data:
 *  data - owner_email, admin_email, billing_email, tech_email, del_from, del_to, exp_from, exp_to, page, limit
 */

class GetDomainsContacts extends Base {
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
		$this->_validateObject ();
	}

	public function __destruct () {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject (){
		if (!isset($this->_dataObject->data->domain_list)) {
			throw new Exception ("oSRS Error - Domain list is not defined.");
		}

		$this->_processRequest ();
	}

	// Post validation functions
	private function _processRequest (){
		$domainListArray = explode (",", $this->_dataObject->data->domain_list);

		$cmd = array(
			"protocol" => "XCP",
			"action" => "GET_DOMAINS_CONTACTS",
			"object" => "DOMAIN",
			"attributes" => array (
				'domain_list' => $domainListArray
				)
			);

		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML
		$arrayResult = $this->_opsHandler->decode($XMLresult);		// Flip XML to Array

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
}
