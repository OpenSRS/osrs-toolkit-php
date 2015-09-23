<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\provisioning;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class ProvisioningRenew extends DataConversion
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
            'affiliate_id' => 'data->affiliate_id',
            'auto_renew' => 'data->auto_renew',
            'currentexpirationyear' => 'data->currentexpirationyear',
            'domain' => 'data->domain',
            'f_parkp' => 'data->f_parkp',
            'handle' => 'data->handle',
            'period' => 'data->period',
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
