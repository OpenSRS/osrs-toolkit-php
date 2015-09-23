<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class BR extends Base
{
    protected $tld = 'br';
    protected $requiredFields = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function __deconstruct()
    {
        parent::__deconstruct();
    }

    public function meetsSpecialRequirements($dataObject)
    {
        return $this->validateSpecialFields($dataObject) && !$this->needsSpecialRequirements($dataObject);
    }

    public function validateSpecialFields($dataObject)
    {
        // Make sure all required fields defined in
        // $this->requiredFields array are assigned
        // values
        foreach ($this->requiredFields as $reqData) {
            if ($dataObject->data->$reqData == '') {
                throw new Exception('oSRS Error - '.$reqData[$i].' is not defined.');
            }
        }

        // Make sure we have a br_register_number
        if ($this->_dataObject->br_registrant_info->br_register_number == '') {
            throw new Exception('oSRS Error - Register number not defined');
        }

        return true;
    }

    public function needsSpecialRequirements($dataObject)
    {
        // returning true due to the original SWRegister class
        // throwing an exception for all domains that are NOT
        // .asia, .it, .eu or .de

        return true;
    }

    public function setSpecialRequestFieldsForTld($dataObject, $requestData)
    {
        $requestData['attributes']['tld_data']['br_register_number'] = $dataObject->br_registrant_info->br_register_number;

        return $requestData;
    }
}
