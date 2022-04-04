<?php

namespace opensrs\domains\dnssec;

use opensrs\Base;

class DnsSecSet extends Base
{
    public $action = 'set_dnssec_info';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'dnssec',
        ),
        'domain'
    );

    const DNSSEC_EMPTY_ARRAY = 'emptyarray';

    public function __construct($formatString, $dataObject, $returnFullResponse = true)
    {
        if (empty($dataObject->attributes->dnssec)) {
            // We need to set this special "emptyarray" here so it can be encoded properly, it will be removed later
            $dataObject->attributes->dnssec = [self::DNSSEC_EMPTY_ARRAY];
        }

        parent::__construct();

        $this->_formatHolder = $formatString;

        $this->_validateObject($dataObject);

        $this->send($dataObject, $returnFullResponse);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * @inheritDoc
     */
    protected function modifyXml($xml) {
        // Remove special "emptyarray" here
        return str_replace('<item key="0">' . self::DNSSEC_EMPTY_ARRAY. '</item>', '', $xml);
    }
}
