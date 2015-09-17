<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

<<<<<<< HEAD
class LookupDomain extends Base
{
    private $_domain = '';
=======
class LookupDomain extends Base {
    public $action = "name_suggest";
    public $object = "domain";

    public $_formatHolder = "";
>>>>>>> 8d38b07d82e838deed7e8be70befd06fe6d5b4d6
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public function __construct( $formatString, $dataObject, $returnFullResponse = true ) {
        parent::__construct();
<<<<<<< HEAD
        $this->setDataObject($formatString, $dataObject);
        $this->_validateObject();
=======

        $this->_formatHolder = $formatString;

        $this->_validateObject( $dataObject );

        $this->send( $dataObject, $returnFullResponse );
>>>>>>> 8d38b07d82e838deed7e8be70befd06fe6d5b4d6
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    public function _validateObject( $dataObject )
    {
        // search domain must be defined
        if (!isset($dataObject->attributes->domain)) {
            throw new Exception('oSRS Error - Search domain string not defined.');
        }
<<<<<<< HEAD

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

        $this->resultFullFormatted = $this->convertArray2Formatted($this->dataFormat, $this->resultFullRaw);
        $this->resultFormatted = $this->convertArray2Formatted($this->dataFormat, $this->resultRaw);
=======
>>>>>>> 8d38b07d82e838deed7e8be70befd06fe6d5b4d6
    }
}
