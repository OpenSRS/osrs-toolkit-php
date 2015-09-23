<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\bulkchange;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class BulkTransfer extends DataConversion
{
    // New structure for API calls handled by
    // the toolkit.
    //
    // index: field name
    // value: location of data to map to this
    //		  field from the original structure
    //
    // example 1:
    //    "cookie" => 'data->cookie'
    //	this will map ->data->cookie in the
    //	original object to ->cookie in the
    //  new format
    //
    // example 2:
    //	  ['attributes']['domain'] = 'data->domain'
    //  this will map ->data->domain in the original
    //  to ->attributes->domain in the new format
    protected $newStructure = array(
        'attributes' => array(
            'reg_username' => 'data->reg_username',
            'reg_domain' => 'data->reg_domain',
            'reg_password' => 'data->reg_password',

            'custom_tech_contact' => 'data->custom_tech_contact',
            'domain_list' => 'data->domain_list',

            'contact_set' => array(
                'owner' => 'personal',
                'admin' => 'personal',
                'billing' => 'personal',
                'tech' => 'personal',
                ),

            'affiliate_id' => 'data->affiliate_id',
            'handle' => 'data->handle',
            'registrant_ip' => 'data->registrant_ip',
            ),
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        if (!is_array($newDataObject->attributes->domain_list)) {
            $newDataObject->attributes->domain_list = explode(
                ',', $newDataObject->attributes->domain_list
                );
        }

        return $newDataObject;
    }
}
