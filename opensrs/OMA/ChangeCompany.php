<?php

// command: change_company
// Change the attributes of an existing company. 

class ChangeCompany {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("change_company", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["company"])){
			trigger_error("oSRS Error - Company required\n", E_USER_WARNING);	
		} else {
			return true;	
		}
  	}
}
?>