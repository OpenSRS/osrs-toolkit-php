<?php

class openSRS_base {

	// Class internal
	protected $crypt_type = 'DES'; 				// 'DES'/'BLOWFISH'/'SSL'
	private $_socket = false;
	private $_socketErrorNum = false;
	private $_socketErrorMsg = false;
	private $_socketTimeout = 120;				// seconds
	private $_socketReadTimeout = 120;			// seconds
	private $_authenticated = false;
	private $CRLF= "\r\n";

	protected $_opsHandler;
	protected $_CBC = false;


	// Class constructor
	public function __construct () {
		$this->_verifySystemProperties ();
		$this->_opsHandler = new openSRS_ops;
	}

	// Class destructor
	public function __destruct () {
	}

 	// Private functions
	private function _verifySystemProperties () {
		// Encryption verification
    	if ('SSL' == $this->crypt_type) {
    		if (!function_exists('version_compare') || version_compare('4.3', phpversion(), '>=')) {
				$error_message = "PHP version must be v4.3+ (current version is ". phpversion() .") to use \"SSL\" encryption";
				trigger_error ($error_message, E_USER_WARNING);
				die();
			} elseif (!function_exists('openssl_open')) {
				$error_message = "PHP must be compiled using --with-openssl to use \"SSL\" encryption";
				trigger_error ($error_message, E_USER_WARNING);
				die();
			}
    	}
	}

	//  Send a command to the server
	public function send_cmd($request) {
		// make or get the socket filehandle
		if (!$this->init_socket() ) {
			trigger_error ("oSRS Error - Unable to establish socket: (". $this->_socketErrorNum .") ". $this->_socketErrorMsg, E_USER_WARNING);
			die();
		}

		// Authenticate user
		$auth = $this->authenticate();

		if (!$auth) {
			if ($this->_socket) $this->close_socket();
			trigger_error ("oSRS Error - Authentication Error: ". $auth['error'], E_USER_WARNING);
			die();
		}

		$this->send_data($request);
		$data = $this->read_data();

		$num_matches = preg_match('/<item key="response_code">401<\/item>/', $data, $matches);

		if ($num_matches > 0)
			trigger_error("oSRS Error - Reseller username or OSRS_KEY is incorrect, please check your config file.");

		return $data;
	}


//  Initialize a socket connection to the OpenSRS server
	private function init_socket() {
		if ($this->_socket) return true;
		if (!OSRS_ENV) return false;

		if ($this->crypt_type == 'SSL') {
			$tempPortHand = OSRS_SSL_PORT;
        	$conType = 'ssl://';
		} else {
			$tempPortHand = OSRS_PORT;
			$conType = '';
		}

		$this->_socket = fsockopen($conType . OSRS_HOST, $tempPortHand, $this->_socketErrorNum, $this->_socketErrorMsg, $this->_socketTimeout);
		if (!$this->_socket) {
			return false;
		} else {
			return true;
		}
	}


//  Authenticate the connection with the username/private key
	private function authenticate() {
		if ($this->_authenticated || 'SSL' == $this->crypt_type) {
			return array('is_success' => true);
		}

		$promptXML = $this->read_data();
		$prompt = $this->_opsHandler->decode($promptXML);
		if (isSet($prompt['response_code'])) {
			if ($prompt['response_code'] == 555 ) {
				// the ip address from which we are connecting is not accepted
				return array(
					'is_success'	=> false,
					'error'			=> $prompt['response_text']
				);
			}
		} else if ( !preg_match('/OpenSRS\sSERVER/', $prompt['attributes']['sender']) ||
			substr($prompt['attributes']['version'],0,3) != 'XML' ) {
			return array(
				'is_success'	=> false,
				'error'			=> 'Unrecognized Peer'
			);
		}

		// first response is server version
		$cmd = array(
			'protocol' => OSRS_PROTOCOL,
			'action' => 'check',
			'object' => 'version',
			'attributes' => array(
				'sender' => 'OpenSRS CLIENT',
				'version' => OSRS_VERSION,
				'state' => 'ready'
			)
		);
		$xmlCMD = $this->_opsHandler->encode($cmd);
		$this->send_data($xmlCMD);

		$cmd = array(
			'protocol' => OSRS_PROTOCOL,
			'action' => 'authenticate',
			'object' => 'user',
			'attributes' => array(
				'crypt_type' => strtolower($this->crypt_type),
				'username' => OSRS_USERNAME,
				'password' => OSRS_USERNAME
			)
		);
		$xmlCMD = $this->_opsHandler->encode($cmd);
		$this->send_data( $xmlCMD );

		$challenge = $this->read_data();

		// Sanity check to make sure that the OSRS_KEY is all hex values
		$hex_check = ctype_xdigit(OSRS_KEY);

		// Respond to the challenge with the MD5 checksum of the challenge.
		// ... and PHP's md5() doesn't return binary data, so
		// we need to pack that too

		if ($hex_check){
			$this->_CBC = new openSRS_crypt(pack('H*', OSRS_KEY), $this->crypt_type);
			$response = pack('H*',md5($challenge));
			$this->send_data($response);

			// Read the server's response to our login attempt (XML)
			$answerXML = $this->read_data();
			$answer = $this->_opsHandler->decode($answerXML);

			if (substr($answer['response_code'],0,1)== '2') {
				$this->_authenticated = true;
				return true;
			} else {
				return false;
			}
		} else {
			trigger_error("oSRS Error - Please check the OSRS_KEY value in the config file, it contains a non hexidecimal character.");
		}
	}

//		Close the socket connection
	private function close_socket() {
		fclose($this->_socket);
		if ($this->_CBC) $this->_CBC->_openSRS_crypt();			/* destructor */
		$this->_CBC				= false;
		$this->_authenticated	= false;
		$this->_socket			= false;
	}


