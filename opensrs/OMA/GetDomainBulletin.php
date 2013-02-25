<?php

// command: change_domain
// Create a new domain or change the attributes of an existing domain. 	

class GetDomainBulletin {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("get_domain_bulletin", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["domain"]) || empty($data["bulletin"]) || empty($data["type"]) ){
			trigger_error("oSRS Error - Domain/Bulletin/Type required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>