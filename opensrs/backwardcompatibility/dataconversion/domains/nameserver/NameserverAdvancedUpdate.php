<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\nameserver;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class NameserverAdvancedUpdate extends DataConversion
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
            'add_ns' => 'data->add_ns',
            'assign_ns' => 'data->assign_ns',
            'domain' => 'data->domain',
            'op_type' => 'data->op_type',
            'remove_ns' => 'data->remove_ns',
            ),
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        /*
         * Convert fields that should be arrays to arrays
         */
        if (isset($newDataObject->attributes->add_ns)) {
            $newDataObject->attributes->add_ns = explode(',', $newDataObject->attributes->add_ns);
        }
        if (isset($newDataObject->attributes->assign_ns)) {
            $newDataObject->attributes->assign_ns = explode(',', $newDataObject->attributes->assign_ns);
        }
        if (isset($newDataObject->attributes->remove_ns)) {
            $newDataObject->attributes->remove_ns = explode(',', $newDataObject->attributes->remove_ns);
        }

        return $newDataObject;
    }
}
