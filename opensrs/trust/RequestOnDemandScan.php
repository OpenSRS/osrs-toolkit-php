<?php

namespace opensrs\trust;

use opensrs\Base;
use opensrs\Exception;

class RequestOnDemandScan extends Base
{
    protected $action = 'request_on_demand_scan';
    protected $object = 'trust_service';

    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public function __construct($formatString, $dataObject, $returnFullResponse = true)
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

    // Validate the object
    public function _validateObject($dataObject, $requiredFields = null)
    {
        if (!isset($dataObject->attributes->order_id) and !isset($dataObject->attributes->product_id)) {
            Exception::notDefined('order_id or product_id');
        }

        $parent = new parent();

        $parent->_validateObject($dataObject, $this->requiredFields);
    }
}
