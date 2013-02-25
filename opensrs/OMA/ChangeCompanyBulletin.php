<?php

// command: change_company_bulletin
// Create, edit or delete a company bulletin. 	

class ChangeCompanyBulletin {

	public static function call($data) {
		if (self::validate($data)){
    		return OMA::send_cmd("change_company_bulletin", $data);
    	}
	}

	// Valdation rule here
    public static function validate($data) {
    	if(empty($data["company"]) || empty($data["bulletin"]) || empty($data["type"]) || empty($data["bulletin_text"])){
			trigger_error("oSRS Error - Domain/Bulletin/Type/Bulletin Text required\n", E_USER_WARNING);	
		} else {
			if (! in_array(strtolower($data['type']), array('auto', 'manual'))) {
				trigger_error("oSRS Error - Type supports auto or manual only\n", E_USER_WARNING);
			}
			return true;
		}
  	}
}
?>