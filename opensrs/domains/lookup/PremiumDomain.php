<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

class PremiumDomain extends Base
{
    private $_domain = '';
    private $_tldSelect = array();
    private $_tldAll = array();
    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;
    public $result;

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

        // Grab domain name
        $domain = $this->getDomain();

        // get tlds
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
                    'premium' => array(
                        'tlds' => $request,
                    ),
                ),
                'services' => array(
                    'premium',
                ),
            ),
        );

        if (isset($this->dataObject->data->maximum) && $this->dataObject->data->maximum != '') {
            $cmd['attributes']['service_override']['premium']['maximum'] = $this->dataObject->data->maximum;
        }

        $xmlCMD = $this->_opsHandler->encode($cmd);                    // Flip Array to XML
        $XMLresult = $this->send_cmd($xmlCMD);                        // Send XML
        $arrayResult = $this->_opsHandler->decode($XMLresult);        // FLip XML to Array

        // Results
        $this->resultFullRaw = $arrayResult;
        if (isset($arrayResult['attributes']['premium']['items'])) {
            $this->resultRaw = $arrayResult['attributes']['premium']['items'];
        } else {
            $this->resultRaw = $arrayResult;                        // Null if there are no premium domains 
        }

        $this->resultFullFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
        $this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
    }
}
