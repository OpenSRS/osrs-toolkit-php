<?php

namespace opensrs\fastlookup;

use OpenSRS\FastLookup;
use OpenSRS\Exception;

class FastDomainLookup extends FastLookup 
{
    private $_domain = '';
    private $_tldSelect = array();
    private $_tldAll = array();
    private $_dataObject;
    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public function __construct($formatString, $dataObject)
    {

        parent::__construct();
        $this->_dataObject = $dataObject;
        $this->_formatHolder = $formatString;
        $this->_validateObject();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    private function _validateObject()
    {
        $allPassed = true;
        $domain = '';
        $arraSelected = array();
        $arraAll = array();
        $arraCall = array();

        if (isset($this->_dataObject->data->domain)) {
            // Grab domain name
            $domain = $this->_dataObject->data->domain;
        } else {
            throw new Exception('oSRS Error - Search domain strinng not defined.');
            $allPassed = false;
        }

        if (isset($this->_dataObject->data->selected)) {
            if ($this->_dataObject->data->selected != '') {
                $arraSelected = explode(';', $this->_dataObject->data->selected);
            }
        } else {
            throw new Exception('oSRS Error - Selected domains are not defined.');
            $allPassed = false;
        }

        if (isset($this->_dataObject->data->alldomains)) {
            if ($this->_dataObject->data->alldomains != '') {
                $arraAll = explode(';', $this->_dataObject->data->alldomains);
            } else {
                $allPassed = false;
            }
        } else {
            throw new Exception('oSRS Error - All domain strinng not defined.');
            $allPassed = false;
        }

        // Select non empty one
        if (count($arraSelected) == 0) {
            $arraCall = $arraAll;
        } else {
            $arraCall = $arraSelected;
        }

        // Call function
        if ($allPassed) {
            $resObject = $this->_domainTLD($domain, $arraCall);
        } else {

            throw new Exception('oSRS Error - Incorrect call.');
        }
    }

    // Selected / all TLD options
    private function _domainTLD($domain, $request)
    {
        $result = $this->checkDomainBunch($domain, $request);

        // Results
        $this->resultFullRaw = $result;
        $this->resultRaw = $result;
        $this->resultFullFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
        $this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);

    }

    public function convertArray2Formatted($type = '', $data = '')
    {
        $resultString = '';
        if ($type == 'json') {
            $resultString = json_encode($data);
        }
        if ($type == 'yaml') {
            $resultString = Spyc::YAMLDump($data);
        }

        return $resultString;
    }
}
