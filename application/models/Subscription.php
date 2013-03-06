<?php

/**
 * Model for subscriptions
 */
class Subscription extends BaseRecord  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		$this->setTableName('subscription');
		
		$this->hasColumn('userid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('membershipplanid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('startdate', 'date', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('enddate', 'date', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('isactive', 'integer', null, array('default' => 0));
		$this->hasColumn('istrial', 'integer', null, array('default' => 1));
		
	}
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
       									"userid.notblank" => $this->translate->_("subscription_userid_error"),
										"membershipplanid.notblank" => $this->translate->_("subscription_plan_error"),
										"startdate.notblank" => $this->translate->_("subscription_startdate_error"),
										"enddate.notblank" => $this->translate->_("subscription_enddate_error"),
       	       						));     
	}
	/*
	 * Relationships for the model
	 */
	public function setUp() {
		parent::setUp(); 

		$this->hasOne('UserAccount as user', 
								array(
									'local' => 'userid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('MembershipPlan as plan', 
								array(
									'local' => 'membershipplanid',
									'foreign' => 'id'
								)
						);		
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('isactive', $formvalues)){
			unset($formvalues['isactive']); 
		}
		if(isArrayKeyAnEmptyString('istrial', $formvalues)){
			unset($formvalues['istrial']); 
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	# determine if is the current subscription
	function isTheCurrent() {
    	return $this->getIsActive() == 1 ? true : false;
    }
}

?>