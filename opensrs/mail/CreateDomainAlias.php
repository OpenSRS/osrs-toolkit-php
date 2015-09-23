<?php

namespace opensrs\mail;

use opensrs\Mail;

class CreateDomainAlias extends Mail
{
    public $command = 'create_domain_alias';

    public $_dataObject;
    public $_formatHolder = '';
    public $_osrsm;

    public $resultRaw;
    public $resultFormatted;
    public $resultSuccess;

    public $requiredFields = array(
        'attributes' => array(
            'domain',
            'alias',
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
