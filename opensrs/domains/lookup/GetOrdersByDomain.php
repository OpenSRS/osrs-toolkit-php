<?php

namespace opensrs\domains\lookup;

use opensrs\Base;

class GetOrdersByDomain extends Base
{
    public $action = 'get_orders_by_domain';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'domain',
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

    public function customResponseHandling($arrayResult, $returnFullResponse = true)
    {
        if (!$returnFullResponse) {
            if (isset($arrayResult['attributes']['lookup']['items'])) {
                $arrayResult = $arrayResult['attributes']['lookup']['items'];
            }
        }

        return $arrayResult;
    }
}
