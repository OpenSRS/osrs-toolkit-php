<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class NAME extends Base
{
    protected $tld = 'name';
    protected $requiredFields = array(
        'forwarding_email',
        );

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
        $requestData['attributes']['tld_data']['forwarding_email'] = $dataObject->data->forwarding_email;

        return $requestData;
    }
}
