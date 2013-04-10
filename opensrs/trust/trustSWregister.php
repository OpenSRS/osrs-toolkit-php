<?php
/*
 *  Required object values:
 *  data - 
 */
 
class trustSWregister extends openSRS_base {
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
		$allPassed = true;

		$allPassed = $this->_allTimeRequired ();
		// Run the command
		if ($allPassed) {
			// Execute the command			
			$this->_processRequest ();
		} else {			
			trigger_error ("oSRS Error - Incorrect call.", E_USER_WARNING);
		}
	} // end of private function _validateObject()

	// Personal Information
	private function _allTimeRequired(){
		$subtest = true;
		
		// $reqPers = array ("first_name", "last_name", "org_name", "address1", "city", "state", "country", "postal_code", "phone", "email");
		// 	for ($i = 0; $i < count($reqPers); $i++){
		// 		if ($this->_dataObject->personal->$reqPers[$i] == "") {
		// 			trigger_error ("oSRS Error - ". $reqPers[$i] ." is not defined.", E_USER_WARNING);
		// 			$subtest = false;
		// 		}
		// 	}
		
		$reqData = array ("reg_type", "product_type");
		for ($i = 0; $i < count($reqData); $i++){
			if ($this->_dataObject->data->$reqData[$i] == "") {
				trigger_error ("oSRS Error - ". $reqData[$i] ." is not defined.", E_USER_WARNING);
				$subtest = false;
			}
		}
		
		return $subtest;
	}
	
	// Post validation functions
	private function _processRequest (){		
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'SW_REGISTER',
			'object' => 'trust_service',
			'attributes' => array( 
				'reg_type' => $this->_dataObject->data->reg_type,
				'product_type' => $this->_dataObject->data->product_type,
				'contact_set' => array(
					'organization' => $this->_createUserData(),
					'admin' => $this->_createUserData(),
					'billing' => $this->_createUserData(),
					'tech' => $this->_createUserData(),
					'signer' => $this->_createUserData()
				)
			)
		);
		// Command optional values
		if (isSet($this->_dataObject->data->special_instructions) && $this->_dataObject->data->special_instructions != "") $cmd['attributes']['special_instructions'] = $this->_dataObject->data->special_instructions;
		if (isSet($this->_dataObject->data->seal_in_search) && $this->_dataObject->data->seal_in_search != "") $cmd['attributes']['seal_in_search'] = $this->_dataObject->data->seal_in_search;
		if (isSet($this->_dataObject->data->server_type) && $this->_dataObject->data->server_type != "") $cmd['attributes']['server_type'] = $this->_dataObject->data->server_type;
		if (isSet($this->_dataObject->data->trust_seal) && $this->_dataObject->data->trust_seal != "") $cmd['attributes']['trust_seal'] = $this->_dataObject->data->trust_seal;
		if (isSet($this->_dataObject->data->period) && $this->_dataObject->data->period != "") $cmd['attributes']['period'] = $this->_dataObject->data->period;
		if (isSet($this->_dataObject->data->approver_email) && $this->_dataObject->data->approver_email != "") $cmd['attributes']['approver_email'] = $this->_dataObject->data->approver_email;
		if (isSet($this->_dataObject->data->domain) && $this->_dataObject->data->domain != "") $cmd['attributes']['domain'] = $this->_dataObject->data->domain;
		if (isSet($this->_dataObject->data->csr) && $this->_dataObject->data->csr != "") $cmd['attributes']['csr'] = $this->_dataObject->data->csr;
		if (isSet($this->_dataObject->data->server_count) && $this->_dataObject->data->server_count != "") $cmd['attributes']['server_count'] = $this->_dataObject->data->server_count;
		if (isSet($this->_dataObject->data->handle) && $this->_dataObject->data->handle != "") $cmd['attributes']['handle'] = $this->_dataObject->data->handle;

		
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
	
	private function _createUserData(){
		$userArray = array(
			"first_name" => $this->_dataObject->personal->first_name,
			"last_name" => $this->_dataObject->personal->last_name,
			"org_name" => $this->_dataObject->personal->org_name,
			"address1" => $this->_dataObject->personal->address1,
			"address2" => $this->_dataObject->personal->address2,
			"address3" => $this->_dataObject->personal->address3,
			"title" => $this->_dataObject->personal->title,
			"city" => $this->_dataObject->personal->city,
			"state" => $this->_dataObject->personal->state,
			"postal_code" => $this->_dataObject->personal->postal_code,
			"country" => $this->_dataObject->personal->country,
			"phone" => $this->_dataObject->personal->phone,
			"fax" => $this->_dataObject->personal->fax,
			"email" => $this->_dataObject->personal->email,
		);
		return $userArray;
	}
}