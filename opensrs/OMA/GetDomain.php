<?php

// command: get_domain
// Retrieve settings and other information for a domain 

class GetDomain {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("get_domain", $data);
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