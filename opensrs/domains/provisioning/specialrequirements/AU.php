<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class AU extends Base
{
    protected $tld = 'au';
    protected $requiredFields = array(
        'registrant_name',
        'eligibility_type',
        );
    protected $requiredFieldsSub = array(
        'registrant_id',
        'registrant_id_type',
        );
    protected $requestFields = array(
        'registrant_name',
        'eligibility_type',
        'registrant_id',
        'registrant_id_type',
        'eligibility_name',
        'eligibility_id',
        'eligibility_id_type',
        'eligibility_reason',
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
        $reqDatas = array('registrant_name',  'eligibility_type');

        $tld = explode('.', strtolower($dataObject->data->domain), 2);

        if ($tld == 'au') {
            $this->requiredFields = array_merge($reqDatas, $this->requiredFieldsSub);
        }

        // Make sure all required fields defined in
        // $this->requiredFields array are assigned
        // values
        foreach ($this->requiredFields as $reqData) {
            if ($dataObject->au_registrant_info->$reqData == '') {
                throw new Exception('oSRS Error - '.$reqData.' is not defined.');
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
            if (isset($dataObject->au_registrant_info->$reqData) && $dataObject->au_registrant_info->$reqData != '') {
                $requestData['attributes']['tld_data']['au_registrant_info'][$reqData] = $dataObject->au_registrant_info->$reqData;
            }
        }

        return $requestData;
    }
}
