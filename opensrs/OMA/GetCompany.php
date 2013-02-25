<?php

// command: get_company
// Retrieve settings and other information for a company 

class GetCompany {

	public static function call($data) {
		if (self::validate($data)) {
    		return OMA::send_cmd("get_company", $data);
    	}
	}

    public static function validate($data) {
    	if(empty($data['company'])){
			trigger_error("oSRS Error - Company required\n", E_USER_WARNING);	
		} else {
			return true;
		}
  	}
}
?>