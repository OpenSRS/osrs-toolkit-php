<?php

// command: stats_list
// Retrieve a list of available stats periods, for use with stats_snapshot. 

class StatsList {

	public static function call($data) {
		return OMA::send_cmd("stats_list", $data);
	}

	// Valdation rule here
    public static function validate($data) {
    	return true;
  	}
}
?>