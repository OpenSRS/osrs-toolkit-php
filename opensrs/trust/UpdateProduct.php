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
    protected $action = 'update_product';
    protected $object = 'trust_service';

    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public function __construct($formatString, $dataObject, $returnFullResponse = false)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;
        
        $this->_validateObject($dataObject);

        $this->send($dataObject, $returnFullResponse);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    private function _validateObject()
    {
        if (!isset($this->_dataObject->data->product_id)) {
            throw new Exception('oSRS Error - product_id is not defined.');
            $allPassed = false;
        }
    }
}
