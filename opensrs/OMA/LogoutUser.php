<?php

// command: logout_user
// Terminate all IMAP and POP sessions the user has active 

class LogoutUser {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("logout_user", $data);
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