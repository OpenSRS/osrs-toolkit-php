<?php

// command: migration_status
// Get detailed information about the progress and results of a migration job.  	
class MigrationStatus {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("migration_status", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data['job'])){
			trigger_error("oSRS Error - Job required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>
