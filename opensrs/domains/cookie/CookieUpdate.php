<?php

namespace opensrs\domains\cookie;

use opensrs\Base;

class CookieUpdate extends Base
{
    public $action = 'update';
    public $object = 'cookie';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'cookie',

        'attributes' => array(
            'reg_username',
            'reg_password',
            'domain',
            'domain_new',
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
