<?php

namespace OpenSRS\trust;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  - none -
 *
 *  Optional Data:
 *  data - owner_email, admin_email, billing_email, tech_email, del_from, del_to, exp_from, exp_to, page, limit
 */

class CancelOrder extends Base
{
    public $action = 'cancel_order';
    public $object = 'trust_service'

    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public function __construct($formatString, $dataObject, $returnFullResponse = true)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $this->_validateObject( $dataObject, $returnFullResponse);

        $this->send($datObject, $returnFullResponse);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    private function _validateObject()
    {
        if (!isset($this->_dataObject->data->order_id)) {
            throw new Exception('oSRS Error - order_id is not defined.');
        }
    }

    // Post validation functions
    // private function _processRequest()
    // {
    //     $cmd = array(
    //         'protocol' => 'XCP',
    //         'action' => 'cancel_order',
    //         'object' => 'trust_service',
    //         'attributes' => array(
    //             'order_id' => $this->_dataObject->data->order_id,
    //         ),
    //     );
    //
    //     $xmlCMD = $this->_opsHandler->encode($cmd);                    // Flip Array to XML
    //     $XMLresult = $this->send_cmd($xmlCMD);                        // Send XML
    //     $arrayResult = $this->_opsHandler->decode($XMLresult);        // Flip XML to Array
    //
    //     // Results
    //     $this->resultFullRaw = $arrayResult;
    //     $this->resultRaw = $arrayResult;
    //     $this->resultFullFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
    //     $this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
    // }
}
