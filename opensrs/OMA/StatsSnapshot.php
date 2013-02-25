<?php

// command: stats_snapshot
// Generate a URL that a stats snapshot can be downloaded from. Note URLs are only valid for 15 minutes after generation. 

class StatsSnapshot {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("stats_snapshot", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["type"]) || empty($data["object"]) || empty($data["date"]) ){
			trigger_error("oSRS Error - Company required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>