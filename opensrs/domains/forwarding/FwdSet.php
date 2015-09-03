<?php

namespace opensrs\domains\forwarding;

use OpenSRS\Base;
use OpenSRS\Exception;
/*
 *  Required object values:
 *  data -
 */

class FwdSet extends Base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct( $formatString, $dataObject ) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject();
	}

	public function __destruct() {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject(){
		// Command required values
		if((!isSet($this->_dataObject->data->cookie) || $this->_dataObject->data->cookie == "") &&(!isSet($this->_dataObject->data->bypass) || $this->_dataObject->data->bypass == "" )) {
			throw new Exception( "oSRS Error - cookie / bypass is not defined." );
		}
		if(
			$this->_dataObject->data->cookie != "" &&
			$this->_dataObject->data->bypass != ""
		) {
			throw new Exception( "oSRS Error - Both cookie and bypass cannot be set in one call." );
		}

		if(
			!isSet( $this->_dataObject->data->domain ) ||
			$this->_dataObject->data->domain == ""
		) {
			throw new Exception( "oSRS Error - domain is not defined." );
		}
		if(
			!isSet( $this->_dataObject->data->subdomain ) ||
			$this->_dataObject->data->subdomain == ""
		) {
			throw new Exception( "oSRS Error - subdomain is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest(){
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'set_domain_forwarding',
			'object' => 'domain',
//			'cookie' => $this->_dataObject->data->cookie,
			'attributes' => array(
				'domain' => $this->_dataObject->data->domain,
				'forwarding' => array(
					array(
					'subdomain' => $this->_dataObject->data->subdomain
					)

				)
			)
		);

		// Cookie / bypass
		if(
			isSet( $this->_dataObject->data->cookie ) &&
			$this->_dataObject->data->cookie != ""
		) {
			$cmd['cookie'] = $this->_dataObject->data->cookie;
		}
		if(
			isSet( $this->_dataObject->data->bypass ) &&
			$this->_dataObject->data->bypass != ""
		) {
			$cmd['domain'] = $this->_dataObject->data->bypass;
		}

		// Command optional values
		if(
			isSet( $this->_dataObject->data->description ) &&
			$this->_dataObject->data->description != ""
		) {
			$cmd['attributes']['forwarding'][0]['description'] = $this->_dataObject->data->description;
		}
		if(
			isSet( $this->_dataObject->data->destination_url ) &&
			$this->_dataObject->data->destination_url != ""
		) {
			$cmd['attributes']['forwarding'][0]['destination_url'] = $this->_dataObject->data->destination_url;
		}
		if(
			isSet( $this->_dataObject->data->enabled ) &&
			$this->_dataObject->data->enabled != ""
		) {
			$cmd['attributes']['forwarding'][0]['enabled'] = $this->_dataObject->data->enabled;
		}
		if(
			isSet( $this->_dataObject->data->keywords ) &&
			$this->_dataObject->data->keywords != ""
		) {
			$cmd['attributes']['forwarding'][0]['keywords'] = $this->_dataObject->data->keywords;
		}
		if(
			isSet( $this->_dataObject->data->masked ) &&
			$this->_dataObject->data->masked != ""
		) {
			$cmd['attributes']['forwarding'][0]['masked'] = $this->_dataObject->data->masked;
		}
		if(
			isSet( $this->_dataObject->data->title ) &&
			$this->_dataObject->data->title != ""
		) {
			$cmd['attributes']['forwarding'][0]['title'] = $this->_dataObject->data->title;
		}

		// Flip Array to XML
		$xmlCMD = $this->_opsHandler->encode( $cmd );
		// Send XML
		$XMLresult = $this->send_cmd( $xmlCMD );
		// Flip XML to Array
		$arrayResult = $this->_opsHandler->decode( $XMLresult );

		// Results
		$this->resultFullRaw = $arrayResult;
		$this->resultRaw = $arrayResult;
		$this->resultFullFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultFullRaw );
		$this->resultFormatted = $this->convertArray2Formatted( $this->_formatHolder, $this->resultRaw );
	}
}
