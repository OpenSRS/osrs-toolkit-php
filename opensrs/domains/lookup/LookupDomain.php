<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

class LookupDomain extends Base
{
    private $_domain = '';
    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;
    protected $defaultTlds = array('.com','.net','.org', '.ca');

    public function __construct($formatString, $dataObject)
    {
        parent::__construct();
        $this->dataObject = $dataObject;
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
        $domain = '';

        // search domain must be definded
        if (!$this->hasDomain()) {
            throw new Exception('oSRS Error - Search domain string not defined.');
        }

        $domain = $this->getDomain();

        $tlds = $this->getConfiguredTlds();

        // Call function
        $resObject = $this->_domainTLD($domain, $tlds);
    }

    // Selected / all TLD options
    private function _domainTLD($domain, $request)
    {
        $cmd = array(
            'protocol' => 'XCP',
            'action' => 'name_suggest',
            'object' => 'domain',
            'attributes' => array(
                'searchstring' => $domain,
                'service_override' => array(
                    'lookup' => array(
                        'tlds' => $request,
                    ),
                ),
                'services' => array(
                    'lookup',
                ),
            ),
        );

        if (isset($this->dataObject->data->maximum) && $this->dataObject->data->maximum != '') {
            $cmd['attributes']['service_override']['lookup']['maximum'] = $this->dataObject->data->maximum;
        }

        $xmlCMD = $this->_opsHandler->encode($cmd);                    // Flip Array to XML
        $XMLresult = $this->send_cmd($xmlCMD);                        // Send XML
        $arrayResult = $this->_opsHandler->decode($XMLresult);        // FLip XML to Array

        // Results
        $this->resultFullRaw = $arrayResult;
        if (isset($arrayResult['attributes']['lookup']['items'])) {
            $this->resultRaw = $arrayResult['attributes']['lookup']['items'];
        } else {
            $this->resultRaw = $arrayResult;
        }

        $this->resultFullFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
        $this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
    }
}
