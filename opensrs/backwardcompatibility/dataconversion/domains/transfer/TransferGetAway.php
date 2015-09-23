<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\transfer;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class TransferGetAway extends DataConversion
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
            'domain' => 'data->domain',
            'gaining_registrar' => 'data->gaining_registrar',
            'limit' => 'data->limit',
            'owner_confirm_from' => 'data->owner_confirm_from',
            'owner_confirm_to' => 'data->owner_confirm_to',
            'owner_request_from' => 'data->owner_request_from',
            'owner_request_to' => 'data->owner_request_to',
            'page' => 'data->page',
            'req_from' => 'data->req_from',
            'req_to' => 'data->req_to',
            'request_address' => 'data->request_address',
            'status' => 'data->status',
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
