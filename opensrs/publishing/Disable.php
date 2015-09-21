<?php

namespace OpenSRS\publishing;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  - none -
 *
 *  Optional Data:
 *  data - owner_email, admin_email, billing_email, tech_email, del_from, del_to, exp_from, exp_to, page, limit
 */

class Disable extends Base
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

    // Validate the object
    public function _validateObject( $dataObject = array() ) 
    {
        if (!isset($this->_dataObject->data->domain)) {
            throw new Exception('oSRS Error - domain is not defined.');
        }

        if (!isset($this->_dataObject->data->service_type)) {
            throw new Exception('oSRS Error - service_type is not defined.');
        }

        // Execute the command
        $this->_processRequest();
    }

    // Post validation functions
    private function _processRequest()
    {
        $cmd = array(
            'protocol' => 'XCP',
            'action' => 'disable',
            'object' => 'publishing',
            'attributes' => array(
                'domain' => $this->_dataObject->data->domain,
                'service_type' => $this->_dataObject->data->service_type,
            ),
        );

        $xmlCMD = $this->_opsHandler->encode($cmd);                    // Flip Array to XML
        $XMLresult = $this->send_cmd($xmlCMD);                        // Send XML
        $arrayResult = $this->_opsHandler->decode($XMLresult);        // Flip XML to Array

        // Results
        $this->resultFullRaw = $arrayResult;
        $this->resultRaw = $arrayResult;
        $this->resultFullFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
        $this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
    }
}
