<?php

/**
* dnsSet class file
*
* @category OpenSRS
* @package  OpenSRS
* @author   Keiji Suzuki <ksuzuki@tucows.com>
* @license  MIT License (http://www.opensource.org/licenses/mit-license.php)
* @link
*/
 
class DnsSet extends openSRS_base
{
    private $_dataObject;
    private $_formatHolder = "";
    public $resultFullRaw;
    public $resultRaw;
    public $resultFullFormatted;
    public $resultFormatted;

    /**
    * __construct
    *
    * @param  string  $formatString  	Format type
    * @param  hash    $dataObject 	Containing domain key/value pairs
    */

    public function __construct ($formatString, $dataObject) {
    	parent::__construct();
    	$this->_dataObject = $dataObject;
    	$this->_formatHolder = $formatString;
    	$this->_validateObject ();
    }

    public function __destruct () {
    	parent::__destruct();
    }

    private function _validateObject (){
        $allPassed = true;

        // Command required values
        if (!isSet($this->_dataObject->data->domain) || $this->_dataObject->data->domain == "") {
			trigger_error ("oSRS Error - domain is not defined.", E_USER_WARNING);
			$allPassed = false;
		}
				
		if ($allPassed) {
			$this->_processRequest ();
		} else {
			trigger_error ("oSRS Error - Incorrect call.", E_USER_WARNING);
		}
	}

	// Post validation functions
	private function _processRequest (){

		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'set_dns_zone',
			'object' => 'domain',
			'attributes' => array (
				'domain' => $this->_dataObject->data->domain,
			)
		);

		// Command optional values
		if (isSet($this->_dataObject->data->dns_template) && $this->_dataObject->data->dns_template != "") {
			$cmd['attributes']['dns_template'] = $this->_dataObject->data->dns_template;
		}

		// records - A
		if (isset($this->_dataObject->data->a) && count($this->_dataObject->data->a) > 0) {
			$as = array();			
			foreach ($this->_dataObject->data->a as $key => $value) {	
				array_push($as, array('ip_address' => $value->ip_address, 'subdomain' => $value->subdomain));
			}
			$cmd['attributes']['records']['A'] = $as;
		}

		// records - AAAA
		if (isset($this->_dataObject->data->aaaa) && count($this->_dataObject->data->aaaa) > 0) {
			$aaaas = array();			
			foreach ($this->_dataObject->data->aaaa as $key => $val) {	            
				array_push($aaaas, array('ipv6_address' => $val->ipv6_address, 'subdomain' => $val->subdomain));
			}
			$cmd['attributes']['records']['AAAA'] = $aaaas;
		}
		
		// records - CNAME
		if (isset($this->_dataObject->data->cname) && count($this->_dataObject->data->cname) > 0) {
			$cnames = array();			
			foreach ($this->_dataObject->data->cname as $key => $val) {	
				array_push($cnames, array('hostname' => $val->hostname, 'subdomain' => $val->subdomain));
			}
			$cmd['attributes']['records']['CNAME'] = $cnames;
		}

		// records - MX
		if (isset($this->_dataObject->data->mx) && count($this->_dataObject->data->mx) > 0) {
			$mxs = array();			
			foreach ($this->_dataObject->data->mx as $key => $val) {	
				array_push($mxs, 
					array(
						'priority' => $val->priority, 
						'subdomain' => $val->subdomain, 
						'hostname' => $val->hostname
					)
				);
			}
			$cmd['attributes']['records']['MX'] = $mxs;
		}

		// records - SRV
		if (isset($this->_dataObject->data->srv) && count($this->_dataObject->data->srv) > 0) {
			$srvs = array();			
			foreach ($this->_dataObject->data->srv as $key => $val) {	
				array_push($srvs, 
					array(
						'priority' => $val->priority, 
						'weight' => $val->weight, 
						'subdomain' => $val->subdomain, 
						'hostname' => $val->hostname,
						'port' => $val->port
					)
				);
			}
			$cmd['attributes']['records']['SRV'] = $srvs;
		}

		// records - TXT
		if (isset($this->_dataObject->data->txt) && count($this->_dataObject->data->txt) > 0) {
			$txts = array();
			foreach ($this->_dataObject->data->txt as $key => $val) {	
				array_push($txts, array('subdomain' => $val->subdomain, 'text' => $val->text));
			}
			$cmd['attributes']['records']['TXT'] = $txts;
		}
	    
		$xmlCMD = $this->_opsHandler->encode($cmd);					// Flip Array to XML
		$XMLresult = $this->send_cmd($xmlCMD);						// Send XML
		$arrayResult = $this->_opsHandler->decode($XMLresult);		// Flip XML to Array

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = convertArray2Formatted ($this->_formatHolder, $this->resultFullRaw);
		$this->resultFormatted = convertArray2Formatted ($this->_formatHolder, $this->resultRaw);
	}
}