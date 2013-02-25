<?php

// command: set_role
// Assigns a role to the specified user, removing any previous role. Roles give users administration rights over users, domains, etc. 

class SetRole {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("set_role", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["user"]) || empty($data["role"]) || empty($data["object"])){
			trigger_error("oSRS Error - User/Role/Object required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>