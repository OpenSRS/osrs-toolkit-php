<?php

namespace opensrs\fastlookup;

use OpenSRS\FastLookup;
use OpenSRS\Exception;

class FastDomainLookup extends FastLookup 
{
    private $_domain = '';
    private $_tldSelect = array();
    private $_tldAll = array();
    // private $_dataObject;
    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public function __construct($formatString, $dataObject)
    {

        parent::__construct();
        // $this->_dataObject = $dataObject;
        // $this->_formatHolder = $formatString;
        $this->setDataObject($formatString, $dataObject);
        $this->_validateObject();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    private function _validateObject()
    {
        $domain = '';
        $arraSelected = array();
        $arraAll = array();
        $arraCall = array();

        // search domain must be definded
        if (!$this->hasDomain()) { 
            throw new Exception('oSRS Error - Search domain string not defined.');
        }

        // Grab domain name
        $domain = $this->getDomain();

        // selected required
        if (!$this->hasSelected()) {
            throw new Exception('oSRS Error - Selected domains are not defined.');
        }

        $arraSelected = $this->getSelected();

        // all domains required
        if (!$this->hasAllDomains()) {
            throw new Exception('oSRS Error - All domain strinng not defined.');
        }

        $arrAll = $this->getAllDomains();

        // Select non empty one
        if (count($arraSelected) == 0) {
            $arraCall = $arraAll;
        } else {
            $arraCall = $arraSelected; 
        }

        // Call function
        $resObject = $this->_domainTLD($domain, $arraCall);
    }

    // Selected / all TLD options
    private function _domainTLD($domain, $request)
    {
        $result = $this->checkDomainBunch($domain, $request);

        // Results
        $this->resultFullRaw = $result;
        $this->resultRaw = $result;
        $this->resultFullFormatted = $this->convertArray2Formatted($this->dataFormat, $this->resultFullRaw);
        $this->resultFormatted = $this->convertArray2Formatted($this->dataFormat, $this->resultRaw);

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
