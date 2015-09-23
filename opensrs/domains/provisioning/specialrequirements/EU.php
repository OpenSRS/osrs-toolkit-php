<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class EU extends Base
{
    protected $tld = 'eu';
    protected $requiredFields = array(
        'eu_country',
        'lang',
        'owner_confirm_address',
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
        return false;
    }

    public function setSpecialRequestFieldsForTld($dataObject, $requestData)
    {
        $requestData['attributes']['country'] = strtoupper($dataObject->data->eu_country);
        $requestData['attributes']['lang'] = $dataObject->data->lang;
        $requestData['attributes']['owner_confirm_address'] = $dataObject->data->owner_confirm_address;

        return $requestData;
    }
}
