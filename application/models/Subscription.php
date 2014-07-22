<?php

/**
 * Model for subscriptions
 */
class Subscription extends BaseRecord  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		$this->setTableName('subscription');
		
		$this->hasColumn('userid', 'integer', null);
		$this->hasColumn('farmgroupid', 'integer', null);
		$this->hasColumn('planid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('startdate', 'date', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('enddate', 'date', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('isactive', 'integer', null, array('default' => 0));
		$this->hasColumn('istrial', 'integer', null, array('default' => 1));
		$this->hasColumn('verifier', 'string', 255);
		$this->hasColumn('verifiedbyid', 'integer', null);
		$this->hasColumn('datecreated', 'date');
		
	}
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array('startdate','enddate'));
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"planid.notblank" => $this->translate->_("subscription_planid_error"),
										"startdate.notblank" => $this->translate->_("subscription_startdate_error"),
										"enddate.notblank" => $this->translate->_("subscription_enddate_error")
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
		$this->hasOne('FarmGroup as farmgroup', 
								array(
									'local' => 'farmgroupid',
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
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']); 
		}
		if(isArrayKeyAnEmptyString('farmgroupid', $formvalues)){
			unset($formvalues['farmgroupid']); 
		}
		if(isArrayKeyAnEmptyString('isactive', $formvalues)){
			unset($formvalues['isactive']); 
		}
		if(isArrayKeyAnEmptyString('istrial', $formvalues)){
			unset($formvalues['istrial']); 
		}
		if(isArrayKeyAnEmptyString('datecreated', $formvalues)){
			$formvalues['datecreated'] = date('Y-m-d H:i:s'); 
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	/**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	# save changes 
    	if($update){
    		$this->save();
    	}
    	
    	// find any duplicates and delete them
    	$duplicates = $this->getDuplicates();
		if($duplicates->count() > 0){
			$duplicates->delete();
		}
    	// exit();
    	return true;
    }
	# find duplicates after save
	function getDuplicates(){
		$q = Doctrine_Query::create()->from('Subscription s')->where("s.farmgroupid = '".$this->getFarmGroupID()."' AND s.userid = '".$this->getUserID()."' AND s.planid = '".$this->getPlanID()."' AND s.startdate = '".$this->getStartDate()."' AND s.enddate = '".$this->getEndDate()."' AND s.id <> '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	}
	# determine if is the current subscription
	function isTheCurrent() {
    	return $this->getIsActive() == 1 ? true : false;
    }
    # determine the membershipplan/subject for the subscription
	function getSubject(){
		$subject = '--';
		if(!isEmptyString($this->getPlanID())){
			switch ($this->getPlanID()) {
				case 1:
					$subject = "Basic Plan";
					break;
				case 2:
					$subject = "Premium Plan";
					break;
				case 3:
					$subject = "Enterprise Plan";
					break;
				case 4:
					$subject = "Premium Farm Group";
					break;
				default:
					break;
			}
		}
		return $subject;
	}
	# determine the status of a subcription
	function getStatus(){
		$status = 'In Active';
		if(!isEmptyString($this->getIsActive())){
			if($this->getIsActive() == 1){
				$status = 'Active';
			}
		}
		return $status;
	}
	# determine the days assigned for a subscription
	function getDaysAssigned() {
		$endstamp = strtotime($this->getEndDate());
		$startstamp = strtotime($this->getStartDate());
		$days = ceil(abs($endstamp - $startstamp) / 86400);
		return $days;
	}
	# determine the number of days remaininig for a subscription
	function getRemainingDays(){
		$nowstamp = time();
		$endstamp = strtotime($this->getEndDate());
		$startstamp = strtotime($this->getStartDate());
		$days = '--';
		if($startstamp > $nowstamp){
			$days = $this->getDaysAssigned();
		} else {
			$days = ceil(abs($endstamp - $nowstamp) / 86400);
		}
		
		return $days;
	}
	# find the payment effected for this subscription
	function getPayment(){
		$q = Doctrine_Query::create()->from('Payment p')->where("p.subscriptionid = '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	}
}

?>