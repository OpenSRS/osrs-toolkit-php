<?php

defined('OPENSRSURI') or die;


/**
 * OpenSRS Base class
 *
 * @package     OpenSRS
 * @subpackage  Base
 * @since       3.4
 */

class openSRS_base {

	private $_socket = false;
	private $_socketErrorNum = false;
	private $_socketErrorMsg = false;
	private $_socketTimeout = 120;				// seconds
	private $_socketReadTimeout = 120;			// seconds

	protected $_opsHandler;

	/**
	 * openSRS_base object constructor
	 *
	 * Closes an existing socket connection, if we have one
	 * 
	 * @since   3.1
	 */
	public function __construct () {
		$this->_verifySystemProperties ();
		$this->_opsHandler = new openSRS_ops;
	}

	/**
	 * openSRS_base object destructor
	 *
	 * Closes an existing socket connection, if we have one
	 *
	 * @since   3.4
	 */
	public function __destruct () {
		if (is_resource($this->_socket))
		{
			fclose($this->_socket);
		}
	}

	/**
	 * Method to check the PHP version and OpenSSL PHP lib installation
	 *
	 * @since   3.1
	 */	
	private function _verifySystemProperties () {
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

	/**
	 * Method to send a command to the server
	 *
	 * @param 	string 	$request Raw XML request
	 *
	 * @return 	string 	$data 	Raw XML response
	 *  
	 * @since   3.1
	 */	
	public function send_cmd($request) {
		// make or get the socket filehandle
		if (!$this->init_socket() ) {
			trigger_error ("oSRS Error - Unable to establish socket: (". $this->_socketErrorNum .") ". $this->_socketErrorMsg, E_USER_WARNING);
			die();
		}

		$this->send_data($request);
		$data = $this->read_data();

		$num_matches = preg_match('/<item key="response_code">401<\/item>/', $data, $matches);

		if ($num_matches > 0)
			trigger_error("oSRS Error - Reseller username or OSRS_KEY is incorrect, please check your config file.");

		return $data;
	}

	/**
	 * Method to initialize a socket connection to the OpenSRS server
	 *
	 * @return 	boolean  True if connected
	 *  
	 * @since   3.1
	 */	
	private function init_socket() {
		if ($this->is_connected()) return true;
		$this->_socket = fsockopen(CRYPT_TYPE . '://' . OSRS_HOST, OSRS_SSL_PORT, $this->_socketErrorNum, $this->_socketErrorMsg, $this->_socketTimeout);
		if (!$this->_socket) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Method to check if a socket connection exists
	 *
	 * @return 	boolean  True if connected
	 *  
	 * @since   3.4
	 */	
	public function is_connected() {
		return (is_resource($this->_socket)) ? true : false;
	}

	/**
	 * Method to close the socket connection
	 *  
	 * @since   3.4
	 */	
	private function close_socket() {
		if (is_resource($this->_socket))
		{
			fclose($this->_socket);
		}
	}


	/**
	 * Method to read data from the buffer stream
	 *  
	 * @return 	string 	XML response
	 * @since   3.1
	 */	
	private function read_data() {
		$buf = $this->readData($this->_socket, $this->_socketReadTimeout);
		if (!$buf) {
			trigger_error ("oSRS Error - Read buffer is empty.  Please make sure IP is whitelisted in RWI. Check the OSRS_KEY and OSRS_USERNAME in the config file as well.", E_USER_WARNING);
			$data = "";
		} else {
			$data = $buf;
		}
		if (!empty($this->osrs_debug)) print_r("<pre>" . htmlentities($data) . "</pre>");
		
		return $data;
	}

	/**
	 * Method to send data
	 *  
	 * @param 	string 	$message 	XML request
	 * @return 	string  $message	XML response
	 * @since   3.1
	 */	
	private function send_data($message) {
		if (!empty($this->osrs_debug)) print_r("<pre>" . htmlentities($message) . "</pre>");		
		return $this->writeData( $this->_socket, $message );
	}

	/**
	* Writes a message to a socket (buffered IO)
	*
	* @param	int 	&$fh 	socket handle
	* @param	string 	$msg    message to write
	*/
	private function writeData(&$fh,$msg) {
		$header = "";
		$len = strlen($msg);

		$signature = md5(md5($msg.OSRS_KEY).OSRS_KEY);
		$header .= "POST / HTTP/1.0". CRLF;
		$header .= "Content-Type: text/xml" . CRLF;
		$header .= "X-Username: " . OSRS_USERNAME . CRLF;
		$header .= "X-Signature: " . $signature . CRLF;
		$header .= "Content-Length: " . $len . CRLF . CRLF;
		
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
			trigger_error ("oSRS Error - UNEXPECTED ERROR: No Content-Length header provided! Please make sure IP is whitelisted in RWI.", E_USER_WARNING);
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

		$this->close_socket();
		return $buf;
	}
}