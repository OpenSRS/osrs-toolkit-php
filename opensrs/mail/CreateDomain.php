<?php

namespace opensrs\mail;

use opensrs\Mail;

class CreateDomain extends Mail
{
    public $command = 'create_domain';

    public $_dataObject;
    public $_formatHolder = '';
    public $_osrsm;

    public $resultRaw;
    public $resultFormatted;
    public $resultSuccess;

    public $requiredFields = array(
        'attributes' => array(
            'domain',
            ),
        );
    public $optionalFields = array(
        'attributes' => array(
            'language',
            'timezone',
            'filtermx',
            'spam_tag',
            'spam_folder',
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
