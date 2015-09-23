<?php

namespace opensrs\domains\bulkchange\changetype;

use opensrs\Base;
use opensrs\Exception;

class DomainNameservers extends Base
{
    protected $change_type = 'domain_nameservers';
    protected $checkFields = array(
        'op_type',
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

        if (!isset($dataObject->data->add_ns) && $dataObject->data->add_ns == '' &&
        !isset($dataObject->data->remove_ns) && $dataObject->data->remove_ns == '' &&
        !isset($dataObject->data->assign_ns) && $dataObject->data->assign_ns == '') {
            throw new Exception("oSRS Error - change type is {$this->change_type} but at least one of add_ns, remove_ns or assign_ns has to be defined.");
        }

        return true;
    }
}
