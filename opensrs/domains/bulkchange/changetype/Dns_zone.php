<?php

namespace opensrs\domains\bulkchange\changetype;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class Dns_zone extends Base {
	protected $change_type = 'dns_zone';
	protected $checkFields = array(
		'apply_to_domains',
		'dns_action'
		);

	public function __construct() {
		parent::__construct();
	}

	public function __deconstruct() {
		parent::__deconstruct();
	}

	public function validateChangeType( $dataObject ) {
		foreach( $this->checkFields as $field ) {
			if( !isset( $dataObject->data->$field ) || !$dataObject->data->$field ) {
				throw new Exception( "oSRS Error - change type is {$this->change_type} but $field is not defined." );
			}
		}

		return true;
	}

	public function setChangeTypeRequestFields( $dataObject, $requestData ) {
		if(
			isset( $dataObject->data->apply_to_domains ) &&
			$dataObject->data->apply_to_domains!= "") {
			$requestData['attributes']['apply_to_domains'] = $dataObject->data->apply_to_domains;
		}
		if(
			isset( $dataObject->data->dns_action ) &&
			$dataObject->data->dns_action!= ""
		) {
			$requestData['attributes']['dns_action'] = $dataObject->data->dns_action;
		}
		if(
			isset( $dataObject->data->dns_template ) &&
			$dataObject->data->dns_template!= ""
		) {
			$requestData['attributes']['dns_template'] = $dataObject->data->dns_template;
		}
		if(
			isset( $dataObject->data->only_if ) &&
			$dataObject->data->only_if!= ""
		) {
			$requestData['attributes']['only_if'] = $dataObject->data->only_if;
		}
		if(
			isset( $dataObject->data->force_dns_nameservers ) &&
			$dataObject->data->force_dns_nameservers!= ""
		) {
			$requestData['attributes']['force_dns_nameservers'] = $dataObject->data->force_dns_nameservers;
		}

		return $requestData;
	}
}