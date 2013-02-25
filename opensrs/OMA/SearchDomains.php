<?php

// command: search_domains
// Retrieve a list of domains in a company. 

class SearchDomains {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("search_domains", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["criteria"]["company"])){
			trigger_error("oSRS Error - Company required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>