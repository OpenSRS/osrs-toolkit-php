<?php

namespace opensrs\domains\subuser;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class SubuserDelete extends Base {
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
	private function _validateObject() {
		// Command required values
		if(
			( !isset($this->_dataObject->data->cookie ) ||
				$this->_dataObject->data->cookie == "") &&
			( !isset($this->_dataObject->data->bypass ) ||
				$this->_dataObject->data->bypass == "")
		) {
			throw new Exception( "oSRS Error - cookie / bypass is not defined." );
		}
		if(
			$this->_dataObject->data->cookie != "" &&
			$this->_dataObject->data->bypass != ""
		) {
			throw new Exception( "oSRS Error - Both cookie and bypass cannot be set in one call." );
		}

		if(
			!isset( $this->_dataObject->data->username ) ||
			$this->_dataObject->data->username == ""
		) {
			throw new Exception( "oSRS Error - username is not defined." );
		}
		if(
			!isset( $this->_dataObject->data->sub_id ) ||
			$this->_dataObject->data->sub_id == ""
		) {
			throw new Exception( "oSRS Error - sub_id is not defined." );
		}

		// Execute the command
		$this->_processRequest();
	}

	// Post validation functions
	private function _processRequest() {
		$cmd = array(
			'protocol' => 'XCP',
			'action' => 'delete',
			'object' => 'subuser',
//			'cookie' => $this->_dataObject->data->cookie,
			'username' => $this->_dataObject->data->username,
			'attributes' => array(
				'sub_id' => $this->_dataObject->data->sub_id
			)
		);

		// Cookie / bypass
		if( isset($this->_dataObject->data->cookie ) &&
			$this->_dataObject->data->cookie != ""
		) {
			$cmd['cookie'] = $this->_dataObject->data->cookie;
		}
		if(
			isset( $this->_dataObject->data->bypass ) &&
			$this->_dataObject->data->bypass != ""
		) {
			$cmd['domain'] = $this->_dataObject->data->bypass;
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