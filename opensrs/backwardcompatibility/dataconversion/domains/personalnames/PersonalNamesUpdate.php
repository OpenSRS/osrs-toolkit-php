<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\personalnames;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class PersonalNamesUpdate extends DataConversion
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
            'dnsRecords' => array(
                'content' => 'data->content',
                'name' => 'data->name',
                'type' => 'data->type',
                ),
            'domain' => 'data->domain',
            'mailbox' => array(
                'disable_forward_email' => 'data->disable_forward_email',
                'forward_email' => 'data->forward_email',
                'mailbox_type' => 'data->mailbox_type',
                'password' => 'data->password',
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
