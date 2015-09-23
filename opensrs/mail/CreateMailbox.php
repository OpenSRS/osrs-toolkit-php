<?php

namespace opensrs\mail;

use opensrs\Mail;

class CreateMailbox extends Mail
{
    public $command = 'create_mailbox';

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
            'password',
            ),
        );
    public $optionalFields = array(
        'attributes' => array(
            'first_name',
            'last_name',
            'title',
            'phone',
            'fax',
            'timezone',
            'filteronly',
            'spam_tag',
            'spam_folder',
            'spam_level',
            'timezone',
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
