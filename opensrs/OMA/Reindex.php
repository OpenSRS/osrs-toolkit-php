<?php

// command: reindex
// Reindexes a user's mail folder(s) 

class Reindex {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("reindex", $data);
    	}
	}

    public static function validate($data) {
    	if(empty($data['user']) || empty($data['id']) || empty($data["folder"])){
			trigger_error("oSRS Error - User/IDs required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>