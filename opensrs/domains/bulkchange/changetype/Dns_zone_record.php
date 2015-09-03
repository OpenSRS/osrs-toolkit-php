<?php

namespace opensrs\domains\bulkchange\changetype;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data - 
 */

class Dns_zone_record extends Base {
	protected $change_type = 'dns_zone_record';
	protected $checkFields = array(
		'dns_action',
		'dns_record_type',
		'dns_record_data'
		);

	public function __construct(){
		parent::__construct();
	}

	public function __deconstruct(){
		parent::__deconstruct();
	}

	public function validateChangeType( $dataObject ){
		foreach( $this->checkFields as $field ) {
			if( !isset($dataObject->data->$field) || !$dataObject->data->$field ) {
				throw new Exception("oSRS Error - change type is {$this->change_type} but $field is not defined.");
			}
		}
		
		return true;
	}

	public function setChangeTypeRequestFields( $dataObject, $requestData ) {
		if(
			isset($dataObject->data->dns_action) &&
			$dataObject->data->dns_action!= ""
		) {
			$requestData['attributes']['dns_action'] = $dataObject->data->dns_action;
		}
		if
			(isset($dataObject->data->dns_record_type) &&
				$dataObject->data->dns_record_type!= ""
		) {
			$requestData['attributes']['dns_record_type'] = $dataObject->data->dns_record_type;
		}
		if(
			isset($dataObject->data->dns_record_data->ip_address) &&
			$dataObject->data->dns_record_data->ip_address!= ""
		) {
			$requestData['attributes']['dns_record_data']['ip_address'] = $dataObject->data->dns_record_data->ip_address;
		}
		if(
			isset($dataObject->data->dns_record_data->subdomain) &&
			$dataObject->data->dns_record_data->subdomain!= ""
		) {
			$requestData['attributes']['dns_record_data']['subdomain'] = $dataObject->data->dns_record_data->subdomain;
		}
		if(
			isset($dataObject->data->dns_record_data->ipv6_address) &&
			$dataObject->data->dns_record_data->ipv6_address!= ""
		) {
			$requestData['attributes']['dns_record_data']['ipv6_address'] = $dataObject->data->dns_record_data->ipv6_address;
		}
		if(
			isset($dataObject->data->dns_record_data->hostname) &&
			$dataObject->data->dns_record_data->hostname!= ""
		) {
			$requestData['attributes']['dns_record_data']['hostname'] = $dataObject->data->dns_record_data->hostname;
		}
		if(
			isset($dataObject->data->dns_record_data->priority) &&
			$dataObject->data->dns_record_data->priority!= ""
		) {
			$requestData['attributes']['dns_record_data']['priority'] = $dataObject->data->dns_record_data->priority;
		}
		if(
			isset($dataObject->data->dns_record_data->weight) &&
			$dataObject->data->dns_record_data->weight!= ""
		) {
			$requestData['attributes']['dns_record_data']['weight'] = $dataObject->data->dns_record_data->weight;
		}
		if(
			isset($dataObject->data->dns_record_data->port) &&
			$dataObject->data->dns_record_data->port!= ""
		) {
			$requestData['attributes']['dns_record_data']['port'] = $dataObject->data->dns_record_data->port;
		}
		if(
			isset($dataObject->data->dns_record_data->text) &&
			$dataObject->data->dns_record_data->text!= ""
		) {
			$requestData['attributes']['dns_record_data']['text'] = $dataObject->data->dns_record_data->text;
		}
		if(isset($dataObject->data->only_if) && $dataObject->data->only_if!= "") {
			$requestData['attributes']['only_if'] = $dataObject->data->only_if;
		}
				
		return $requestData;
	}
}