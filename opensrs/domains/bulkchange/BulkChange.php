<?php

namespace opensrs\domains\bulkchange;

use opensrs\Base;
use opensrs\Exception;

class BulkChange extends Base
{
    public $action = 'submit_bulk_change';
    public $object = 'bulk_change';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
            'change_items',
            'change_type',
            ),
        );

    protected $changeTypeHandle = null;

    public function __construct($formatString, $dataObject, $returnFullResponse = true, $send = true)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;

        if ($send) {
            $this->_validateObject($dataObject);

            $this->send($dataObject, $returnFullResponse);
        }
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    public function _validateObject($dataObject, $requiredFields = null)
    {
        $parent = new parent();

        $parent->_validateObject($dataObject, $this->requiredFields);

        // run validation for change_type
        $this->validateChangeType($dataObject->attributes->change_type, $dataObject);
    }

    public function getFriendlyClassName($string)
    {
        return preg_replace('/[ ]/', '', ucwords(strtolower(preg_replace('/[^a-z0-9]+/i', ' ', $string))));
    }

    public function loadChangeTypeClass($change_type)
    {
        $changeTypeClassName = $this->getFriendlyClassName($change_type);

        $changeTypeClass = "\\opensrs\\domains\\bulkchange\\changetype\\$changeTypeClassName";

        if (class_exists($changeTypeClass)) {
            return new $changeTypeClass();
        } else {
            Exception::classNotFound($changeTypeClass);
        }
    }

    public function validateChangeType($change_type, $dataObject)
    {
        $changeTypeClass = $this->loadChangeTypeClass($change_type);

        return $changeTypeClass->validateChangeType($dataObject);
    }
}
