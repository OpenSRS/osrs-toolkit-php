<?php

namespace OpenSRS\trust;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  - none -
 *
 *  Optional Data:
 *  data - owner_email, admin_email, billing_email, tech_email, del_from, del_to, exp_from, exp_to, page, limit
 */

class ParseCSR extends Base
{
    protected $action = 'parse_csr';
    protected $object = 'trust_service';

    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public function __construct($formatString, $dataObject, $returnFullResults = null)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $this->_validateObject($dataObject);

        $this->send($dataObject, $returnFullResults);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    public function _validateObject($dataObject)
    {
        if (!isset($dataObject->data->csr)) {
            throw new Exception('oSRS Error - csr is not defined.');
        }

        if (!isset($dataObject->data->product_type)) {
            throw new Exception('oSRS Error - product_type is not defined.');
        }
    }
}
