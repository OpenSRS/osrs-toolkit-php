<?php

// command: get_user_messages
// Get a list of user messages in a folder. 

class GetUserMessages {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("get_user_messages", $data);
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