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

class ProcessPending extends Base
{
    protected $action = 'process_pending';
    protected $object = 'trust_service';

    private $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public function __construct($formatString, $dataObject, $returnFullResponse = true)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $this->_validateObject($dataObject);

        $this->send($dataObject, $returnFullResponse);
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    public function _validateObject($dataObject)
    {
        if (!isset($dataObject->data->order_id)) {
            throw new Exception('oSRS Error - order_id is not defined.');
        }
    }
}
