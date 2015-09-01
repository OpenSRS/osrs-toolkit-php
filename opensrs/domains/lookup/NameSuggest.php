<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

class NameSuggest extends Base {
	private $_domain = "";
	private $_tldSelect = array ();
	private $_tldAll = array ();
	private $_dataObject;
	private $_formatHolder = "";

	public $defaulttld_nsselected = array (".com",".net",".org",".info",".biz",".us",".mobi");
	public $defaulttld_lkselected = array ();
	public $defaulttld_allnsdomains = array ();
	public $defaulttld_alllkdomains = array (".com",".net",".ca",".us",".eu",".de",".co.uk");

	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;
	public $result;

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
		$domain = "";
		$arransSelected = array();
		$arralkSelected = array();
		$arransAll = array();
		$arralkAll = array();
		$arransCall = array();
		$arralkCall = array();

		if (!isset($this->_dataObject->data->domain)) {
			throw new Exception("oSRS Error - Search domain strinng not defined.");
		}

		// Grab domain name
		$tdomain = $this->_dataObject->data->domain;
		$tdom = explode (".", $tdomain);
		$domain = $tdom[0];

		// Select non-empty one

		// Name Suggestion Choice Check
		$arransSelected = $this->getTlds( 'nsselected' );

		// Lookup Choice Check
		$arralkSelected = $this->getTlds( 'lkselected' );

		// Get Default Name Suggestion Choices For No Form Submission
		$arransAll =  $this->getTlds( 'allnsdomains' );

		// Get Default Lookup Choices For No Form Submission
		$arralkAll =  $this->getTlds( 'alllkdomains' );


		// If Name Suggestion Choices Empty
		if (empty($arransSelected)) {
			if (empty($arransAll)) {
				$arransCall = $this->getTlds( 'nsselected' );
			} else {
				$arransCall = $arransAll;
			}
		} else {
			$arransCall = $arransSelected;
		}

		// If Lookup Choices Empty
		if (empty($arralkSelected)) {
			if (empty($arralkAll)){
				$arralkCall = $this->getTlds( 'alllkdomain' );
			} else {
				$arralkCall = $arralkAll;
			}
		} else {
			$arralkCall = $arralkSelected;
		}

		$resObject = $this->_domainTLD ($domain, $arransCall, $arralkCall);
	}

	/**
	* Get tlds for domain call 
	* Will use (in order of preference)... 
	* 1. selected tlds 
	* 2. supplied default tlds 
	* 3. included default tlds
	* 
	* @return array tlds 
	*/
	public function getTlds( $field = 'selected', $default = 'defaulttld' )
	{
		$arraSelected = array();
		$arraAll = array();
		$arraCall = array();

		// Select non empty one
		if (isset($this->_dataObject->data->$field) && $this->_dataObject->data->$field != '') {
			$arraSelected = explode(';', $this->_dataObject->data->$field);
		}

		if (count($arraSelected) == 0) {
			if (count($arraAll) == 0) {
				if(isset($this->$default)){
					$arraCall = $this->$default;
				}
				elseif(isset($this->{$default."_".$field})) {
					$arraCall = $this->{$default."_".$field};
				}
			} else {
				$arraCall = $arraAll;
			}
		} else {
			$arraCall = $arraSelected;
		}

		return $arraCall;
	}

	// Selected / all TLD options
	private function _domainTLD($domain, $nstlds, $lktlds){
		$cmd = array(
			"protocol" => "XCP",
			"action" => "name_suggest",
			"object" => "domain",
			"attributes" => array(
				"searchstring" => $domain,
				"service_override" => array(
					"lookup" => array(
						"tlds" => $lktlds
						),
					"suggestion" => array(
						"tlds" => $nstlds
						)
					),
				"services" => array(
					"lookup","suggestion"
					)
				)
			);

		if(isset($this->_dataObject->data->maximum) && $this->_dataObject->data->maximum != ""){
			$cmd['attributes']['service_override']['lookup']['maximum'] = $this->_dataObject->data->maximum;
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

		if (isset($arrayResult['attributes'])){
			$this->resultRaw = array ();

			if(isset($arrayResult['attributes']['lookup']['items'])){
				$this->resultRaw['lookup'] = $arrayResult['attributes']['lookup']['items'];
			}

			if(isset($arrayResult['attributes']['suggestion']['items'])){
				$this->resultRaw['suggestion'] = $arrayResult['attributes']['suggestion']['items'];
			}
		} else {
			$this->resultRaw = $arrayResult;
		}

		$this->resultFullFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
	}
}
