<?php
/*
 *  Required object values:
 *  data -
 */

class mailChangeDomain extends openSRS_mail {
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
		if (!isSet($this->_dataObject->data->admin_username) || $this->_dataObject->data->admin_username == "") {
			if (APP_MAIL_USERNAME == ""){
				trigger_error ("oSRS-eMail Error - username is not defined.", E_USER_WARNING);
				$allPassed = false;
			} else {
				$this->_dataObject->data->admin_username = APP_MAIL_USERNAME;
			}
		}
		if (!isSet($this->_dataObject->data->admin_password) || $this->_dataObject->data->admin_password == "") {
			if (APP_MAIL_PASSWORD == ""){
				trigger_error ("oSRS-eMail Error - password is not defined.", E_USER_WARNING);
				$allPassed = false;
			} else {
				$this->_dataObject->data->admin_password = APP_MAIL_PASSWORD;
			}
		}
		if (!isSet($this->_dataObject->data->admin_domain) || $this->_dataObject->data->admin_domain == "") {
			if (APP_MAIL_DOMAIN == ""){
				trigger_error ("oSRS-eMail Error - authentication domain is not defined.", E_USER_WARNING);
				$allPassed = false;
			} else {
				$this->_dataObject->data->admin_domain = APP_MAIL_DOMAIN;
			}
		}

		// Command required values
		if (!isSet($this->_dataObject->data->domain) || $this->_dataObject->data->domain == "") {
			trigger_error ("oSRS-eMail Error - domain is not defined.", E_USER_WARNING);
			$allPassed = false;
		} else {
			$compile .= " domain=\"". $this->_dataObject->data->domain ."\"";
		}

		// Command optional values
		if (isSet($this->_dataObject->data->language) && $this->_dataObject->data->language != "")
                        $compile .= " language=\"". $this->_dataObject->data->language ."\"";

		if (isSet($this->_dataObject->data->timezone) && $this->_dataObject->data->timezone != "")
                        $compile .= " timezone=\"". $this->_dataObject->data->timezone ."\"";

		if (isSet($this->_dataObject->data->filtermx) && $this->_dataObject->data->filtermx != "")
                        $compile .= " filtermx=\"". $this->_dataObject->data->filtermx ."\"";

		if (isSet($this->_dataObject->data->spam_tag) && $this->_dataObject->data->spam_tag != "")
                        $compile .= " spam_tag=\"". $this->_dataObject->data->spam_tag ."\"";

		if (isSet($this->_dataObject->data->spam_folder) && $this->_dataObject->data->spam_folder != "")
                        $compile .= " spam_folder=\"". $this->_dataObject->data->spam_folder ."\"";

		if (isSet($this->_dataObject->data->spam_level) && $this->_dataObject->data->spam_level != "")
                        $compile .= " spam_level=\"". $this->_dataObject->data->spam_level ."\"";


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
			1 => "login user=\"". $this->_dataObject->data->admin_username ."\" domain=\"". $this->_dataObject->data->admin_domain ."\" password=\"". $this->_dataObject->data->admin_password ."\"",
			2 => "change_domain". $command,
			3 => "quit"
		);
		$tucRes = $this->makeCall($sequence);
		$arrayResult = $this->parseResults($tucRes);

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = $this->convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
	}
}
