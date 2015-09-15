<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

class ProvisioningUpdateAllInfo extends Base {
	public $action = "update_all_info";
	public $object = "domain";

	public $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public $contactRequiredFields = array(
		"first_name",
		"last_name",
		"org_name",
		"address1",
		"city",
		"state",
		"country",
		"postal_code",
		"phone",
		"email",
		"lang_pref"
		);

	public function __construct( $formatString, $dataObject, $returnFullResponse = true ) {
		parent::__construct();

		$this->_formatHolder = $formatString;

		$this->_validateObject( $dataObject );

		$this->send( $dataObject, $returnFullResponse );
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	public function _validateObject( $dataObject ) {
		// Command required values
		if(
			!isset( $dataObject->attributes->domain ) ||
			$dataObject->attributes->domain  == ""
		) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}

		if(
			!isset( $dataObject->attributes->contact_set->owner_contact ) ||
			!$dataObject->attributes->contact_set->owner_contact
		) {
			throw new Exception( "oSRS Error - owner_contact is not defined." );
		}
		if(
			!isset( $dataObject->attributes->contact_set->admin_contact ) ||
			!$dataObject->attributes->contact_set->admin_contact
		) {
			throw new Exception( "oSRS Error - admin_contact is not defined." );
		}
		if(
			!isset( $dataObject->attributes->contact_set->tech_contact ) ||
			!$dataObject->attributes->contact_set->tech_contact
		) {
			throw new Exception( "oSRS Error - tech_contact in is not defined." );
		}
		if(
			!isset( $dataObject->attributes->contact_set->billing_contact ) ||
			!$dataObject->attributes->contact_set->billing_contact
		) {
			throw new Exception( "oSRS Error - billing_contact is not defined." );
		}

		// make sure contact fields are all sent
		$this->checkContactFields( $dataObject->attributes->contact_set );

		if(
			!isset( $dataObject->attributes->nameserver_names ) ||
			$dataObject->attributes->nameserver_names  == ""
		) {
			throw new Exception( "oSRS Error - The function requires at least one nameserver is provided." );
		}

		//Check there are the samenumber of Nameserver IP values are there are  Nameserver Name values
		if(
			isset( $dataObject->attributes->nameserver_ips ) &&
			$dataObject->attributes->nameserver_ips  != ""
		) {
			if(
				count( explode(",",$dataObject->attributes->nameserver_ips )) !=
				count( explode(",",$dataObject->attributes->nameserver_names ))
			) {
				throw new Exception( "oSRS Error - The function requires the same number of Nameserver IP addresses as Nameserver names if you are defining Nameserver IP addresses." );
			}
		}
	}

	private function checkContactFields( $contact ) {
		// Check Contact information
		$contact_types = array(
			'owner_contact',
			'admin_contact',
			'tech_contact',
			'billing_contact'
			);
		for( $contact_type = 0; $contact_type < count( $contact_types ); $contact_type++ ){
			for( $i = 0; $i < count($this->contactRequiredFields); $i++ ) {
				if(
					!isset($contact->{$contact_types[$contact_type]}->{$this->contactRequiredFields[$i]}) ||
					$contact->{$contact_types[$contact_type]}->{$this->contactRequiredFields[$i]} == ""
				) {
					throw new Exception( "oSRS Error -  ". $this->contactRequiredFields[$i] ." is not defined in {$contact_types[$contact_type]} contact set." );
				}
			}
		}
	}
}
