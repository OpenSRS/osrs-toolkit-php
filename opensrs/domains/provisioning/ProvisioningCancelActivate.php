<?php

namespace opensrs\domains\provisioning;

use opensrs\Base;
use opensrs\Exception;

class ProvisioningCancelActivate extends Base
{
    public $action = 'cancel_active_process';
    public $object = 'domain';

    public $_formatHolder = '';
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
        if (
            (!isset($dataObject->attributes->order_id) ||
                $dataObject->attributes->order_id == '') &&
            (!isset($dataObject->attributes->domain) ||
                $dataObject->attributes->domain == '')
        ) {
            Exception::notDefined('order_id or domain');
        }
        if (
            isset($dataObject->attributes->order_id) &&
            $dataObject->attributes->order_id != '' &&
            isset($dataObject->attributes->domain) &&
            $dataObject->attributes->domain != ''
        ) {
            Exception::cannotSetOneCall('order_id and domain');
        }

        $parent = new parent();

        $parent->_validateObject($dataObject, $this->requiredFields);
    }
}
