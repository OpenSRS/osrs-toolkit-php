<?php

namespace opensrs\trust;

use opensrs\Base;

class GetOrderInfo extends Base
{
    protected $action = 'get_order_info';
    protected $object = 'trust_service';

    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'order_id',
            ),
        );

    public function __construct($formatString, $dataObject, $returnFullResponse = null)
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
