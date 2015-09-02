<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

class LookupDomain extends Base {
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
		if (empty($this->_dataObject->data->cookie) && empty($this->_dataObject->data->domain) ) {
			throw new Exception( "oSRS Error - cookie and domain are not defined." );
		}
		
		if (empty($this->_dataObject->data->type)) {
			throw new Exception( "oSRS Error - type is not defined." );
		}
		
		// Execute the command
		$this->_processRequest ();
	}

	// Post validation functions
	private function _processRequest (){
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'get',
			'object' => 'domain',
			'attributes' => array (
				'type' => $this->_dataObject->data->type
				)
			);
		
		if (isset($this->_dataObject->data->cookie) && $this->_dataObject->data->cookie != "") $cmd['cookie'] = $this->_dataObject->data->cookie;
		if (isset($this->_dataObject->data->domain) && $this->_dataObject->data->domain != "") $cmd['domain'] = $this->_dataObject->data->domain;
		if (isset($this->_dataObject->data->registrant_ip) && $this->_dataObject->data->registrant_ip != "") $cmd['registrant_ip'] = $this->_dataObject->data->registrant_ip;
		
		// Command optional values
		if (isset($this->_dataObject->data->limit) && $this->_dataObject->data->limit != "") $cmd['attributes']['limit'] = $this->_dataObject->data->limit;
		if (isset($this->_dataObject->data->domain) && $this->_dataObject->data->domain != "") $cmd['attributes']['domain_name'] = $this->_dataObject->data->domain;
		if (isset($this->_dataObject->data->page) && $this->_dataObject->data->page != "") $cmd['attributes']['page'] = $this->_dataObject->data->page;
		if (isset($this->_dataObject->data->max_to_expiry) && $this->_dataObject->data->max_to_expiry != "") $cmd['attributes']['max_to_expiry'] = $this->_dataObject->data->max_to_expiry;
		if (isset($this->_dataObject->data->min_to_expiry) && $this->_dataObject->data->min_to_expiry != "") $cmd['attributes']['min_to_expiry'] = $this->_dataObject->data->min_to_expiry;
		
		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML
		$arrayResult = $this->_opsHandler->decode($XMLresult);		// Flip XML to Array

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
	}
}
