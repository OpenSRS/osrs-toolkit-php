<?php 

class provUpdateContacts extends openSRS_base {
	private $_dataObject;
	private $_formatHolder = "";
	public $resultFullRaw;
	public $resultRaw;
	public $resultFullFormatted;
	public $resultFormatted;

	public function __construct ($formatString, $dataObject) {
		parent::__construct();
		$this->_dataObject = $dataObject;
		$this->_formatHolder = $formatString;
		$this->_validateObject ();
	}

	public function __destruct () {
		parent::__destruct();
	}

	// Validate the object
	private function _validateObject (){
		$allPassed = true;

		// Personal information
		$reqPers = array ("first_name", "last_name", "org_name", "address1", "city", "state", "country", "postal_code", "phone", "email", "lang_pref");
		for ($i = 0; $i < count($reqPers); $i++){
			if ($this->_dataObject->personal->$reqPers[$i] == "") {
				trigger_error ("oSRS Error - ". $reqPers[$i] ." is not defined.", E_USER_WARNING);
				$allPassed = false;
			}
		}
		
		$reqData = array ("domain", "types");
		for ($i = 0; $i < count($reqData); $i++){
			if ($this->_dataObject->data->$reqData[$i] == "") {
				trigger_error ("oSRS Error - ". $reqData[$i] ." is not defined.", E_USER_WARNING);
				$allPassed = false;
			}
		}

		// Run the command
		if ($allPassed) {
			// Execute the command
			$this->processRequest ();
		} else {
			trigger_error ("oSRS Error - Incorrect call.", E_USER_WARNING);
		}		
	}

	/* Changed by BC : NG : 23-7-2014 : To resolve issue of save/update all contact details  */ 
    
    /*private function _createUserData(){
        $userArray = array(
            "first_name" => $this->_dataObject->personal->first_name,
            "last_name" => $this->_dataObject->personal->last_name,
            "org_name" => $this->_dataObject->personal->org_name,
            "address1" => $this->_dataObject->personal->address1,
            "address2" => $this->_dataObject->personal->address2,
            "address3" => $this->_dataObject->personal->address3,
            "city" => $this->_dataObject->personal->city,
            "state" => $this->_dataObject->personal->state,
            "postal_code" => $this->_dataObject->personal->postal_code,
            "country" => $this->_dataObject->personal->country,
            "phone" => $this->_dataObject->personal->phone,
            "fax" => $this->_dataObject->personal->fax,
            "email" => $this->_dataObject->personal->email,
            "url" => $this->_dataObject->personal->url,
            "lang_pref" => $this->_dataObject->personal->lang_pref
        );
        return $userArray;
    }*/  
    
