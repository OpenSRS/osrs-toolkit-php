<?php

class xxx extends openSRS_mail
{
    private $_dataObject;
    private $_formatHolder = '';
    private $_osrsm;

    public $resultRaw;
    public $resultFormatted;
    public $resultSuccess;

    public function __construct($formatString, $dataObject)
    {
        parent::__construct();

        $this->_dataObject = $dataObject;
        $this->_formatHolder = $formatString;
        $this->_validateObject();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    private function _validateObject()
    {
        $allPassed = true;
        $compile = '';

        // Command required values - authentication
        if (!isset($this->_dataObject->data->username) || $this->_dataObject->data->username == '') {
            throw new Exception('oSRS-eMail Error - username is not defined.');
            $allPassed = false;
        }
        if (!isset($this->_dataObject->data->password) || $this->_dataObject->data->password == '') {
            throw new Exception('oSRS-eMail Error - password is not defined.');
            $allPassed = false;
        }
        if (!isset($this->_dataObject->data->authdomain) || $this->_dataObject->data->authdomain == '') {
            throw new Exception('oSRS-eMail Error - authentication domain is not defined.');
            $allPassed = false;
        }

        // Command required values
        if (!isset($this->_dataObject->data->xxx) || $this->_dataObject->data->xxx == '') {
            throw new Exception('oSRS-eMail Error - xxx is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' xxx="'.$this->_dataObject->data->xxx.'"';
        }

        // Command optional values
        if (isset($this->_dataObject->data->xxx) || $this->_dataObject->data->xxx != '') {
            $compile .= ' xxx="'.$this->_dataObject->data->xxx.'"';
        }

        // Run the command
        if ($allPassed) {
            // Execute the command
            $this->_processRequest($compile);
        } else {
            throw new Exception('oSRS-eMail Error - Missing data.');
        }
    }

    // Post validation functions
    private function _processRequest($command = '')
    {
        $sequence = array(
            0 => 'ver ver="3.4"',
            1 => 'login user="'.$this->_dataObject->data->username.'" domain="'.$this->_dataObject->data->authdomain.'" password="'.$this->_dataObject->data->password.'"',
            2 => 'xxx'.$command,
            3 => 'quit',
        );
        $tucRes = $this->makeCall($sequence);
        $arrayResult = $this->parseResults($tucRes);

        // Results
        $this->resultRaw = $arrayResult;
        $this->resultFormatted = convertArray2Formatted($this->_formatHolder, $this->resultRaw);
        $this->resultSuccess = $this->makeCheck($arrayResult);
    }
}
