<?php

namespace opensrs\mail;

use opensrs\Mail;

class SetDomainMailboxLimits extends Mail
{
    public $command = 'set_domain_mailbox_limits';

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
            'mailbox',
            'filter_only',
            'alias',
            'forward_only',
            'mailing_list',
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
