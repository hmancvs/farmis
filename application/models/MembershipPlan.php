<?php

/**
 * A membership plan to which an employer subscribes
 */
class MembershipPlan extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		$this->setTableName('membershipplan');
		$this->hasColumn('name', 'string', 45,  array('unique' => true, 'notnull' => true, 'notblank' => true));
		$this->hasColumn('trialdays', 'integer', null, array('default' => 0));
		$this->hasColumn('usagedays', 'integer', null, array('default' => 0));
		$this->hasColumn('amount', 'decimal', null, array('default' => 0));
		$this->hasColumn('amountke', 'decimal', null, array('default' => 0));
		$this->hasColumn('nooffarms', 'integer', null, array('default' => 0));
		$this->hasColumn('noofseasons', 'integer', null, array('default' => 0));
		$this->hasColumn('noofactivities', 'integer', null, array('default' => 0));
		$this->hasColumn('mapsenabled', 'integer', null, array('default' => 0));
		$this->hasColumn('calendarenabled', 'integer', null, array('default' => 0));
		$this->hasColumn('reportsenabled', 'integer', null, array('default' => 0));
	}
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"name.unique" => $this->translate->_("membership_name_unique"),
       									"name.notblank" => $this->translate->_("membership_name_error"),
       	       						));     
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('trialdays', $formvalues)){
			unset($formvalues['trialdays']); 
		}
		if(isArrayKeyAnEmptyString('usagedays', $formvalues)){
			unset($formvalues['usagedays']); 
		}
		if(isArrayKeyAnEmptyString('nooffarms', $formvalues)){
			unset($formvalues['nooffarms']); 
		}
		if(isArrayKeyAnEmptyString('noofseasons', $formvalues)){
			unset($formvalues['noofseasons']); 
		}
		if(isArrayKeyAnEmptyString('noofactivities', $formvalues)){
			unset($formvalues['noofactivities']); 
		}
		if(isArrayKeyAnEmptyString('mapsenabled', $formvalues)){
			unset($formvalues['mapsenabled']); 
		}
		if(isArrayKeyAnEmptyString('calendarenabled', $formvalues)){
			unset($formvalues['calendarenabled']); 
		}
		if(isArrayKeyAnEmptyString('reportsenabled', $formvalues)){
			unset($formvalues['reportsenabled']); 
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	/**
    * Fetch all membership plans into a collection
    * 
    * @return MembershipPlan collection
    */
	function getAllPlans() {
		return $this->getTable()->findAll();
	}
}

?>