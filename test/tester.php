<?php
/**
*  File: tester.php
*  
*  Description: This script will test 1. The connection to the host, 
*               and 2. the reseller API credentials.
* 
*/

define('CRLF', "\r\n");

$host = "ssl://rr-n1-tor.opensrs.net"; // CHANGEME
$port = '55443';
$timeout = 30;
$user = "<RESELLER_USERNAME>"; // CHANGEME
$private_key= "<PRIVATE_KEY>"; // CHANGEME

/**
* Test1: Connection test
*/

$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
if (!$fp) {
	print "Connection Test: failed. $errno - $errstr\n";
	exit(0);
} 

$out = "GET / HTTP/1.1\r\n";
$out .= "Connection: Close\r\n\r\n";
fwrite($fp, $out);
while (!feof($fp)) {
	$line = fgets($fp, 4000);	
	if (preg_match('/invalid ip address/', $line)){
		print "Connection Test: failed. Invalid IP Address.\n";
		exit(0);
	}
}

fclose($fp);

print "Connection Test: success!\n";

/**
* Test2: Authentication test
* Calling a domain lookup API command to test the credentials.
*/

$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
if (!$fp) {
	print "Authentication Test: failed. $errno - $errstr\n";
	exit(0);
} 

$msg =<<<EOF
<?xml version="1.0" encoding="UTF-8" standalone="no" ?>
<!DOCTYPE OPS_envelope SYSTEM "ops.dtd">
<OPS_envelope>
 <header>
  <version>0.9</version>
 </header>
 <body>
  <data_block>
   <dt_assoc>
   <item key="protocol">XCP</item>
   <item key="action">lookup</item>
   <item key="object">domain</item>
   <item key="attributes">
	 <dt_assoc>
		<item key="domain">test.com</item>
	 </dt_assoc>
   </item>
   </dt_assoc>
  </data_block>
 </body>
</OPS_envelope>
EOF;

$len = strlen($msg);
$signature = md5(md5($msg.$private_key).$private_key);
$header = "POST / HTTP/1.0". CRLF;
$header .= "Content-Type: text/xml" . CRLF;
$header .= "X-Username: " . $user . CRLF;
$header .= "X-Signature: " . $signature . CRLF;
$header .= "Content-Length: " . $len . CRLF . CRLF;

fwrite($fp, $header);
fwrite($fp, $msg);

$contents = '';
while (!feof($fp)) {
  	$contents .= fread($fp, 8192);
}

// print $contents . "\n";
if (preg_match('/<item key="is_success">0<\/item>/', $contents)) {
	preg_match('/<item key="response_text">(.*)<\/item>/', $contents, $match);
	print "Authentication Test Failed: $match[1] \n";
	exit(0);
}

if (!preg_match('/<item key="object">/', $contents)) {
	preg_match('/<item key="response_text">(.*)<\/item>/', $contents, $match);
	print "Authentication Test Failed: $match[1] \n";
	exit(0);
}

fclose($fp);

print "Authentication Test: success!\n";
