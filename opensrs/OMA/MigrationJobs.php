<?php

// command: migration_jobs
// Retrieve a list of a user's current and historical migration jobs.  	
class MigrationJobs {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("migration_jobs", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data['user'])){
			trigger_error("oSRS Error - User required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>