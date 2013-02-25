<?php

// command: migration_add
// Create a bulk migration job, to copy email from many remote accounts to many local accounts. 	

class MigrationAdd {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("migration_add", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
  		return true;
	}
}
?>