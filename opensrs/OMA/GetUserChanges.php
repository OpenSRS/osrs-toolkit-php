<?php

// command: get_user_changes
// Get historical values for an attribute for a user. 

class GetUserChanges {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("get_user_changes", $data);
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