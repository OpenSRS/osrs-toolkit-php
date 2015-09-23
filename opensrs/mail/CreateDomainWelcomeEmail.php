<?php

namespace opensrs\mail;

use opensrs\Mail;

class CreateDomainWelcomeEmail extends Mail
{
    public $command = 'create_domain_welcome_email';

    public $_dataObject;
    public $_formatHolder = '';
    public $_osrsm;

    public $resultRaw;
    public $resultFormatted;
    public $resultSuccess;

    public $requiredFields = array(
        'attributes' => array(
            'domain',
            'welcome_text',
            'welcome_subject',
            'from_name',
            'from_address',
            'charset',
            'mime_type',
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
