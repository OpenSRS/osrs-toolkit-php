<?php

namespace opensrs\fastlookup;

use OpenSRS\FastLookup;
use OpenSRS\Exception;

class FastDomainLookup extends FastLookup 
{
    private $_domain = '';
    private $_tldSelect = array();
    private $_tldAll = array();
    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;
    public $tlds;

    public function __construct($formatString, $dataObject)
    {
        $this->setDataObject($formatString, $dataObject);

        $this->_validateObject($dataObject);

        $this->send($dataObject, $this->tlds);
    }

    // Validate the object
    private function _validateObject($dataObject)
    {
        $domain = '';
        
        // search domain must be definded
        if (!$this->hasDomain()) { 
            throw new Exception('oSRS Error - Search domain string not defined.');
        }

        // Grab domain name
        $domain = $this->getDomain();

        if (!$this->hasSelected()) {
            throw new Exception('oSRS Error - Selected domains are not defined.');
        }

        if (!$this->hasAlldomains()) {
            throw new Exception('oSRS Error - All domain strinng not defined.');
        }

        $selected = $this->getSelected();
        $this->tlds = $this->getAllDomains();

        if (count(array_filter($selected)) >= 1) {
            $this->tlds = $selected; 
        }
    }
}
