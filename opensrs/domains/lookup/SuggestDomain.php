<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

class SuggestDomain extends Base {
	private $_domain = "";
	private $_tldSelect = array ();
	private $_tldAll = array ();
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;
	public $result;

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
		$domain = "";
		$arraSelected = array();
		$arraAll = array();
		$arraCall = array();

		if (isset($this->_dataObject->data->domain)) {
			// Grab domain name
			$domain = $this->_dataObject->data->domain;
			// $domain = htmlspecialchars($domain);
		} else {
			throw new Exception( "oSRS Error - Search domain strinng not defined.", E_USER_WARNING);
		}

		// Select non empty one
		if (isset($this->_dataObject->data->selected) && $this->_dataObject->data->selected != "") $arraSelected = explode (";", $this->_dataObject->data->selected);
		if (isset($this->_dataObject->data->defaulttld) && $this->_dataObject->data->defaulttld != "") $arraAll = explode (";", $this->_dataObject->data->defaulttld);
		if (count($arraSelected) == 0) {
			if (count($arraAll) == 0){
				$arraCall = array(".com",".net",".org");
			} else {
				$arraCall = $arraAll;
			}
		} else {
			$arraCall = $arraSelected;
		}
		
		$resObject = $this->_domainTLD ($domain, $arraCall);
	}

	// Selected / all TLD options
	private function _domainTLD($domain, $request){
		$cmd = array(
			"protocol" => "XCP",
			"action" => "name_suggest",
			"object" => "domain",
			"attributes" => array(
				"searchstring" => $domain,
				"service_override" => array(
					"suggestion" => array(
						"tlds" => $request
						)
					),
				"services" => array(
					"suggestion"
					)
				)
			);

		if(isset($this->_dataObject->data->maximum) && $this->_dataObject->data->maximum != ""){
			$cmd['attributes']['service_override']['suggestion']['maximum'] = $this->_dataObject->data->maximum;
		}
		
		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode($cmd);
		// Send XML
		$XMLresult = $this->send_cmd($xmlCMD);
		// FLip XML to Array
		$arrayResult = $this->_opsHandler->decode($XMLresult);

		// Results
		$this->resultFullRaw = $arrayResult;
		if (isset($arrayResult['attributes']['suggestion']['items'])){
			$this->resultRaw = $arrayResult['attributes']['suggestion']['items'];
		} else {
			$this->resultRaw = $arrayResult;
		}
		
		$this->resultFullFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
	}
}