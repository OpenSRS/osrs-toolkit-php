<?php

// command: change_domain
// Create a new domain or change the attributes of an existing domain. 	

class ChangeDomain {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("change_domain", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["domain"])){
			trigger_error("oSRS Error - Domain required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>