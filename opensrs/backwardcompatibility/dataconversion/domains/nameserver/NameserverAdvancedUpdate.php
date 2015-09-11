<?php

namespace OpenSRS\backwardcompatibility\dataconversion\domains\nameserver;

use OpenSRS\backwardcompatibility\dataconversion\DataConversion;
use OpenSRS\Exception;

class NameserverAdvancedUpdate extends DataConversion {
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

	public function convertDataObject( $dataObject, $newStructure = null ) {
		$p = new parent();

		if(is_null($newStructure)){
			$newStructure = $this->newStructure;
		}

		$newDataObject = $p->convertDataObject( $dataObject, $newStructure );

		return $newDataObject;
	}
}