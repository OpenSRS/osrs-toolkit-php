<?php

// command: generate_token
// Generate a temporary login token for a user. 

class GenerateToken {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("generate_token", $data);
    	}
	}

    public static function validate($data) {
    	if(empty($data['user']) || empty($data['reason'])){
			trigger_error("oSRS Error - User/Reason required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>