<?php

namespace opensrs\domains\provisioning;

use opensrs\Base;

class SendRegistrantVerificationEmail extends Base
{
    public $action = 'send_registrant_verification_email';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'domain'
        )
    );

    public function __construct($formatString, $dataObject, $returnFullResponse = true)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $this->_validateObject($dataObject, $this->requiredFields);

        $this->send($dataObject, $returnFullResponse);
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
