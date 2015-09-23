<?php

namespace opensrs\mail;

use opensrs\Mail;

class CreateMailboxForwardOnly extends Mail
{
    public $command = 'create_mailbox_forward_only';

    public $_dataObject;
    public $_formatHolder = '';
    public $_osrsm;

    public $resultRaw;
    public $resultFormatted;
    public $resultSuccess;

    public $requiredFields = array(
        'attributes' => array(
            'domain',
            'workgroup',
            'mailbox',
            'forward_email',
            ),
        );
    public $optionalFields = array(
        'attributes' => array(
            'spam_level',
            ),
        );

    public function __construct($formatString, $dataObject)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $command = $this->getCommand($dataObject);

        $this->send($dataObject, $command);
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
