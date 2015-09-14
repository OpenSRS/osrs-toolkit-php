<?php

namespace opensrs\domains\authentication;

use OpenSRS\Base;
use OpenSRS\Exception;

/*
 *  Required object values:
 *  data -
 */

class AuthenticationCheckVersion extends Base {
	public $action = "CHECK";
	public $object = "VERSION";

	public $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct( $formatString, $dataObject ) {
		parent::__construct();

		$this->_formatHolder = $formatString;

		$this->_validateObject( $dataObject );

		$this->send( $dataObject );
	}

	public function __destruct() {
		parent::__destruct();
	}
}