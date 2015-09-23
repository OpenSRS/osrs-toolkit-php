<?php

namespace opensrs\domains\provisioning;

use opensrs\Base;
use opensrs\Exception;

class ProvisioningModify extends Base
{
    public $action = 'modify';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'affect_domains',
            'data',
            ),
        );

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
        if (empty($dataObject->cookie) && empty($dataObject->attributes->domain)) {
            Exception::notDefined('cookie and/or domain.');
        }

        $parent = new parent();

        $parent->_validateObject($dataObject, $this->requiredFields);
    }
}
