<?php

namespace opensrs\mail;

use opensrs\Mail;

class GetCompanyDomains extends Mail
{
    public $command = 'get_company_domains';

    public $_dataObject;
    public $_formatHolder = '';
    public $_osrsm;

    public $resultRaw;
    public $resultFormatted;
    public $resultSuccess;

    public $optionalFields = array(
        'attributes' => array(
            'limit',
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
