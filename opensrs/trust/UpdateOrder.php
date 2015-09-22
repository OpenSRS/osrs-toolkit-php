<?php

namespace OpenSRS\trust;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - 
 */

class UpdateOrder extends Base
{
    protected $action = 'update_order';
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

    public function _validateObject($dataObject)
    {
        if (!isset($this->_dataObject->data->order_id)) {
            throw new Exception('oSRS Error - order_id is not defined.');
        }
    }
}
