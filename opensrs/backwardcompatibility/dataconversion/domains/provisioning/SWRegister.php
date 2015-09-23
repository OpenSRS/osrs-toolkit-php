<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\provisioning;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class SWRegister extends DataConversion
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
            'change_contact' => 'data->change_contact',
            'comments' => 'data->comments',
            'contact_set' => array(
                'owner' => 'data->personal',
                'admin' => 'data->personal',
                'billing' => 'data->personal',
                'tech' => 'data->personal',
                ),
            'custom_nameservers' => 'data->custom_nameservers',
            'custom_transfer_nameservers' => 'data->custom_transfer_nameservers',
            'custom_tech_contact' => 'data->custom_tech_contact',
            'dns_template' => 'data->dns_template',
            'domain' => 'data->domain',
            'encoding_type' => 'data->encoding_type',
            'f_lock_domain' => 'data->f_lock_domain',
            'f_parkp' => 'data->f_parkp',
            'f_whois_privacy' => 'data->f_whois_privacy',
            'handle' => 'data->handle',
            'Intended_use' => 'data->Intended_use',
            'link_domains' => 'data->link_domains',
            'master_order_id' => 'data->master_order_id',

            // if data->custom_nameservers == 1, nameserver_list
            // is populated with data->name1, data->name2 etc
            // up to max potential data->name10
            // 'nameserver_list' => 'data->nameserver_list',
            'owner_confirm_address' => 'data->owner_confirm_address',
            'period' => 'data->period',
            'premium_price_to_verify' => 'data->premium_price_to_verify',
            'reg_domain' => 'data->reg_domain',
            'reg_username' => 'data->reg_username',
            'reg_password' => 'data->reg_password',
            'reg_type' => 'data->reg_type',
            'tld_data' => 'data->tld_data',
            'trademark_smd' => 'data->trademark_smd',

            'legal_type' => 'data->legal_type',
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
        if (isset($dataObject->data)) {
            if ($dataObject->data->custom_nameservers == 1) {
                $newDataObject->attributes->nameserver_list = array();

                for ($j = 1; $j <= 10; ++$j) {
                    $tns = 'name'.$j;
                    $tso = 'sortorder'.$j;

                    if (
                        isset($dataObject->data->$tns) &&
                        $dataObject->data->$tns != '' &&
                        isset($dataObject->data->$tso) &&
                        $dataObject->data->$tso
                    ) {
                        $nameserver = new \stdClass();
                        $nameserver->name = $dataObject->data->{$tns};
                        $nameserver->sortorder = $dataObject->data->{$tso};

                        $newDataObject->attributes->nameserver_list[] = $nameserver;
                    }
                }
            }
        }

        if (isset($dataObject->personal)) {
            $newDataObject->attributes->contact_set = new \stdClass();
            $newDataObject->attributes->contact_set->owner = $dataObject->personal;
            $newDataObject->attributes->contact_set->admin = $dataObject->personal;
            $newDataObject->attributes->contact_set->billing = $dataObject->personal;
            $newDataObject->attributes->contact_set->tech = $dataObject->personal;
        }
        // end customizations

        return $newDataObject;
    }
}
