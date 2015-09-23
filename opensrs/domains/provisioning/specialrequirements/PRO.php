<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class PRO extends Base
{
    protected $tld = 'pro';
    protected $requiredFields = array(
        'profession',
        );
    protected $requestFields = array(
        'authority',
        'authority_website',
        'license_number',
        'profession',
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
            if ($dataObject->professional_data->$reqData == '') {
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
        foreach ($this->requestFields as $reqData) {
            if (isset($dataObject->professional_data->$reqData) && $dataObject->professional_data->$reqData != '') {
                $requestData['attributes']['tld_data']['professional_data'][$reqData] = $dataObject->professional_data->$reqData;
            }
        }

        return $requestData;
    }
}
