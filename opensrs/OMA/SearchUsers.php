<?php

// command: search_users
// Retrieve a list of users in a domain. 

class SearchUsers {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("search_users", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["criteria"]["domain"])){
			trigger_error("oSRS Error - Domain required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>