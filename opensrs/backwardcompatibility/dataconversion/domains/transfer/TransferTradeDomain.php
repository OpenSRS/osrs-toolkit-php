<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\transfer;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class TransferTradeDomain extends DataConversion
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
            'address1' => 'data->address1',
            'city' => 'data->city',
            'country' => 'data->country',
            'domain' => 'data->domain',
            'domain_auth_info' => 'data->domain_auth_info',
            'email' => 'data->email',
            'first_name' => 'data->first_name',
            'last_name' => 'data->last_name',
            'org_name' => 'data->org_name',
            'phone' => 'data->phone',
            'postal_code' => 'data->postal_code',
            'state' => 'data->state',
            'tld_data' => 'data->tld_data',
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
