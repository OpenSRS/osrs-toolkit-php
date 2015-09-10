<?php

namespace OpenSRS\trust;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - 
 */

class UpdateProduct extends Base
{
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

    private function _validateObject()
    {
        $allPassed = true;

        if (!isset($this->_dataObject->data->product_id)) {
            throw new Exception('oSRS Error - product_id is not defined.');
            $allPassed = false;
        }

        // Run the command
        if ($allPassed) {
            // Execute the command
            $this->_processRequest();
        } else {
            throw new Exception('oSRS Error - Incorrect call.');
        }
    }

    // Post validation functions
    private function _processRequest()
    {
        $cmd = array(
            'protocol' => 'XCP',
            'action' => 'update_product',
            'object' => 'trust_service',
            'attributes' => array(
                'product_id' => $this->_dataObject->data->product_id,
            ),
        );

        // Command optional values
        if (isset($this->_dataObject->data->contact_email) && $this->_dataObject->data->contact_email != '') {
            $cmd['attributes']['contact_email'] = $this->_dataObject->data->contact_email;
        }
        if (isset($this->_dataObject->data->seal_in_search) && $this->_dataObject->data->seal_in_search != '') {
            $cmd['attributes']['seal_in_search'] = $this->_dataObject->data->seal_in_search;
        }
        if (isset($this->_dataObject->data->trust_seal) && $this->_dataObject->data->trust_seal != '') {
            $cmd['attributes']['trust_seal'] = $this->_dataObject->data->trust_seal;
        }

        $xmlCMD = $this->_opsHandler->encode($cmd);                    // Flip Array to XML
        $XMLresult = $this->send_cmd($xmlCMD);                        // Send XML
        $arrayResult = $this->_opsHandler->decode($XMLresult);        // Flip XML to Array

        // Results
        $this->resultFullRaw = $arrayResult;
        if (isset($arrayResult['attributes'])) {
            $this->resultRaw = $arrayResult['attributes'];
        } else {
            $this->resultRaw = $arrayResult;
        }
        $this->resultFullFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
        $this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
        $this->XMLresult = $XMLresult;
    }
}
