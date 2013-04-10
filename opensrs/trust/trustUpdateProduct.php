<?php
/*
 *  Required object values:
 *  data - 
 */
 
class trustUpdateProduct extends openSRS_base {
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

	private function _validateObject (){
		$allPassed = true;
		
		if (!isSet($this->_dataObject->data->product_id)) {
			trigger_error ("oSRS Error - product_id is not defined.", E_USER_WARNING);
			$allPassed = false;
		}

		// Run the command
		if ($allPassed) {
			// Execute the command
			$this->_processRequest ();
		} else {
			trigger_error ("oSRS Error - Incorrect call.", E_USER_WARNING);
		}
	}
	
	// Post validation functions
	private function _processRequest (){		
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'update_product',
			'object' => 'trust_service',
			'attributes' => array( 
				'product_id' => $this->_dataObject->data->product_id
			)
		);
		
		// Command optional values
		if (isSet($this->_dataObject->data->contact_email) && $this->_dataObject->data->contact_email != "") $cmd['attributes']['contact_email'] = $this->_dataObject->data->contact_email;
		if (isSet($this->_dataObject->data->seal_in_search) && $this->_dataObject->data->seal_in_search != "") $cmd['attributes']['seal_in_search'] = $this->_dataObject->data->seal_in_search;
		if (isSet($this->_dataObject->data->trust_seal) && $this->_dataObject->data->trust_seal != "") $cmd['attributes']['trust_seal'] = $this->_dataObject->data->trust_seal;

		
		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML
		$arrayResult = $this->_opsHandler->decode($XMLresult);		// Flip XML to Array

		// Results
		$this->resultFullRaw = $arrayResult;
		if (isSet($arrayResult['attributes'])){
			$this->resultRaw = $arrayResult['attributes'];
		} else {
			$this->resultRaw = $arrayResult;
		}
		$this->resultFullFormatted = convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
		$this->XMLresult = $XMLresult;
	}
	
}
