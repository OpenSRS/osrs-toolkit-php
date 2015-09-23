<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\provisioning;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class ProvisioningUpdateAllInfo extends DataConversion
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
            'contact_set' => array(
                'owner' => 'data->owner_contact',
                'admin' => 'data->admin_contact',
                'tech' => 'data->tech_contact',
                'billing' => 'data->billing_contact',
                ),
            'domain' => 'data->domain',

            // generated from data->nameserver_names and
            // data->nameserver_ips
            'nameserver_list' => 'data->nameserver_list',
            ),
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        // run customizations required by this particular class 

        // set custom nameservers to nameserver_list
        if (
            isset($dataObject->data->nameserver_names) &&
            $dataObject->data->nameserver_names != ''
        ) {
            $nameServers = explode(',', $dataObject->data->nameserver_names);

            if (
                    isset($dataObject->data->nameserver_ips) &&
                    $dataObject->data->nameserver_ips != ''
                ) {
                $ipAddresses = explode(',', $dataObject->data->nameserver_ips);
            } else {
                $ipAddresses = array();
            }

            $i = 0;

            $newDataObject->attributes->nameserver_list = array();

            for ($i = 0; $i < count($nameServers); ++$i) {
                $nameserver_obj = new \stdClass();

                $nameserver_obj->fqdn = $nameServers[$i];

                if (isset($ipAddresses[$i])) {
                    $nameserver_obj->fqdn = $ipAddresses[$i];
                }
            }
        }
        // end customizations

        return $newDataObject;
    }
}
