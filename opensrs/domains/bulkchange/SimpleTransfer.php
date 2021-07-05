<?php

namespace opensrs\domains\bulkchange;

use opensrs\Base;

class SimpleTransfer extends Base
{
    public $action = 'simple_transfer';
    public $object = 'domain';

    public $_formatHolder = '';
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    public $requiredFields = array(
        'attributes' => array(
	        	'domain_list',
		    	'domain_name',
		    	'auth_info',
            ),
        );

    public function __construct($formatString, $dataObject, $returnFullResponse = true)
    {
        parent::__construct();

        $this->_formatHolder = $formatString;
        
        if(empty($dataObject->attributes->domain_list)){//if it's empty, lets try populate with the individual domain so it works.
	        $dataObject->attributes->domain_list = array(
		        array(
	            	'domain_name'	=>	$dataObject->attributes->domain_name,
					'auth_info'		=>	$dataObject->attributes->auth_info
            	)
	        );
        }

        $this->_validateObject($dataObject);

        $this->send($dataObject, $returnFullResponse);
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
