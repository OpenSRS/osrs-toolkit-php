<?php

namespace opensrs\domains\provisioning;

use opensrs\Base;

class ProvisioningRenew extends Base
{
    public $action = 'renew';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'auto_renew',
            'currentexpirationyear',
            'domain',
            'handle',
            'period',
            ),
        );

    public function __construct($formatString, $dataObject, $returnFullResponse = true)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $this->_validateObject($dataObject);

        $this->send($dataObject, $returnFullResponse);
    }
}
