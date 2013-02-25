<?php

// command: restore_deleted_messages
// Recover specific recently deleted messages.  

class RestoreDeletedMessages {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("restore_deleted_messages", $data);
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