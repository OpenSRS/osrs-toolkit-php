<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\subreseller;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class SubresellerCreate extends DataConversion
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
            'ccp_enabled' => 'data->ccp_enabled',
            'low_balance_email' => 'data->low_balance_email',
            'nameservers' => 'data->nameservers',
            'password' => 'data->password',
            'payment_email' => 'data->payment_email',
            'pricing_plan' => 'data->pricing_plan',
            'status' => 'data->status',
            'system_status_email' => 'data->system_status_email',
            'url' => 'data->url',
            'username' => 'data->username',

            'contact_set' => array(
                'owner' => 'personal',
                'admin' => 'admin',
                'billing' => 'billing',
                'tech' => 'tech',
                ),
            ),
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        return $newDataObject;
    }
}
