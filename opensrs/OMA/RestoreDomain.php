<?php

class RestoreDomain {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("restore_domain", $data);
    	}
	}

    public static function validate($data) {
    	if(empty($data['domain']) || empty($data['id']) || empty($data['new_name'])){
			trigger_error("oSRS Error - Domain/ID/New Namerequired\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>