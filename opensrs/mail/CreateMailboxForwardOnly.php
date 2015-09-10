<?php

namespace OpenSRS\mail;

use OpenSRS\Mail;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data - 
 */

class CreateMailboxForwardOnly extends Mail
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
                throw new Exception('oSRS-eMail Error - username is not defined.');
                $allPassed = false;
            } else {
                $this->_dataObject->data->admin_username = APP_MAIL_USERNAME;
            }
        }
        if (!isset($this->_dataObject->data->admin_password) || $this->_dataObject->data->admin_password == '') {
            if (APP_MAIL_PASSWORD == '') {
                throw new Exception('oSRS-eMail Error - password is not defined.');
                $allPassed = false;
            } else {
                $this->_dataObject->data->admin_password = APP_MAIL_PASSWORD;
            }
        }
        if (!isset($this->_dataObject->data->admin_domain) || $this->_dataObject->data->admin_domain == '') {
            if (APP_MAIL_DOMAIN == '') {
                throw new Exception('oSRS-eMail Error - authentication domain is not defined.');
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

        if (!isset($this->_dataObject->data->workgroup) || $this->_dataObject->data->workgroup == '') {
            throw new Exception('oSRS-eMail Error - workgroup is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' workgroup="'.$this->_dataObject->data->workgroup.'"';
        }

        if (!isset($this->_dataObject->data->mailbox) || $this->_dataObject->data->mailbox == '') {
            throw new Exception('oSRS-eMail Error - mailbox is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' mailbox="'.$this->_dataObject->data->mailbox.'"';
        }

        if (!isset($this->_dataObject->data->forward_email) || $this->_dataObject->data->forward_email == '') {
            throw new Exception('oSRS-eMail Error - forwarding email is not defined.');
            $allPassed = false;
        } else {
            $compile .= ' forward_email="'.$this->_dataObject->data->forward_email.'"';
        }

        // Command optional values
        if (isset($this->_dataObject->data->spam_level) && $this->_dataObject->data->spam_level != '') {
            $compile .= ' spam_level="'.$this->_dataObject->data->spam_level.'"';
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
            2 => 'create_mailbox_forward_only'.$command,
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
