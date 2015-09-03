<?php

namespace opensrs\domains\bulkchange;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - 
 */
 
class BulkChange extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	protected $changeTypeHandle = null;

	public function __construct ($formatString, $dataObject) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject(){
		// Command required values
		if(!isset($this->_dataObject->data->change_items) || $this->_dataObject->data->change_items == "") {
			throw new Exception("oSRS Error - change_items is not defined.");
		}

		if(!isset($this->_dataObject->data->change_type) || $this->_dataObject->data->change_type == "") {
			throw new Exception("oSRS Error - change_type is not defined.");
		}

		// Execute the command
		$this->_processRequest();
	}

	public function getFriendlyClassName( $string ){
		return ucwords(strtolower(preg_replace("/[^a-z0-9]+/i", "_", $string)));
	}

	public function loadChangeTypeClass( $change_type ){
		$changeTypeClassName = $this->getFriendlyClassName( $change_type );

		$changeTypeClass = '\OpenSRS\domains\bulkchange\changetype\\' . $changeTypeClassName;

		if(class_exists($changeTypeClass)){
			$this->changeTypeHandle = new $changeTypeClass();
		}
		else {
			throw new Exception( "The class $changeTypeClass does not exist or cannot be found" );
		}
	}

	public function validateChangeType( $string ){
		if(null === $this->changeTypeHandle){
			$this->loadChangeTypeClass( $string );
		}

		return $this->changeTypeHandle->validateChangeType( $this->_dataObject );
	}

	public function setChangeTypeRequestFields( $string, $requestData ) {
		if(null === $this->changeTypeHandle){
			$this->loadChangeTypeClass( $string );
		}

		return $this->changeTypeHandle->setChangeTypeRequestFields( $this->_dataObject, $requestData );
	}

	// Post validation functions
	private function _processRequest (){
		$this->_dataObject->data->change_items = explode (",", $this->_dataObject->data->change_items);
	
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'submit_bulk_change',
			'object' => 'bulk_change',
			'attributes' => array (
				'change_type' => $this->_dataObject->data->change_type,
				'change_items' => $this->_dataObject->data->change_items
			)
		);
		
		// Command optional values
		if(
			isset($this->_dataObject->data->apply_to_locked_domains) &&
			$this->_dataObject->data->apply_to_locked_domains != ""
		) {
			$cmd['attributes']['apply_to_locked_domains'] = $this->_dataObject->data->apply_to_locked_domains;
		}
		if(
			isset($this->_dataObject->data->contact_email) &&
			$this->_dataObject->data->contact_email != ""
		) {
			$cmd['attributes']['contact_email'] = $this->_dataObject->data->contact_email;
		}
		if(
			isset($this->_dataObject->data->apply_to_all_reseller_items) &&
			$this->_dataObject->data->apply_to_all_reseller_items!= ""
		) {
			$cmd['attributes']['apply_to_all_reseller_items'] = $this->_dataObject->data->apply_to_all_reseller_items;
		}

		$cmd = $this->setChangeTypeRequestFields( $this->_dataObject->data->change_type, $cmd );
	
		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode($cmd);
		// Send XML
		$XMLresult = $this->send_cmd($xmlCMD);
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode($XMLresult);		

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
	}

	private function _createUserData(){
		$userArray = array(
			"first_name" => $this->_dataObject->personal->first_name,
			"last_name" => $this->_dataObject->personal->last_name,
			"org_name" => $this->_dataObject->personal->org_name,
			"address1" => $this->_dataObject->personal->address1,
			"address2" => $this->_dataObject->personal->address2,
			"address3" => $this->_dataObject->personal->address3,
			"city" => $this->_dataObject->personal->city,
			"state" => $this->_dataObject->personal->state,
			"postal_code" => $this->_dataObject->personal->postal_code,
			"country" => $this->_dataObject->personal->country,
			"phone" => $this->_dataObject->personal->phone,
			"fax" => $this->_dataObject->personal->fax,
			"email" => $this->_dataObject->personal->email,
			"url" => $this->_dataObject->personal->url,
			"lang_pref" => $this->_dataObject->personal->lang_pref
		);

		return $userArray;
	}
}
