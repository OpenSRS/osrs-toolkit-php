<?php

// command: get_deleted_messages
// Retrieve a list of recoverable deleted emails belonging to a user  	

class GetDeletedMessages {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("get_deleted_messages", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["user"])){
			trigger_error("oSRS Error - User required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>