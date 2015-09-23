<?php

namespace opensrs\domains\provisioning;

use opensrs\Base;
use opensrs\Exception;

class ProvisioningUpdateContacts extends Base
{
    public $action = 'update_contacts';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'domain',
            'types',
            ),
        );

    public function __construct($formatString, $dataObject, $returnFullResponse = true)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $this->_validateObject($dataObject);

        $this->send($dataObject, $returnFullResponse);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    public function _validateObject($dataObject, $requiredFields = null)
    {
        $parent = new parent();

        $parent->_validateObject($dataObject, $this->requiredFields);

        $tld = explode('.', $dataObject->attributes->domain, 2);

        // .NL doesn't require state, others do
        if ($tld == 'nl') {
            $reqPers = array('first_name', 'last_name', 'org_name', 'address1', 'city', 'country', 'postal_code', 'phone', 'email', 'lang_pref');
        } else {
            $reqPers = array('first_name', 'last_name', 'org_name', 'address1', 'city', 'state', 'country', 'postal_code', 'phone', 'email', 'lang_pref');
        }

        $contact_types = array('owner', 'admin', 'tech', 'billing');

        for ($c = 0; $c < count($contact_types); ++$c) {
            $contact_type = $contact_types[$c];

            if (!isset($dataObject->attributes->contact_set->$contact_type)) {
                Exception::notDefined($contact_type);
            }

            for ($i = 0; $i < count($reqPers); ++$i) {
                if (
                    !isset($dataObject->attributes->contact_set->$contact_type->{$reqPers[$i]}) ||
                    $dataObject->attributes->contact_set->$contact_type->{$reqPers[$i]} == ''
                ) {
                    Exception::notDefined($reqPers[$i]);
                }
            }
        }
    }
}
