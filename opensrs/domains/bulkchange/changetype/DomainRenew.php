<?php

namespace opensrs\domains\bulkchange\changetype;

use opensrs\Base;
use opensrs\Exception;

class DomainRenew extends Base
{
    protected $change_type = 'domain_renew';
    protected $checkFields = array();

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

        if (
            !isset($dataObject->data->period) && $dataObject->data->period == '' &&
            !isset($dataObject->data->let_expire) && $dataObject->data->let_expire == '' &&
            !isset($dataObject->data->auto_renew) && $dataObject->data->auto_renew == ''
        ) {
            throw new Exception("oSRS Error - change type is {$this->change_type} but at least one of period, let_expire or auto_renew has to be defined.");
        }

        return true;
    }
}
