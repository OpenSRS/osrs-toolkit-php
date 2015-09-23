<?php

namespace opensrs\domains\provisioning\specialrequirements;

use opensrs\Base;
use opensrs\Exception;

class CA extends Base
{
    protected $tld = 'ca';
    protected $requiredFields = array(
        'isa_trademark',
        'lang_pref',
        'legal_type',
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
        $requestData['attributes']['isa_trademark'] = $dataObject->data->isa_trademark;
        $requestData['attributes']['lang_pref'] = $dataObject->data->lang_pref;
        $requestData['attributes']['legal_type'] = strtoupper($dataObject->data->legal_type);

        if (isset($dataObject->data->ca_link_domain) && $dataObject->data->ca_link_domain != '') {
            $requestData['attributes']['ca_link_domain'] = $dataObject->data->ca_link_domain;
        }

        if (isset($dataObject->data->cwa) && $dataObject->data->cwa != '') {
            $requestData['attributes']['cwa'] = $dataObject->data->cwa;
        }

        if (isset($dataObject->data->domain_description) && $dataObject->data->domain_description != '') {
            $requestData['attributes']['domain_description'] = $dataObject->data->domain_description;
        }

        if (isset($dataObject->data->rant_agrees) && $dataObject->data->rant_agrees != '') {
            $requestData['attributes']['rant_agrees'] = $dataObject->data->rant_agrees;
        }

        if (isset($dataObject->data->rant_no) && $dataObject->data->rant_no != '') {
            $requestData['attributes']['rant_no'] = $dataObject->data->rant_no;
        }

        return $requestData;
    }
}
