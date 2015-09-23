<?php

namespace opensrs\fastlookup;

use opensrs\FastLookup;
use opensrs\Exception;

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
        $this->_formatHolder = $formatString;

        $this->_validateObject($dataObject);

        $this->send($dataObject, $this->tlds);
    }

    // Validate the object
    private function _validateObject($dataObject)
    {
        $domain = '';

        // search domain must be definded
        if (!isset($dataObject->data->domain)) {
            Exception::notDefined('domain');
        }

        // Grab domain name
        $domain = $dataObject->data->domain;

        if (!isset($dataObject->data->selected)) {
            Exception::notDefined('selected');
        }

        if (!isset($dataObject->data->alldomains)) {
            Exception::notDefined('alldomains');
        }

        $selected = explode(';', $dataObject->data->selected);
        $this->tlds = explode(';', $dataObject->data->alldomains);

        if (count(array_filter($selected)) >= 1) {
            $this->tlds = $selected;
        }
    }
}
