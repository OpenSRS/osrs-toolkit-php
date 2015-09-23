<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\lookup;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class GetDomain extends DataConversion
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
        'cookie' => 'data->cookie',

        'attributes' => array(
            'domain' => 'data->domain',
            'registrant_ip' => 'data->registrant_ip',
            'domain_name' => 'data->domain_name',
            'page' => 'data->page',
            'limit' => 'data->limit',
            'max_to_expiry' => 'data->max_to_expiry',
            'min_to_expiry' => 'data->min_to_expiry',
            'type' => 'data->type',
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
