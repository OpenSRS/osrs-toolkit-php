<?php

namespace opensrs\domains\forwarding;

use opensrs\Base;
use opensrs\Exception;

class ForwardingGet extends Base
{
    public $action = 'get_domain_forwarding';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array();

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
        // Command required values
        if (
            (!isset($dataObject->cookie) || !$dataObject->cookie) &&
            (!isset($dataObject->attributes->domain) || !$dataObject->attributes->domain)
        ) {
            throw new Exception('oSRS Error - cookie or domain is not defined.');
        }
        if (
            isset($dataObject->cookie) &&
            isset($dataObject->attributes->domain) &&
            $dataObject->cookie &&
            $dataObject->attributes->domain
        ) {
            throw new Exception('oSRS Error - Both cookie and domain cannot be set in one call.');
        }
    }
}
