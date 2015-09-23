<?php

namespace opensrs\domains\provisioning;

use opensrs\Base;

class SWRegister extends Base
{
    public $action = 'sw_register';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'domain',
            'custom_nameservers',
            'custom_tech_contact',
            'period',
            'reg_username',
            'reg_password',
            'reg_type',
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
        /* Added by BC : NG : 16-7-2014 : To set error message for Insufficient Funds */
        if (isset($arrayResult['attributes']['forced_pending']) and $arrayResult['attributes']['forced_pending'] != '' and $arrayResult['is_success'] == 1) {
            $arrayResult['is_success'] = 0;

            // Get Resonse Text 'Registration successful'  when insufficient fund
            if ($arrayResult['response_text'] == 'Registration successful') {
                $arrayResult['response_text'] = 'Insufficient Funds';
            }
        }

        return $arrayResult;
    }
}
