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
		$allPassed = true;
		$domain = "";
		$arransSelected = array ();
		$arralkSelected = array ();
		$arransAll = array ();
		$arralkAll = array ();
		$arransCall = array ();
		$arralkCall = array ();

		if (isset($this->_dataObject->data->domain)) {
			// Grab domain name
			$tdomain = $this->_dataObject->data->domain;
			$tdom = explode (".", $tdomain);
			$domain = $tdom[0];
		} else {
			trigger_error ("oSRS Error - Search domain strinng not defined.", E_USER_WARNING);
			$allPassed = false;
		}
		
		// Select non empty one

                // Name Suggestion Choice Check
		if (isset($this->_dataObject->data->nsselected) && $this->_dataObject->data->nsselected != "") $arransSelected = explode (";", $this->_dataObject->data->nsselected);

                // Lookup Choice Check
		if (isset($this->_dataObject->data->lkselected) && $this->_dataObject->data->lkselected != "") $arralkSelected = explode (";", $this->_dataObject->data->lkselected);

                // Get Default Name Suggestion Choices For No Form Submission
		if (isset($this->_dataObject->data->allnsdomains) && $this->_dataObject->data->allnsdomains != "") $arransAll = explode (";", $this->_dataObject->data->allnsdomains);

                // Get Default Lookup Choices For No Form Submission
		if (isset($this->_dataObject->data->alllkdomain) && $this->_dataObject->data->alllkdomains != "") $arralkAll = explode (";", $this->_dataObject->data->alllkdomains);


                // If Name Suggestion Choices Empty
		if (empty($arransSelected)) {
			if (empty($arransAll)){
				$arransCall = array (".com",".net",".org",".info",".biz",".us",".mobi");
			} else {
				$arransCall = $arransAll;
			}
		} else {
			$arransCall = $arransSelected;
		}

                // If Lookup Choices Empty
		if (empty($arralkSelected)) {
			if (empty($arralkAll)){
				$arralkCall = array (".com",".net",".ca",".us",".eu",".de",".co.uk");
			} else {
				$arralkCall = $arralkAll;
			}
		} else {
			$arralkCall = $arralkSelected;
		}

		// Call function
		if ($allPassed) {
			$resObject = $this->_domainTLD ($domain, $arransCall, $arralkCall);
		} else {
			trigger_error ("oSRS Error - Incorrect call.", E_USER_WARNING);
		}
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


		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML

		$arrayResult = $this->_opsHandler->decode($XMLresult);		// FLip XML to Array

		// Results
		$this->resultFullRaw = $arrayResult;

		var_dump($arrayResult);
		
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
