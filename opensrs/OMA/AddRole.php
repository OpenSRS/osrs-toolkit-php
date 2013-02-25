<?php

// command: add_role
// Add a role to a user.

class AddRole {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("add_role", $data);
    	}
	}

    public static function validate($data) {
    	$roles = array("company", "domain", "mail", "workgroup");
    	if(empty($data["role"]) || !in_array($data["role"], $roles))	{
    		trigger_error("oSRS Error - No role found\n");
    		return false;
    	}
    	if(empty($data['user']) || empty($data['object']) ){
			trigger_error("oSRS Error - User/Role/Object required\n", E_USER_WARNING);
			return false;
		} 	
		return true;
  	}
}
?>