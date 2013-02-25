<?php

// command: restore_deleted_contact
// Restore deleted contacts for a user 

class RestoreDeletedContacts {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("restore_deleted_contacts", $data);
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