<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

class LookupDomain extends Base {
    public $action = "name_suggest";
    public $object = "domain";

    public $_formatHolder = "";
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public function __construct( $formatString, $dataObject, $returnFullResponse = true ) {
        parent::__construct();

        $this->_formatHolder = $formatString;

        $this->_validateObject( $dataObject );

        $this->send( $dataObject, $returnFullResponse );
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    // Validate the object
    public function _validateObject( $dataObject )
    {
        // search domain must be defined
        if (!isset($dataObject->attributes->searchstring)) {
            throw new Exception('oSRS Error - searchstring is not defined.');
        }
    }
}
