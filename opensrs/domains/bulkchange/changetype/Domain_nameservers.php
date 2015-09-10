<?php

namespace opensrs\domains\bulkchange\changetype;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class Domain_nameservers extends Base {
	protected $change_type = 'domain_nameservers';
	protected $checkFields = array(
		'op_type'
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

		if( !isset($dataObject->data->add_ns ) && $dataObject->data->add_ns == "" &&
		!isset( $dataObject->data->remove_ns ) && $dataObject->data->remove_ns == "" &&
		!isset( $dataObject->data->assign_ns ) && $dataObject->data->assign_ns == "" ) {

			throw new Exception( "oSRS Error - change type is {$this->change_type} but at least one of add_ns, remove_ns or assign_ns has to be defined." );
		}

		return true;
	}

	public function setChangeTypeRequestFields( $dataObject, $requestData ) {
		if(
			isset( $dataObject->data->op_type ) &&
			$dataObject->data->op_type!= ""
		) {
			$requestData['attributes']['op_type'] = $dataObject->data->op_type;
		}
		if(
			isset( $dataObject->data->add_ns ) &&
			$dataObject->data->add_ns!= ""
		) {
			$requestData['attributes']['add_ns'] = explode( ",",$dataObject->data->add_ns );
		}
		if(
			isset( $dataObject->data->remove_ns ) &&
			$dataObject->data->remove_ns!= ""
		) {
			$requestData['attributes']['remove_ns'] = explode( ",",$dataObject->data->remove_ns );
		}
		if(
			isset( $dataObject->data->assign_ns ) &&
			$dataObject->data->assign_ns!= ""
		) {
			$requestData['attributes']['assign_ns'] = explode( ",",$dataObject->data->assign_ns );
		}

		return $requestData;
	}
}