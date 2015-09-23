<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\lookup;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class GetDeletedDomains extends DataConversion
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
            'owner_email' => 'data->owner_email',
            'admin_email' => 'data->admin_email',
            'billing_email' => 'data->billing_email',
            'tech_email' => 'data->tech_email',
            'del_from' => 'data->del_from',
            'del_to' => 'data->del_to',
            'exp_from' => 'data->exp_from',
            'exp_to' => 'data->exp_to',
            'page' => 'data->page',
            'limit' => 'data->limit',
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
