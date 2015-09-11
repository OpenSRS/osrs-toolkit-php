<?php

namespace OpenSRS\backwardcompatibility\dataconversion\domains\authentication;

use OpenSRS\backwardcompatibility\dataconversion\DataConversion;
use OpenSRS\Exception;

class BulkSubmit extends DataConversion {
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
			'change_type' => 'data->change_type',

			'apply_to_all_' => 'data->reseller_items',
			'apply_to_locked_domains' => 'data->apply_to_locked_domains',
			'change_items' => 'data->change_items',
			'contact_email' => 'data->contact_email',

			// change_type = dns_zone
			'apply_to_domains' => 'data->apply_to_domains',
			'dns_action' => 'data->dns_action',
			'dns_template' => 'data->dns_template',
			'only_if' => 'data->only_if',
			'force_dns_nameservers' => 'data->force_dns_nameservers',

			// change_type = dns_zone_record
			'dns_action' => 'data->dns_action',
			'dns_record_type' => 'data->dns_record_type',
			'dns_record_data' => array(
				'A' => 'data->a', // ip_address/subdomain
				'AAAA' => 'data->aaaa', // ipv6_address / subdomain
				'CNAME' => 'data->cname', // hostname /  subdomain
				'MX' => 'data->mx', // priority / hostname / subdomain
				'SRV' => 'data->srv', // priority / weight / subdomain / hostname / port
				'TXT' => 'txt', // subdomain / text
				),
			'only_if' => 'data->only_if',

			// change_type = domain_contacts
			'contacts' => 'data->contacts',
			'set' => 'data->set',
			'type' => 'data->type'

			// change_type = domain_forwarding
			'change_items' => 'data->change_items',
			'op_type' => 'data->op_type',
			
			),
		);

	public function convertDataObject( $dataObject, $newStructure = null ) {
		$p = new parent();

		if(is_null($newStructure)){
			$newStructure = $this->newStructure;
		}

		$newDataObject = $p->convertDataObject( $dataObject, $newStructure );

		return $newDataObject;
	}
}