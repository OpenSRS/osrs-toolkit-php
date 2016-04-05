<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class SE extends Base
{
    protected $tld = 'se';
    protected $requiredFields = array(
	'registrant_type',
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
        if (isset($dataObject->registrant_extra_info->registrant_type) && $dataObject->registrant_extra_info->registrant_type == 'individual') {
		$this->requiredFields[] = 'id_card_number';
	} else {
		$this->requiredFields[] = 'registrant_vat_id';
		$this->requiredFields[] = 'registration_number';
	}
        foreach ($this->requiredFields as $reqData) {
            if ($dataObject->registrant_extra_info->$reqData == '') {
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
        $requestData['attributes']['tld_data']['registrant_extra_info']['registrant_type'] = $dataObject->registrant_extra_info->registrant_type;
        if (isset($dataObject->registrant_extra_info->registrant_type) && $dataObject->registrant_extra_info->registrant_type == 'individual') {
            $requestData['attributes']['tld_data']['registrant_extra_info']['id_card_number'] = $dataObject->registrant_extra_info->id_card_number;
        } else {
            $requestData['attributes']['tld_data']['registrant_extra_info']['registrant_vat_id'] = $dataObject->registrant_extra_info->registrant_vat_id;
            $requestData['attributes']['tld_data']['registrant_extra_info']['registration_number'] = $dataObject->registrant_extra_info->registration_number;
	}
        return $requestData;
    }
}
