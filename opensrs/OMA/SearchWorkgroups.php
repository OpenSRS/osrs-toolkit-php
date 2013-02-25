<?php

// command: search_workgroup
// Retrieve a list of workgroups in a domain. 	

class SearchWorkgroups {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("search_workgroups", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["criteria"]["domain"])){
			trigger_error("oSRS Error - Domain required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>