<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\nameserver;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class NameserverRegistryAdd extends DataConversion
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
            'all' => 'data->all',
            'fqdn' => 'data->fqdn',
            'tld' => 'data->tld',
            ),
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        $newDataObject->attributes->tld = explode(',', $newDataObject->attributes->tld);

        return $newDataObject;
    }
}
