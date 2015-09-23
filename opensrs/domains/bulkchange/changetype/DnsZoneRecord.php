<?php

namespace opensrs\domains\bulkchange\changetype;

use opensrs\Base;
use opensrs\Exception;

class DnsZoneRecord extends Base
{
    protected $change_type = 'dns_zone_record';
    protected $checkFields = array(
        'dns_action',
        'dns_record_type',
        'dns_record_data',
        );

    public function __construct()
    {
        parent::__construct();
    }

    public function __deconstruct()
    {
        parent::__deconstruct();
    }

    public function validateChangeType($dataObject)
    {
        foreach ($this->checkFields as $field) {
            if (!isset($dataObject->data->$field) || !$dataObject->data->$field) {
                throw new Exception("oSRS Error - change type is {$this->change_type} but $field is not defined.");
            }
        }

        return true;
    }
}
