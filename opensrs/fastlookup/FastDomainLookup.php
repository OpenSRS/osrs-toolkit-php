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
        if (!isset($dataObject->data->domain)) {
            throw new Exception('oSRS Error - domain is not defined.');
        }

        // Grab domain name
        $domain = $this->getDomain();

        if (!isset($dataObject->data->selected)) {
            throw new Exception('oSRS Error - selected is not defined.');
        }

        if (!isset($dataObject->data->alldomains)) {
            throw new Exception('oSRS Error - alldomains is not defined.');
        }

        $selected = $this->getSelected();
        $this->tlds = $this->getAllDomains();

        if (count(array_filter($selected)) >= 1) {
            $this->tlds = $selected; 
        }
    }
}
