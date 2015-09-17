<?php

namespace OpenSRS\backwardcompatibility\dataconversion\domains\authentication;

use OpenSRS\backwardcompatibility\dataconversion\DataConversion;
use OpenSRS\Exception;

class BulkChange extends DataConversion {
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

			'type' => 'data->type',
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