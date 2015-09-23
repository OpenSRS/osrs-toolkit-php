<?php

namespace opensrs\domains\authentication;

use opensrs\Base;

class AuthenticationChangeOwnership extends Base
{
    public $action = 'change';
    public $object = 'ownership';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'cookie',

        'attributes' => array(
            'username',
            'password',
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
