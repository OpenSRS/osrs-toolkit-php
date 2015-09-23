<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class US extends Base
{
    protected $tld = 'us';
    protected $requiredFields = array(
        'app_purpose',
        'category',
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
            if ($dataObject->nexus->$reqData == '') {
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
        $requestData['attributes']['tld_data']['nexus']['app_purpose'] = $dataObject->nexus->app_purpose;
        $requestData['attributes']['tld_data']['nexus']['category'] = $dataObject->nexus->category;

        if (isset($dataObject->nexus->validator) && $dataObject->nexus->validator != '') {
            $requestData['attributes']['tld_data']['nexus']['validator'] = $dataObject->nexus->validator;
        }

        return $requestData;
    }
}
