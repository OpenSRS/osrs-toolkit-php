<?php

namespace opensrs\backwardcompatibility\dataconversion\domains\bulkchange;

use opensrs\backwardcompatibility\dataconversion\DataConversion;

class SimpleTransfer extends DataConversion
{
    // New structure for API calls handled by
    // the toolkit.
    //
    // index: field name
    // value: location of data to map to this
    //		  field from the original structure
    //
    // example 1:
    //    "cookie" => 'data->cookie'
    //	this will map ->data->cookie in the
    //	original object to ->cookie in the
    //  new format
    //
    // example 2:
    //	  ['attributes']['domain'] = 'data->domain'
    //  this will map ->data->domain in the original
    //  to ->attributes->domain in the new format
    protected $newStructure = array(
        'attributes' => array(
	        'domain_list' 	=> 'data->domain_list',
	        'domain_name'	=> 'data->domain_name',
	        'auth_info'		=> 'data->auth_info',
	        
	        'reg_domain' 	=> 'data->reg_domain',
            'reg_username' 	=> 'data->reg_username',
            'reg_password' 	=> 'data->reg_password',
            
            'nameserver_list' => 'data->nameserver_list',
            'dns_template' => 'data->dns_template'
            )
        );

    public function convertDataObject($dataObject, $newStructure = null)
    {
        $p = new parent();

        if (is_null($newStructure)) {
            $newStructure = $this->newStructure;
        }

        $newDataObject = $p->convertDataObject($dataObject, $newStructure);

		if(isset($newDataObject->attributes->domain_name)){
	        if (!is_array($newDataObject->attributes->domain_list)) {
	            $newDataObject->attributes->domain_list = array(//domain list can't be empty, so fill it with the single domain we have.
	            	array(
		            	'domain_name' =>	$newDataObject->attributes->domain_name,
						'auth_info'	=>	$newDataObject->attributes->auth_info
	            	)
	            );
	        }
        }

        return $newDataObject;
    }
}
