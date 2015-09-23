<?php

namespace opensrs\domains\subreseller;

use opensrs\Base;

class SubresellerModify extends Base
{
    public $action = 'modify';
    public $object = 'subreseller';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'ccp_enabled',
            'low_balance_email',
            'password',
            'pricing_plan',
            'status',
            'system_status_email',
            'username',
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
}
