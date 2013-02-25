<?php

// command: restore_user
// Restore a deleted user 

class RestoreUser {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("restore_user", $data);
    	}
	}

    public static function validate($data) {
    	if(empty($data['user']) || empty($data['id']) || empty($data['new_name'])){
			trigger_error("oSRS Error - User/ID/New Namerequired\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>