	private function read_data() {
		$buf = $this->readData($this->_socket, $this->_socketReadTimeout);
		if (!$buf) {
			trigger_error ("oSRS Error - Read buffer is empty.  Please make sure IP is whitelisted in RWI. Check the OSRS_KEY and OSRS_USERNAME in the config file as well.", E_USER_WARNING);
			$data = "";
		} else {
			$data = $this->_CBC ? $this->_CBC->decrypt($buf) : $buf;
		}
		if (!empty($this->osrs_debug)) print_r("<pre>" . htmlentities($data) . "</pre>");
		
		return $data;
		
	}

	private function send_data($message) {
		if (!empty($this->osrs_debug)) print_r("<pre>" . htmlentities($message) . "</pre>");
		
		if ($this->_CBC) $message = $this->_CBC->encrypt($message);
		
		return $this->writeData( $this->_socket, $message );
	}

//	Regex check for valid email
	private function check_email_syntax($email) {
		if (preg_match('/(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/', $email) || !preg_match('/^\S+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/', $email)) {
			return false;
		} else {
			return true;
		}
	}


/**
* Writes a message to a socket (buffered IO)
* @param	int 	socket handle
* @param	string 	message to write
*/
	private function writeData(&$fh,$msg) {
		$header = "";
		$len = strlen($msg);
		
		switch ($this->crypt_type) {
			case 'SSL':
				$signature = md5(md5($msg.OSRS_KEY).OSRS_KEY);
				$header .= "POST / HTTP/1.0". CRLF;
				$header .= "Content-Type: text/xml" . CRLF;
				$header .= "X-Username: " . OSRS_USERNAME . CRLF;
				$header .= "X-Signature: " . $signature . CRLF;
				$header .= "Content-Length: " . $len . CRLF . CRLF;
				break;
			case 'BLOWFISH':
			case 'DES':
			default:
				$header .= "Content-Length: " . $len . CRLF . CRLF;
				break;
		}
		
		fputs($fh, $header);
		fputs($fh, $msg, $len );
	}


/**
* Reads header data
* @param	int 	socket handle
* @param	int 	timeout for read
* @return	hash	hash containing header key/value pairs
*/
	private function readHeader($fh, $timeout=5) {
		$header = array();
		switch ($this->crypt_type) {
			case 'SSL':
				/* HTTP/SSL connection method */
				$http_log ='';
				$line = fgets($fh, 4000);
				$http_log .= $line;
				if (!preg_match('/^HTTP\/1.1 ([0-9]{0,3}) (.*)\r\n$/',$line, $matches)) {
					trigger_error ("oSRS Error - UNEXPECTED READ: Unable to parse HTTP response code. Please make sure IP is whitelisted in RWI.", E_USER_WARNING);
					return false;
				}
				$header['http_response_code'] = $matches[1];
				$header['http_response_text'] = $matches[2];

				while ($line != CRLF) {
					$line = fgets($fh, 4000);
					$http_log .= $line;
					if (feof($fh)) {
						trigger_error ("oSRS Error - UNEXPECTED READ: Error reading HTTP header.", E_USER_WARNING);
						return false;
					}
					$matches = explode(': ', $line, 2);
					if (sizeof($matches) == 2) {
						$header[trim(strtolower($matches[0]))] = $matches[1];
					}
				}
				$header['full_header'] = $http_log;
				break;
			case 'BLOWFISH':
			case 'DES':
			default:
				/* socket (old-style) connection */
				$line = fgets($fh, 4000);
				if ($this->_opsHandler->socketStatus($fh)) {
					return false;
				}

				if (preg_match('/^\s*Content-Length:\s+(\d+)\s*\r\n/i', $line, $matches ) ) {
					$header{'content-length'} = (int)$matches[1];
				} else {
					trigger_error ("oSRS Error - UNEXPECTED READ: No Content-Length.", E_USER_WARNING);
					return false;
				}

				/* read the empty line */
				$line = fread($fh, 2);
				if ($this->_opsHandler->socketStatus($fh)) {
					return false;
				}
				if ($line != CRLF ) {
					trigger_error ("oSRS Error - UNEXPECTED READ: No CRLF.", E_USER_WARNING);
					return false;
				}
				break;
		}
		return $header;
	}


/**
* Reads data from a socket
* @param	int 	socket handle
* @param	int 	timeout for read
* @return	mixed	buffer with data, or an error for a short read
*/
	private function readData(&$fh, $timeout=5) {
		$len = 0;
		/* PHP doesn't have timeout for fread ... we just set the timeout for the socket */
		socket_set_timeout($fh, $timeout);
		$header = $this->readHeader($fh, $timeout);
		if (!$header || !isset($header{'content-length'}) || (empty($header{'content-length'}))) {
			if ($this->crypt_type == "SSL")
				trigger_error ("oSRS Error - UNEXPECTED ERROR: No Content-Length header provided! Please make sure IP is whitelisted in RWI.", E_USER_WARNING);
			else
				trigger_error ("oSRS Error - No Content-Length header returned. Please make sure IP is whitelisted in RWI. Check the OSRS_KEY and OSRS_USERNAME in the config file as well.", E_USER_WARNING);
		}

		$len = (int)$header{'content-length'};
		$line = '';
		while (strlen($line) < $len) {
			$line .= fread($fh, $len);
			if ($this->_opsHandler->socketStatus($fh)) {
				return false;
			}
		}

		if ($line) {
			$buf = $line;
		} else {
			$buf = false;
		}

		if ('SSL' == $this->crypt_type) $this->close_socket();
		return $buf;
	}

	// Helper functions
	public function convertXML2array ($xml) {
		$array = $this->_opsHandler->decode($xml);
		return $array;
	}

}

