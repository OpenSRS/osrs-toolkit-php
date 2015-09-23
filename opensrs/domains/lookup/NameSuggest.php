<?php

namespace opensrs\domains\lookup;

use opensrs\Base;

class NameSuggest extends Base
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
        if (!$returnFullResponse) {
            if (isset($arrayResult['attributes'])) {
                $resultRaw = array();

                if (isset($arrayResult['attributes']['lookup']['items'])) {
                    $resultRaw['lookup'] = $arrayResult['attributes']['lookup']['items'];
                }

                if (isset($arrayResult['attributes']['suggestion']['items'])) {
                    $resultRaw['suggestion'] = $arrayResult['attributes']['suggestion']['items'];
                }

                $arrayResult = $resultRaw;
            }
        }

        return $arrayResult;
    }
}
