<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\bulkchange;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class BulkChange extends DataConversion
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
            // this has to be exploded into an array,
            // handled below
            'change_items' => 'data->change_items',

            'change_type' => 'data->change_type',
            'op_type' => 'data->op_type',

            'apply_to_locked_domains' => 'data->apply_to_locked_domains',
            'contact_email' => 'data->contact_email',
            'apply_to_all_reseller_items' => 'data->apply_to_all_reseller_items',

            'apply_to_domains' => 'data->apply_to_domains',
            'dns_action' => 'data->dns_action',
            'dns_template' => 'data->dns_template',
            'only_if' => 'data->only_if',
            'force_dns_nameservers' => 'data->force_dns_nameservers',

            'dns_record_type' => 'data->dns_record_type',
            'dns_record_data' => 'data->dns_record_data',

            // array of contacts to update, setting this
            // manually below as requires exploding 
            // data->type and building array based on that
            // 'contacts' => array(
            // 	array('type' => '', 'set' => '')
            // 	),

            // these ones have to be exploded into arrays
            // using ',' as the delimiter
            'add_ns' => 'data->add_ns',
            'remove_ns' => 'data->remove_ns',
            'assign_ns' => 'data->assign_ns',

            'period' => 'data->period',
            'let_expire' => 'data->let_expire',
            'auto_renew' => 'data->auto_renew',
            'affiliate_id' => 'data->affiliate_id',

            'gaining_reseller_username' => 'data->gaining_reseller_username',
            ),
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

        // explode change_items into an array
        // if it isn't already
        if (!is_array($newDataObject->attributes->change_items)) {
            $newDataObject->attributes->change_items = explode(
                ',', $newDataObject->attributes->change_items
                );
        }

        // build attributes->contacts array.
        // data->type is the contact_type,
        // data->personal is the contact record
        if (
            isset($dataObject->data->type) && $dataObject->data->type != '' &&
            isset($dataObject->personal) && $dataObject->personal != ''
        ) {
            $newDataObject->attributes->contacts = array();

            $contact_types = explode(',', $dataObject->data->type);

            foreach ($contact_types as $i => $contact_type) {
                $contact = new \stdClass();

                $contact->set = $dataObject->personal;
                $contact->type = $contact_type;

                $newDataObject->attributes->contacts[] = $contact;

                unset($contact);
            }
        }

        // explode *_ns fields into arrays if they exist
        // and are not already arrays
        if (
            isset($newDataObject->attributes->add_ns) &&
            !is_array($newDataObject->attributes->add_ns)
        ) {
            $newDataObject->attributes->add_ns = explode(
                ',', $newDataObject->attributes->add_ns
                );
        }
        if (
            isset($newDataObject->attributes->remove_ns) &&
            !is_array($newDataObject->attributes->remove_ns)
        ) {
            $newDataObject->attributes->remove_ns = explode(
                ',', $newDataObject->attributes->remove_ns
                );
        }
        if (
            isset($newDataObject->attributes->assign_ns) &&
            !is_array($newDataObject->attributes->assign_ns)
        ) {
            $newDataObject->attributes->assign_ns = explode(
                ',', $newDataObject->attributes->assign_ns
                );
        }

        return $newDataObject;
    }
}
