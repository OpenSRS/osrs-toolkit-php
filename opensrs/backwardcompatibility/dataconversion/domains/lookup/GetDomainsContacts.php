<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\lookup;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class GetDomainsContacts extends DataConversion
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
            // Handling this one manually below
            // as it needs to be exploded into 
            // an array using ',' as the delimiter
            // 'domain_list' => 'data->domain_list',
            ),
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        // set attributes->domain_list
        if (!is_object($newDataObject->attributes)) {
            $newDataObject->attributes = new \stdClass();
        }
        $newDataObject->attributes->domain_list = explode(',', $dataObject->data->domain_list);

        return $newDataObject;
    }
}
