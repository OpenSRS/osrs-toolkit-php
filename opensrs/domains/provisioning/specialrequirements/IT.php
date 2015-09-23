<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class IT extends Base
{
    protected $tld = 'it';
    protected $requiredFields = array(
        'reg_code',
        'entity_type',
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
            if ($dataObject->it_registrant_info->$reqData == '') {
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
        if (isset($dataObject->it_registrant_info->nationality_code) && $dataObject->it_registrant_info->nationality_code != '') {
            $requestData['attributes']['tld_data']['it_registrant_info']['nationality_code'] = $dataObject->it_registrant_info->nationality_code;
        }

        $requestData['attributes']['tld_data']['it_registrant_info']['reg_code'] = $dataObject->it_registrant_info->reg_code;
        $requestData['attributes']['tld_data']['it_registrant_info']['entity_type'] = $dataObject->it_registrant_info->entity_type;

        return $requestData;
    }
}
