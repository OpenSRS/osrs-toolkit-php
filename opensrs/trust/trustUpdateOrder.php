<?php
/*
 *  Required object values:
 *  data - 
 */
 
class trustUpdateOrder extends openSRS_base {
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
		
		if (!isSet($this->_dataObject->data->order_id)) {
			trigger_error ("oSRS Error - order_id is not defined.", E_USER_WARNING);
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
			'action' => 'update_order',
			'object' => 'trust_service',
			'attributes' => array( 
				'order_id' => $this->_dataObject->data->order_id
			)
		);
		
		// Command optional values
		if (isSet($this->_dataObject->data->product_type) && $this->_dataObject->data->product_type != "") $cmd['attributes']['product_type'] = $this->_dataObject->data->product_type;
		// reg_type => SiteLock ONLY
		if (isSet($this->_dataObject->data->reg_type) && $this->_dataObject->data->reg_type != "") $cmd['attributes']['reg_type'] = $this->_dataObject->data->reg_type;

		if (isSet($this->_dataObject->data->special_instructions) && $this->_dataObject->data->special_instructions != "") $cmd['attributes']['special_instructions'] = $this->_dataObject->data->special_instructions;
		if (isSet($this->_dataObject->data->server_type) && $this->_dataObject->data->server_type != "") $cmd['attributes']['server_type'] = $this->_dataObject->data->server_type;
		if (isSet($this->_dataObject->data->period) && $this->_dataObject->data->period != "") $cmd['attributes']['period'] = $this->_dataObject->data->period;
		if (isSet($this->_dataObject->data->approver_email) && $this->_dataObject->data->approver_email != "") $cmd['attributes']['approver_email'] = $this->_dataObject->data->approver_email;
		if (isSet($this->_dataObject->data->csr) && $this->_dataObject->data->csr != "") $cmd['attributes']['csr'] = $this->_dataObject->data->csr;
		if (isSet($this->_dataObject->data->server_count) && $this->_dataObject->data->server_count != "") $cmd['attributes']['server_count'] = $this->_dataObject->data->server_count;


		
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
