<?php

// command: move_user_messages
// Move user messages to a different folder. 

class MoveUserMessages {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("move_user_messages", $data);
    	}
	}

    public static function validate($data) {
    	if(empty($data['user']) || empty($data['ids'])){
			trigger_error("oSRS Error - User/IDs required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>