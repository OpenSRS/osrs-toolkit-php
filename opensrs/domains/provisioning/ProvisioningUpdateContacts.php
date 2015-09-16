<?php

namespace opensrs\domains\provisioning;

use OpenSRS\Base;
use OpenSRS\Exception;

class ProvisioningUpdateContacts extends Base {
    public $action = "update_contacts";
    public $object = "domain";

    public $_formatHolder = "";
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

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
        if(
            !isset($dataObject->attributes->domain) ||
            !$dataObject->attributes->domain
        ) {
            throw new Exception( "oSRS Error - domain is not defined." );
        }

        if(
            !isset($dataObject->attributes->types) ||
            !$dataObject->attributes->types
        ) {
            throw new Exception( "oSRS Error - types is not defined." );
        }

        $tld = explode( '.', $dataObject->attributes->domain, 2 );

        // .NL doesn't require state, others do
        if( $tld == "nl" ) {
            $reqPers = array( "first_name", "last_name", "org_name", "address1", "city", "country", "postal_code", "phone", "email", "lang_pref" );
        } else {
            $reqPers = array( "first_name", "last_name", "org_name", "address1", "city", "state", "country", "postal_code", "phone", "email", "lang_pref" );
        }

        $contact_types = array( 'owner', 'admin', 'tech', 'billing' );

        for( $c = 0; $c < count($contact_types); $c++) {
            $contact_type = $contact_types[$c];

            if(!isset($dataObject->attributes->contact_set->$contact_type)){
                    throw new Exception( "oSRS Error - $contact_type is not defined." );
            }

    		for( $i = 0; $i < count($reqPers); $i++ ) {
    			if(
                    !isset($dataObject->attributes->contact_set->$contact_type->{$reqPers[$i]}) ||
                    $dataObject->attributes->contact_set->$contact_type->{$reqPers[$i]} == ""
                ) {
    				throw new Exception( "oSRS Error - ". $reqPers[$i] ." is not defined." );
    			}
    		}

        }
	}
}