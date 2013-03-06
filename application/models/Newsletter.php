<?php

class Newsletter extends BaseRecord {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('newsletter');
		$this->hasColumn('name', 'string', 255);
		$this->hasColumn('email', 'string', 255);
		$this->hasColumn('message', 'string', 500);
		$this->hasColumn('datesubscribed', 'date');
	}
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		// specify the date columns
		$this->addDateFields(array("datesubscribed"));
	}
	/**
	 * Custom model validation
	 */
	function validate() {
		# execute the column validation 
		parent::validate();
		if($this->emailExists()){
			$this->getErrorStack()->add("email.unique", "Sorry you already have an active subscription for <b>".$this->getEmail()."</b>.");
		}
	}
	# determine if the user has their email already subscribed
	function emailExists($email=''){
		$conn = Doctrine_Manager::connection();
		# validate unique email
		if(isEmptyString($email)){
			$email = $this->getEmail();
		}
		# unique email
		$ref_query = "SELECT id FROM newsletter WHERE email = '".$email."' ";
		// debugMessage($ref_query);
		$ref_result = $conn->fetchOne($ref_query);
		// debugMessage($ref_result);
		if(isEmptyString($ref_result)){
			return false;
		}
		return true;
	}
	/**
	 * Preprocess model data
	 */
	function processPost($formvalues){
		// debugMessage($formvalues);
		$session = SessionWrapper::getInstance();
    	$farmerid = $session->getVar('farmerid');
    	$userid = $session->getVar('userid');
    	
		// set default values for integers, dates, decimals
		if(isArrayKeyAnEmptyString('datesubscribed', $formvalues)){
			$formvalues['datesubscribed'] = date('Y-m-d H:i:s');
		}
		
		// debugMessage($formvalues); 
        // exit();
		parent::processPost($formvalues);
	}
}
?>