<?php

// command: migration_trace
// Retrieve detailed information about a single user in a current or historical migration job. 

class MigrationTrace {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("migration_trace", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data['job']) || empty($data['user']) ){
			trigger_error("oSRS Error - Job/User required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>