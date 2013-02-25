<?php
class openSRS_mail {

	// Class constructor
	public function __construct () {
	}

	// Class destructor
	public function __destruct () {
	}

	// Class functions
	public function makeCall ($sequence){
		$result = '';
		// Open the socket
		// $fp = fsockopen ($this->osrs_host, $this->osrs_port, $errno, $errstr, $this->osrs_portwait);
		$fp = pfsockopen (APP_MAIL_HOST, APP_MAIL_PORT, $errno, $errstr, APP_MAIL_PORTWAIT);

		if (!$fp) {
			trigger_error ("oSRS Error - $errstr ($errno)<br />\n");			// Something went wrong
		} else {
			// Send commands to APP server
			for ($i=0; $i<count($sequence); $i++){
				$servCatch = "";
			
				// Write the port
				$writeStr = $sequence[$i] ."\r\n";
				$fwrite = fwrite($fp, $writeStr);
				if (!$fwrite) 
					trigger_error("oSRS - Mail System Write Error, please check if your network allows connection to the server.");

				$dotStr = ".\r\n";
				$fwrite = fwrite($fp, $dotStr);
				if (!$fwrite)
					trigger_error ("oSRS - Mail System Write Error, please check if your network allows connection to the server.");
								
							// read the port rightaway
				// Last line of command has be done with different type of reading
				if ($i == (count($sequence)-1) ){
					// Loop until End of transmission
					while (!feof($fp)) {
						$servCatch .= fgets($fp, 128);
					}
				} else {
					// Plain buffer read with big data packet
					$servCatch .= fread($fp, 8192);
				}
				
				// Possible parsing and additional validation will be here
				// If error accours in the communication than the script should quit rightaway
				// $servCatch
				
				$result .= $servCatch;
			}
		}

		//Close the socket
		fclose($fp);
		return $result;
	}

	public function parseResults ($resString) {
		// Raw tucows result
		$resArray = explode (".\r\n",$resString);
		$resRinse = array ();
		for ($i=0; $i<count($resArray); $i++){							// Clean up \n, \r and empty fields
			$resArray[$i] = str_replace("\r", "", $resArray[$i]);
			$resArray[$i] = str_replace("\n", " ", $resArray[$i]);		// replace new line with space
			$resArray[$i] = str_replace("  ", " ", $resArray[$i]);		// no double space - for further parsing
			$resArray[$i] = substr($resArray[$i], 0, -1);				// take out the last space
			if ($resArray[$i] != "") array_push($resRinse, $resArray[$i]);
		}
    $result=Array(
			"is_success" => "1",
			"response_code" => "200",
			"response_text" => "Command completed successfully"
		);
		$i=1;
		// Takes the rinsed result lines and forms it into an Associative array
		foreach($resRinse as $resultLine){
			$okPattern='/^OK 0/';
			$arrayPattern = '/ ([\w\-\.\@]+)\=\"([\w\-\.\@\*\, ]*)\"/';
			$errorPattern = '/^ER ([0-9]+) (.+)$/';

			// Checks to see if this line is an information line
			$okLine = preg_match($okPattern, $resultLine, $matches);

	                if ($okLine == 0){
				// If it's not an ok line, it's an error
				$err_num_match=0;
	                        $err_num_match = preg_match($errorPattern,$resultLine,$err_match);

				// Makes sure the error pattern matched and that there isn't an error that has already happened
				if ($err_num_match==1 && $result['is_success']=="1"){
					$result['response_text']=$err_match[2];
					$result['response_code']=$err_match[1];
					$result['is_success']='0';
				}

			} else {
				// If it's an OK line check to see if it's an Array of values
				$arrayMatch=preg_match_all($arrayPattern, $resultLine, $arrayMatches);
				if ($arrayMatch !=0){
					for($j=0;$j<$arrayMatch;$j++){
						if($arrayMatches[1][$j]=="LIST")
							$result['attributes'][strtolower($arrayMatches[1][$j])]=explode("," , $arrayMatches[2][$j]);
						else
							$result['attributes'][strtolower($arrayMatches[1][$j])]=$arrayMatches[2][$j];
					}
				} else {

					// If it's not an array line or an error it could be a table
					$tableLines=explode(' , ', $resultLine);
					if (count($tableLines)>1){
						$tableLines[0] = str_replace("OK 0 ", "", $tableLines[0]);
						$tableHeaders=explode(' ',$tableLines[0]);
						$result['attributes']['list']=Array();
						for($j=1;$j<count($tableLines);$j++){
							$values=explode('" "', $tableLines[$j]);
							$k = 0;
							foreach($tableHeaders as $tableHeader){
								$result['attributes']['list'][$j-1][strtolower($tableHeader)]=str_replace('"', '', $values[$k]);
								$k++;
							}
						}

					}
				}
			}
			$i++;
		}

		return $result;
	}
}
