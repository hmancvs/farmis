<?php

/**
 * Model for custom season activity
 *
 */

class SeasonActivity extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('seasonactivity');
		$this->hasColumn('seasonid', 'integer', null, array('notnull' => true, 'notblank' => true));	
		$this->hasColumn('farmid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('cropid', 'integer', null);
		$this->hasColumn('ref', 'string', 50);
		$this->hasColumn('itemname', 'string', 255);
		$this->hasColumn('itemtype', 'string', 255);
		$this->hasColumn('startdate','date', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('enddate','date', null);
		$this->hasColumn('method', 'string', 255);
		$this->hasColumn('timing', 'integer', null);
		$this->hasColumn('status', 'integer', null);
		$this->hasColumn('itemrate', 'integer', null);
		$this->hasColumn('itemrateunit', 'string', 255);
		$this->hasColumn('totalapplied', 'integer', null);
		$this->hasColumn('totalappliedunit', 'string', 255);
		$this->hasColumn('financetype', 'integer', null, array('default' => '1'));
		$this->hasColumn('totalexpenses', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('target','string', 500);
		$this->hasColumn('notes','string', 1000);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("startdate","enddate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"farmid.notblank" => $this->translate->_("season_farmid_error"),
       									"seasonid.notblank" => $this->translate->_("season_seasonid_error"),
       									"type.notblank" => $this->translate->_("season_trackingtype_error"),
       									"startdate.notblank" => $this->translate->_("season_activitydate_error"),
       									"method.notblank" => $this->translate->_("season_method_error")
       	       						));
	}
	public function setUp() {
		parent::setUp();
		
		$this->hasOne('Season as season',
							array('local' => 'seasonid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('Farm as farm',
							array('local' => 'farmid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('Commodity as crop',
							array('local' => 'cropid',
									'foreign' => 'id'
							)
						);
		$this->hasMany('Loan as activitycredit',
					 		array(
								'local' => 'id',
								'foreign' => 'activityid'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			$formvalues['status'] = NULL;
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			$formvalues['enddate'] = NULL;
		}
		if(isArrayKeyAnEmptyString('itemrate', $formvalues)){
			$formvalues['itemrate'] = NULL;
		}
		if(isArrayKeyAnEmptyString('itemtype', $formvalues)){
			$formvalues['itemtype'] = NULL;
		}
		if(isArrayKeyAnEmptyString('itemrateunit', $formvalues)){
			$formvalues['itemrateunit'] = NULL;
		}
		if(isArrayKeyAnEmptyString('totalapplied', $formvalues)){
			$formvalues['totalapplied'] = NULL;
		}
		if(isArrayKeyAnEmptyString('totalappliedunit', $formvalues)){
			$formvalues['totalappliedunit'] = NULL;
		}
		if(isArrayKeyAnEmptyString('totalexpenses', $formvalues)){
			$formvalues['totalexpenses'] = 0;
		}
		if(isArrayKeyAnEmptyString('timing', $formvalues)){
			$formvalues['timing'] = NULL;
		}
		
	if(!isArrayKeyAnEmptyString('financetype', $formvalues)){
			$formvalues['activitycredit'][0]['financetype'] = $formvalues['financetype'];
			$formvalues['activitycredit'][0]['farmerid'] = $formvalues['farmerid'];
			$formvalues['activitycredit'][0]['farmid'] = $formvalues['farmid'];
			$formvalues['activitycredit'][0]['activityid'] = $formvalues['id'];
			$formvalues['activitycredit'][0]['stage'] = $formvalues['stage'];
			$formvalues['activitycredit'][0]['type'] = $formvalues['type'];
			if(!isArrayKeyAnEmptyString('principal', $formvalues)){
				$formvalues['activitycredit'][0]['principal'] = isEmptyString($formvalues['principal']) ? NULL : $formvalues['principal'];
			}
			if(!isArrayKeyAnEmptyString('interestrate', $formvalues)){
				$formvalues['activitycredit'][0]['interestrate'] = isEmptyString($formvalues['interestrate']) ? NULL : $formvalues['interestrate'];
			}
			if(!isArrayKeyAnEmptyString('paybackamount', $formvalues)){
				$formvalues['activitycredit'][0]['paybackamount'] = isEmptyString($formvalues['paybackamount']) ? NULL : $formvalues['paybackamount'];
			}
			if(!isArrayKeyAnEmptyString('installment', $formvalues)){
				$formvalues['activitycredit'][0]['installment'] = isEmptyString($formvalues['installment']) ? NULL : $formvalues['installment'];
			}
			if(!isArrayKeyAnEmptyString('paybackperiod', $formvalues)){
				$formvalues['activitycredit'][0]['paybackperiod'] = isEmptyString($formvalues['paybackperiod']) ? NULL : $formvalues['paybackperiod'];
			}
			if(!isArrayKeyAnEmptyString('paybackperiodunit', $formvalues)){
				$formvalues['activitycredit'][0]['paybackperiodunit'] = isEmptyString($formvalues['paybackperiodunit']) ? NULL : $formvalues['paybackperiodunit'];
			}
			if(!isArrayKeyAnEmptyString('creditdate', $formvalues)){
				$formvalues['activitycredit'][0]['creditdate'] = isEmptyString($formvalues['creditdate']) ? NULL : changeDateFromPageToMySQLFormat($formvalues['creditdate']);
			}
			if(!isArrayKeyAnEmptyString('financesourceid', $formvalues)){
				$formvalues['activitycredit'][0]['financesourceid'] = isEmptyString($formvalues['financesourceid']) ? NULL : $formvalues['financesourceid'];
			}
			if(!isArrayKeyAnEmptyString('contract', $formvalues)){
				$formvalues['activitycredit'][0]['contract'] = isEmptyString($formvalues['contract']) ? NULL : $formvalues['contract'];
			}
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	# determine method display text
    function getMethodText() {
    	$text = '--';
    	if(!isEmptyString($this->getMethod())){
    		$values = getTreatmentMethods();
    		$text = $values[$this->getMethod()];
    	}
    	return $text;
    }
	# determine current status label
    function getStatusText() {
    	$text = '--';
    	if(!isEmptyString($this->getStatus())){
    		$values = getStatusValues();
    		$text = $values[$this->getStatus()];
    	}
    	return $text;
    }
	# determine item rate units
    function getItemRateUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getItemRateUnit())){
    		$values = getTreatmentMeasureUnits();
    		$text = $values[$this->getItemRateUnit()];
    	}
    	return $text;
    }
	# determine item quantity units
    function getTotalAppliedUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getTotalAppliedUnit())){
    		$values = getTreatmentTotalUnits();
    		$text = $values[$this->getTotalAppliedUnit()];
    	}
    	return $text;
    }
	# determine item type label
    function getItemTypeText() {
    	$text = '--';
    	if(!isEmptyString($this->getItemType())){
    		$values = getTreatmentSubTypes();
    		$text = $values[$this->getItemType()];
    	}
    	return $text;
    }
	# determine item type label
    function getItemFormText() {
    	$text = '--';
    	if(!isEmptyString($this->getItemForm())){
    		$values = getTreatmentForms();
    		$text = $values[$this->getItemForm()];
    	}
    	return $text;
    }
	# determine timing display text
    function getTimingText() {
    	$text = '--';
    	if(!isEmptyString($this->getTiming())){
    		$values = getTimingValues();
    		$text = $values[$this->getTiming()];
    	}
    	return $text;
    }
	# determine timing display text
    function getActivityName() {
    	$text = '--';
    	if(!isEmptyString($this->getItemName())){
    		$text = $this->getItemName();
    	}
    	return $text;
    }
	# generate next activity reference counter
    function getNextReferencePointer() {
    	$conn = Doctrine_Manager::connection();
    	$session = SessionWrapper::getInstance();
    	$farmerid = $session->getVar('farmerid');
		$sql = "SELECT COUNT(id) FROM seasonactivity WHERE seasonid = ".$this->getSeasonID()." "; 
		$result = $conn->fetchOne($sql);
		return str_pad(($result+1), 3, "0", STR_PAD_LEFT);
    }
	# determine credit history for activity
	function getCreditDetails() {
    	$q = Doctrine_Query::create()->from('loan l')->where("l.activityid = '".$this->getID()."'");
		$result = $q->execute();
		return $result->get(0);
	}
	# determine all expenses for entry
	function getExpensesDetails(){
    	$q = Doctrine_Query::create()->from('SeasonInputDetail s')->where("s.plantingid = '".$this->getID()."' ")->orderby('s.inputdate DESC');
		$result = $q->execute();
		return $result;
	}
	# determine total expenses for the expense
	function getActivityExpenseAmount(){
		$expenselines = $this->getExpensesDetails();
		$expensetotal = 0;
		if($expenselines){
			foreach ($expenselines as $expense){
				$expensetotal += isEmptyString($expense->getAmount()) ? 0 : $expense->getAmount();
			}
		}
		return $expensetotal;
	}
}

?>