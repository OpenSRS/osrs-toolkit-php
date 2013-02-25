<?php

// command: post_company_bulletin
// Send a bulletin to all users in all domains in the domain. 

class PostCompanyBulletin {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("post_company_bulletin", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["company"]) || empty($data["bulletin"]) || empty($data["type"]) ){
			trigger_error("oSRS Error - Company/Bulletin/Type required\n", E_USER_WARNING);	
		} else {
			if (! in_array(strtolower($data['type']), array('auto', 'manual'))) {
				trigger_error("oSRS Error - Type supports auto or manual only\n", E_USER_WARNING);	
			}	
			return true;
		}
  	}
}
?>