    private function _createUserData($type = null){
        switch ($type) {
          case "admin":
            $userArray = array(
                "first_name" => $this->_dataObject->admin->first_name,
                "last_name" => $this->_dataObject->admin->last_name,
                "org_name" => $this->_dataObject->admin->org_name,
                "address1" => $this->_dataObject->admin->address1,
                "address2" => $this->_dataObject->admin->address2,
                "address3" => $this->_dataObject->admin->address3,
                "city" => $this->_dataObject->admin->city,
                "state" => $this->_dataObject->admin->state,
                "postal_code" => $this->_dataObject->admin->postal_code,
                "country" => $this->_dataObject->admin->country,
                "phone" => $this->_dataObject->admin->phone,
                "fax" => $this->_dataObject->admin->fax,
                "email" => $this->_dataObject->admin->email,
                "url" => $this->_dataObject->admin->url,
                "lang_pref" => $this->_dataObject->admin->lang_pref
            );
            return $userArray;
            break;
          case "billing":
           $userArray = array(
                "first_name" => $this->_dataObject->billing->first_name,
                "last_name" => $this->_dataObject->billing->last_name,
                "org_name" => $this->_dataObject->billing->org_name,
                "address1" => $this->_dataObject->billing->address1,
                "address2" => $this->_dataObject->billing->address2,
                "address3" => $this->_dataObject->billing->address3,
                "city" => $this->_dataObject->billing->city,
                "state" => $this->_dataObject->billing->state,
                "postal_code" => $this->_dataObject->billing->postal_code,
                "country" => $this->_dataObject->billing->country,
                "phone" => $this->_dataObject->billing->phone,
                "fax" => $this->_dataObject->billing->fax,
                "email" => $this->_dataObject->billing->email,
                "url" => $this->_dataObject->billing->url,
                "lang_pref" => $this->_dataObject->billing->lang_pref
            );
            return $userArray;
            break;
          case "tech":
            $userArray = array(
                "first_name" => $this->_dataObject->tech->first_name,
                "last_name" => $this->_dataObject->tech->last_name,
                "org_name" => $this->_dataObject->tech->org_name,
                "address1" => $this->_dataObject->tech->address1,
                "address2" => $this->_dataObject->tech->address2,
                "address3" => $this->_dataObject->tech->address3,
                "city" => $this->_dataObject->tech->city,
                "state" => $this->_dataObject->tech->state,
                "postal_code" => $this->_dataObject->tech->postal_code,
                "country" => $this->_dataObject->tech->country,
                "phone" => $this->_dataObject->tech->phone,
                "fax" => $this->_dataObject->tech->fax,
                "email" => $this->_dataObject->tech->email,
                "url" => $this->_dataObject->tech->url,
                "lang_pref" => $this->_dataObject->tech->lang_pref
            );
            return $userArray;
            break;
          case "personal":          
          default:
            $userArray = array(
                "first_name" => $this->_dataObject->personal->first_name,
                "last_name" => $this->_dataObject->personal->last_name,
                "org_name" => $this->_dataObject->personal->org_name,
                "address1" => $this->_dataObject->personal->address1,
                "address2" => $this->_dataObject->personal->address2,
                "address3" => $this->_dataObject->personal->address3,
                "city" => $this->_dataObject->personal->city,
                "state" => $this->_dataObject->personal->state,
                "postal_code" => $this->_dataObject->personal->postal_code,
                "country" => $this->_dataObject->personal->country,
                "phone" => $this->_dataObject->personal->phone,
                "fax" => $this->_dataObject->personal->fax,
                "email" => $this->_dataObject->personal->email,
                "url" => $this->_dataObject->personal->url,
                "lang_pref" => $this->_dataObject->personal->lang_pref
            );
            return $userArray;
        }
    }
    /* End : To resolve issue of save/update all contact details */   
	
	// Post validation functions
	private function processRequest (){
		$this->_dataObject->data->types = explode (",", $this->_dataObject->data->types);
	
		// Compile the command
		/* Changed by BC : NG : 23-7-2014 : To resolve issue of save/update all contact details  */ 
        
        /*$cmd = array(
            'protocol' => 'XCP',
            'action' => 'update_contacts',
            'object' => 'domain',
            'attributes' => array(
                'domain' => $this->_dataObject->data->domain,
                'types' => $this->_dataObject->data->types,
                'contact_set' => array(
                    'owner' => $this->_createUserData(),
                    'admin' => $this->_createUserData(),
                    'billing' => $this->_createUserData(),
                    'tech' => $this->_createUserData()
                )
            )
        );*/
        
        $cmd = array(
            'protocol' => 'XCP',
            'action' => 'update_contacts',
            'object' => 'domain',
            'attributes' => array(
                'domain' => $this->_dataObject->data->domain,
                'types' => $this->_dataObject->data->types,
                'contact_set' => array(
                    'owner' => $this->_createUserData('personal'),
                    'admin' => $this->_createUserData('admin'),
                    'billing' => $this->_createUserData('billing'),
                    'tech' => $this->_createUserData('tech')
                )
            )
        );
        /* End : To resolve issue of save/update all contact details */

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