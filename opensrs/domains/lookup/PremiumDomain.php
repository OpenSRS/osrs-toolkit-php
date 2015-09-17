<?php

namespace opensrs\domains\lookup;

use OpenSRS\Base;
use OpenSRS\Exception;

class PremiumDomain extends Base {
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
        if (
            !isset($dataObject->attributes->searchstring) ||
            !$dataObject->attributes->searchstring
        ) {
            throw new Exception('oSRS Error - searchstring is not defined.');
        }
    }

    public function customResponseHandling( $arrayResult, $returnFullResponse = true ){
        if( !$returnFullResponse ){
            if (isset($arrayResult['attributes'])){
                $resultRaw = array();

                if(isset($arrayResult['attributes']['premium']['items'])){
                    $resultRaw['premium'] = $arrayResult['attributes']['premium']['items'];
                }

                $arrayResult = $resultRaw;
            }
        }

        return $arrayResult;
    }
}
