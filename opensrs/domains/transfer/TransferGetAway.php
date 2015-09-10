<?php

namespace opensrs\domains\transfer;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class TransferGetAway extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct ($formatString, $dataObject) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject ();
	}

	public function __destruct () {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject (){
		// Execute the command
		$this->_processRequest ();
	}

	// Post validation functions
	private function _processRequest (){
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'GET_TRANSFERS_AWAY',
			'object' => 'domain',
			'attributes' => array ()
		);
		
		// Command optional values
		if (
			isset($this->_dataObject->data->domain) && 
			$this->_dataObject->data->domain != ""
		) {
			$cmd['attributes']['domain'] = $this->_dataObject->data->domain;
		}
		if (
			isset($this->_dataObject->data->gaining_registrar) && 
			$this->_dataObject->data->gaining_registrar != ""
		) {
			$cmd['attributes']['gaining_registrar'] = $this->_dataObject->data->gaining_registrar;
		}
		if (
			isset($this->_dataObject->data->limit) && 
			$this->_dataObject->data->limit != ""
		) {
			$cmd['attributes']['limit'] = $this->_dataObject->data->limit;
		}
		if (
			isset($this->_dataObject->data->owner_confirm_from) && 
			$this->_dataObject->data->owner_confirm_from != ""
		) {
			$cmd['attributes']['owner_confirm_from'] = $this->_dataObject->data->owner_confirm_from;
		}
		if (
			isset($this->_dataObject->data->owner_confirm_ip) && 
			$this->_dataObject->data->owner_confirm_ip != ""
		) {
			$cmd['attributes']['owner_confirm_ip'] = $this->_dataObject->data->owner_confirm_ip;
		}
		if (
			isset($this->_dataObject->data->owner_confirm_to) && 
			$this->_dataObject->data->owner_confirm_to != ""
		) {
			$cmd['attributes']['owner_confirm_to'] = $this->_dataObject->data->owner_confirm_to;
		}
		if (
			isset($this->_dataObject->data->owner_request_from) && 
			$this->_dataObject->data->owner_request_from != ""
		) {
			$cmd['attributes']['owner_request_from'] = $this->_dataObject->data->owner_request_from;
		}
		if (
			isset($this->_dataObject->data->owner_request_to) && 
			$this->_dataObject->data->owner_request_to != ""
		) {
			$cmd['attributes']['owner_request_to'] = $this->_dataObject->data->owner_request_to;
		}
		if (
			isset($this->_dataObject->data->page) && 
			$this->_dataObject->data->page != ""
		) {
			$cmd['attributes']['page'] = $this->_dataObject->data->page;
		}
		if (
			isset($this->_dataObject->data->req_from) && 
			$this->_dataObject->data->req_from != ""
		) {
			$cmd['attributes']['req_from'] = $this->_dataObject->data->req_from;
		}
		if (
			isset($this->_dataObject->data->req_to) && 
			$this->_dataObject->data->req_to != ""
		) {
			$cmd['attributes']['req_to'] = $this->_dataObject->data->req_to;
		}
		if (
			isset($this->_dataObject->data->status) && 
			$this->_dataObject->data->status != ""
		) {
			$cmd['attributes']['status'] = $this->_dataObject->data->status;
		}
		if (
			isset($this->_dataObject->data->registry_request_date) && 
			$this->_dataObject->data->registry_request_date != ""
		) {
			$cmd['attributes']['registry_request_date'] = $this->_dataObject->data->registry_request_date;
		}
		if (
			isset($this->_dataObject->data->request_address) && 
			$this->_dataObject->data->request_address != ""
		) {
			$cmd['attributes']['request_address'] = $this->_dataObject->data->request_address;
		}
		
        // Flip Array to XML
        $xmlCMD = $this->_opsHandler->encode( $cmd );
        // Send XML
        $XMLresult = $this->send_cmd( $xmlCMD );
        // Flip XML to Array
        $arrayResult = $this->_opsHandler->decode( $XMLresult );

		// Results
		$this->resultFullRaw = $arrayResult;
                if (isset($arrayResult['attributes'])){
                    $this->resultRaw = $arrayResult['attributes'];
                } else {
			$this->resultRaw = $arrayResult;
		}
		$this->resultFullFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
	}
}