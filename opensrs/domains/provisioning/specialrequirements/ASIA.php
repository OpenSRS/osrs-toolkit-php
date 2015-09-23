<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class ASIA extends Base
{
    protected $tld = 'asia';
    protected $requiredFields = array(
        'contact_type',
        'id_number',
        'id_type',
        'legal_entity_type',
        'locality_country',
        );
    protected $requestFields = array(
        'contact_type',
        'id_number',
        'id_type',
        'legal_entity_type',
        'locality_country',
        'id_type_info',
        'legal_entity_type_info',
        'locality_city',
        'locality_state_prov',
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
            if ($dataObject->cedinfo->$reqData == '') {
                throw new Exception('oSRS Error - '.$reqData.' is not defined.');
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
        foreach ($this->requestFields as $reqData) {
            if (isset($dataObject->cedinfo->$reqData) && $dataObject->cedinfo->$reqData != '') {
                $requestData['attribugtes']['tld_data']['ced_info'][$reqData] = $dataObject->cedinfo->$reqData;
            }
        }

        return $requestData;
    }
}
