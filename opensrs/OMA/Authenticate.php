<?php

// command: authenticate
// Authenticate a user's credentials. 

class Authenticate {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("authenticate", $data);
    	}
	}

    public static function validate($data) {
    	return true;
  	}
}
?>