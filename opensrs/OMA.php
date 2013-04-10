<?php

/**
 * OpenSRS OMA (OpenSRS Mail provisioning API) class
 *
 * @package     OpenSRS
 * @subpackage  OMA
 * @since       3.3
 */

class OMA {

	function __construct($opt=array()){}
	
	/**
	* A wrapper method to send a command to the server
	*
	* @param 	string 	$meth  	A name of the OMA method
	* @param 	hash	$req 	Containing header key/value pairs
	*  
	* @return 	hash 	$res 	Containing header key/value pairs
	* @since   3.3
	*/	
	public static function send_cmd($meth, $req){
		$res = OMA::call($meth, $req);
		return $res;
	}
	
	/**
	* Method to send a command to the server using CURL
	*
	* @param 	string 	$method  	A name of the OMA method
	* @param 	hash	$request 	Containing header key/value pairs
	*  
	* @return 	hash 	$response 	Containing header key/value pairs
	* @since   	3.3
	*/	
	private static function call($method, $request){

		$data = array(
			"credentials" => array (
				"user" => MAIL_USERNAME,
	   			"password" => MAIL_PASSWORD,
	   			"client" => MAIL_CLIENT
			)
		);

		if(isset($request["token"])){
			unset($data["credentials"]["password"]);
			$data["credentials"]["token"] = $request["token"];
		}

		if(isset($request)) $data += $request;
		$data_string = json_encode($data);                                                                                   
		
		$ch = curl_init(MAIL_HOST . "/api/{$method}");                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

		//When in test/dev mode, comment out the followings,
		if(strtolower(MAIL_ENV) != "live") {
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                    
		$response = curl_exec($ch);

		if(curl_errno($ch)) {
    		trigger_error('Curl error: ' . curl_error($ch));
		}
		curl_close($ch);

		return $response;
	}

}
