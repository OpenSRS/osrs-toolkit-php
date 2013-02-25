<?php

// command: get_user
// Retrieve the settings and other information for a user 

class GetUser {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("get_user", $data);
    	}
	}

    public static function validate($data) {
    	if(empty($data['user'])){
			trigger_error("oSRS Error - User required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>