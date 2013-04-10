<?php
/*
 *  Required object values:
 *  data - 
 */
 
class xxx extends openSRS_mail {
	private $_dataObject;
	private $_formatHolder = "";
	private $_osrsm;
	
	public $resultRaw;
	public $resultFormatted;
	public $resultSuccess;

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
		$compile = "";
		
		// Command required values - authentication
		if (!isSet($this->_dataObject->data->username) || $this->_dataObject->data->username == "") {
			trigger_error ("oSRS-eMail Error - username is not defined.", E_USER_WARNING);
			$allPassed = false;
		}
		if (!isSet($this->_dataObject->data->password) || $this->_dataObject->data->password == "") {
			trigger_error ("oSRS-eMail Error - password is not defined.", E_USER_WARNING);
			$allPassed = false;
		}
		if (!isSet($this->_dataObject->data->authdomain) || $this->_dataObject->data->authdomain == "") {
			trigger_error ("oSRS-eMail Error - authentication domain is not defined.", E_USER_WARNING);
			$allPassed = false;
		}
				
		// Command required values
		if (!isSet($this->_dataObject->data->xxx) || $this->_dataObject->data->xxx == "") {
			trigger_error ("oSRS-eMail Error - xxx is not defined.", E_USER_WARNING);
			$allPassed = false;
		} else {
			$compile .= " xxx=\"". $this->_dataObject->data->xxx ."\"";
		}
		
		// Command optional values
		if (isSet($this->_dataObject->data->xxx) || $this->_dataObject->data->xxx != "") $compile .= " xxx=\"". $this->_dataObject->data->xxx ."\"";
		
		// Run the command
		if ($allPassed) {
			// Execute the command
			$this->_processRequest ($compile);
		} else {
			trigger_error ("oSRS-eMail Error - Missing data.", E_USER_WARNING);
		}
	}
	
	// Post validation functions
	private function _processRequest ($command = ""){
		$sequence = array (
			0 => "ver ver=\"3.4\"",
			1 => "login user=\"". $this->_dataObject->data->username ."\" domain=\"". $this->_dataObject->data->authdomain ."\" password=\"". $this->_dataObject->data->password ."\"",
			2 => "xxx". $command,
			3 => "quit"
		);		
		$tucRes = $this->makeCall($sequence);
		$arrayResult = $this->parseResults($tucRes);
		
		// Results
		$this->resultRaw = $arrayResult;
		$this->resultFormatted = convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
		$this->resultSuccess = $this->makeCheck ($arrayResult);
	}
}