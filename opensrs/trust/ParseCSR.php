<?php

namespace opensrs\trust;

use opensrs\Base;

class ParseCSR extends Base
{
    protected $action = 'parse_csr';
    protected $object = 'trust_service';

    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'csr',
            'product_type',
            ),
        );
    public function __construct($formatString, $dataObject, $returnFullResults = null)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $this->_validateObject($dataObject);

        $this->send($dataObject, $returnFullResults);
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
