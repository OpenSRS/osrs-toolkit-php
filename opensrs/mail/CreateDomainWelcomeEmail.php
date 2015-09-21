<?php

namespace OpenSRS\mail;

use OpenSRS\Mail;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - 
 */

class CreateDomainWelcomeEmail extends Mail
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
        if (!isset($this->_dataObject->data->admin_username) || $this->_dataObject->data->admin_username == '') {
            if (APP_MAIL_USERNAME == '') {
                throw new Exception('oSRS-eMail Error - admin_username is not defined.');
                $allPassed = false;
            } else {
                $this->_dataObject->data->admin_username = APP_MAIL_USERNAME;
            }
        }
        if (!isset($this->_dataObject->data->admin_password) || $this->_dataObject->data->admin_password == '') {
            if (APP_MAIL_PASSWORD == '') {
                throw new Exception('oSRS-eMail Error - admin_password is not defined.');
                $allPassed = false;
            } else {
                $this->_dataObject->data->admin_password = APP_MAIL_PASSWORD;
            }
        }
        if (!isset($this->_dataObject->data->admin_domain) || $this->_dataObject->data->admin_domain == '') {
            if (APP_MAIL_DOMAIN == '') {
                throw new Exception('oSRS-eMail Error - admin_domain is not defined.');
                $allPassed = false;
            } else {
                $this->_dataObject->data->admin_domain = APP_MAIL_DOMAIN;
            }
        }

        // Command required values
        if (!isset($this->_dataObject->data->domain) || $this->_dataObject->data->domain == '') {
            throw new Exception('oSRS-eMail Error - domain is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' domain="'.$this->_dataObject->data->domain.'"';
        }
        if (!isset($this->_dataObject->data->welcome_text) || $this->_dataObject->data->welcome_text == '') {
            throw new Exception('oSRS-eMail Error - welcome_text is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' welcome_text="'.$this->_dataObject->data->welcome_text.'"';
        }
        if (!isset($this->_dataObject->data->welcome_subject) || $this->_dataObject->data->welcome_subject == '') {
            throw new Exception('oSRS-eMail Error - welcome_subject is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' welcome_subject="'.$this->_dataObject->data->welcome_subject.'"';
        }
        if (!isset($this->_dataObject->data->from_name) || $this->_dataObject->data->from_name == '') {
            throw new Exception('oSRS-eMail Error - from_name is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' from_name="'.$this->_dataObject->data->from_name.'"';
        }
        if (!isset($this->_dataObject->data->from_address) || $this->_dataObject->data->from_address == '') {
            throw new Exception('oSRS-eMail Error - from_address is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' from_address="'.$this->_dataObject->data->from_address.'"';
        }
        if (!isset($this->_dataObject->data->charset) || $this->_dataObject->data->charset == '') {
            throw new Exception('oSRS-eMail Error - charset is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' charset="'.$this->_dataObject->data->charset.'"';
        }
        if (!isset($this->_dataObject->data->mime_type) || $this->_dataObject->data->mime_type == '') {
            throw new Exception('oSRS-eMail Error - mime_type is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' mime_type="'.$this->_dataObject->data->mime_type.'"';
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
            1 => 'login user="'.$this->_dataObject->data->admin_username.'" domain="'.$this->_dataObject->data->admin_domain.'" password="'.$this->_dataObject->data->admin_password.'"',
            2 => 'create_domain_welcome_email'.$command,
            3 => 'quit',
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
