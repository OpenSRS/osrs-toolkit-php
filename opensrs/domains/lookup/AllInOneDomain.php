<?php

namespace opensrs\domains\lookup;

use opensrs\Base;

class AllInOneDomain extends Base
{
    public $action = 'name_suggest';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'searchstring',
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
        if ($returnFullResponse) {
            if (isset($arrayResult['attributes']['premium']['items'])) {
                $tempHold = $arrayResult['attributes']['premium']['items'];
            } else {
                $tempHold = null;
            }

            $arrayResult = array(
                'lookup' => $arrayResult['attributes']['lookup']['items'],
                'premium' => $tempHold,
                'suggestion' => $arrayResult['attributes']['suggestion']['items'],
                );
        }

        return $arrayResult;
    }
}
