<?php

namespace OpenSRS\mail;

use OpenSRS\Mail;
use OpenSRS\Exception;

class Authentication extends Mail
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
    public function _validateObject( $dataObject = array() ) 
    {
        $compile = '';

        // Command required values - authentication
        if (!isset($this->_dataObject->attributes->admin_username) || $this->_dataObject->attributes->admin_username == '') {
            if (APP_MAIL_USERNAME == '') {
                Exception::notDefined( "admin_username" );
            } else {
                $this->_dataObject->attributes->admin_username = APP_MAIL_USERNAME;
            }
        }
        if (!isset($this->_dataObject->attributes->admin_password) || $this->_dataObject->attributes->admin_password == '') {
            if (APP_MAIL_PASSWORD == '') {
                Exception::notDefined( "admin_password" );
            } else {
                $this->_dataObject->attributes->admin_password = APP_MAIL_PASSWORD;
            }
        }
        if (!isset($this->_dataObject->attributes->admin_domain) || $this->_dataObject->attributes->admin_domain == '') {
            if (APP_MAIL_DOMAIN == '') {
                Exception::notDefined( "admin_domain" );
            } else {
                $this->_dataObject->attributes->admin_domain = APP_MAIL_DOMAIN;
            }
        }

        // Execute the command
        $this->_processRequest($compile);
    }

    // Post validation functions
    private function _processRequest($command = '')
    {
        $sequence = array(
            0 => 'ver ver="3.4"',
            1 => 'login user="'.$this->_dataObject->attributes->admin_username.'" domain="'.$this->_dataObject->attributes->admin_domain.'" password="'.$this->_dataObject->attributes->admin_password.'"',
            2 => 'quit',
        );
        $tucRes = $this->makeCall($sequence);
        $arrayResult = $this->parseResults($tucRes);

        // Results
        $this->resultFullRaw = $arrayResult;
        $this->resultRaw = $arrayResult;
        $this->resultFullFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultFullRaw);
        $this->resultFormatted = $this->convertArray2Formatted($this->_formatHolder, $this->resultRaw);
    }
}
