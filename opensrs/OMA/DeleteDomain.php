<?php

// command: get_user
// Retrieve the settings and other information for a user

class DeleteDomain {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("delete_domain", $data);
    	}
	}

    public static function validate($data) {
    	if(empty($data['domain'])){
			trigger_error("oSRS Error - Domain required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>