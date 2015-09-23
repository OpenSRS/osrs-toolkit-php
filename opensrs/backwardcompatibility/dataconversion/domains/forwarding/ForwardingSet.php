<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\forwarding;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class ForwardingSet extends DataConversion
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

            'forwarding' => array(
                array(
                    'description' => 'data->description',
                    'destination_url' => 'data->destination_url',
                    'enabled' => 'data->enabled',
                    'keywords' => 'data->keywords',
                    'masked' => 'data->masked',
                    'subdomain' => 'data->subdomain',
                    'title' => 'data->title',
                    ),
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
