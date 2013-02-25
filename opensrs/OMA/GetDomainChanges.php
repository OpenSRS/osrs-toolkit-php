<?php

// command: get_domain_changes
// Retrieve a summary of changes to a domain 

class GetDomainChanges {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("get_domain_changes", $data);
    	}
	}

    public static function validate($data) {
    	if(empty($data['domain'])){
			trigger_error("oSRS Error - Domain required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>