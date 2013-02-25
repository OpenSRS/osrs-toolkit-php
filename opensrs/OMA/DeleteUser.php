<?php

// command: delete_user
// Delete a user. Once a user is deleted this user will no longer be able to receive mail or access the system in any way. 

class DeleteUser {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("delete_user", $data);
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