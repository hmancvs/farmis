<?php

/**
 * Model for season planting
 *
 */

class SeasonPlanting extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('seasonplanting');
		$this->hasColumn('seasonid', 'integer', null, array('notnull' => true, 'notblank' => true));	
		$this->hasColumn('farmid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('cropid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('ref', 'string', 50);
		$this->hasColumn('activityname', 'string', 255);
		$this->hasColumn('startdate','date', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('enddate','date', null);
		$this->hasColumn('method', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('status', 'integer', null, array('default' => 1));
		$this->hasColumn('seedingrate', 'integer', null);
		$this->hasColumn('seedingrateunit', 'integer', null);
		$this->hasColumn('totalplanted', 'integer', null);
		$this->hasColumn('totalplantedunit', 'integer', null);
		$this->hasColumn('fieldsize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('fieldsizeunit', 'integer', null);
		$this->hasColumn('financetype', 'integer', null, array('default' => '1'));
		$this->hasColumn('totalexpenses', 'decimal', 11, array('default' => '0'));
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
       									"farmid.notblank" => $this->translate->_("seasontillage_farmid_error"),
       									"seasonid.notblank" => $this->translate->_("seasontillage_seasonid_error"),
       									"cropid.notblank" => $this->translate->_("seasontillage_cropid_error"),
       									"startdate.notblank" => $this->translate->_("seasontillage_activitydate_error"),
       									"method.notblank" => $this->translate->_("seasontillage_method_error")
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
								'foreign' => 'plantingid'
							)
						);
		$this->hasMany('SeasonLabour as labourdetails',
					 		array(
								'local' => 'id',
								'foreign' => 'plantingid'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']); 
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			unset($formvalues['enddate']); 
		}
		if(isArrayKeyAnEmptyString('seedingrate', $formvalues)){
			unset($formvalues['seedingrate']); 
		}
		if(isArrayKeyAnEmptyString('seedingrateunit', $formvalues)){
			unset($formvalues['seedingrateunit']); 
		}
		if(isArrayKeyAnEmptyString('totalplanted', $formvalues)){
			unset($formvalues['totalplanted']); 
		}
		if(isArrayKeyAnEmptyString('fieldsize', $formvalues)){
			unset($formvalues['fieldsize']); 
		}
		if(isArrayKeyAnEmptyString('fieldsizeunit', $formvalues)){
			unset($formvalues['fieldsizeunit']); 
		}
		
	if(!isArrayKeyAnEmptyString('financetype', $formvalues)){
			if($formvalues['financetype'] == 3 || $formvalues['financetype'] == 4 || $formvalues['financetype'] == 5){
				$formvalues['activitycredit'][0]['financetype'] = $formvalues['financetype'];
				$formvalues['activitycredit'][0]['farmerid'] = $formvalues['farmerid'];
				$formvalues['activitycredit'][0]['farmid'] = $formvalues['farmid'];
				$formvalues['activitycredit'][0]['stage'] = $formvalues['stage'];
				$formvalues['activitycredit'][0]['type'] = $formvalues['type'];
				isArrayKeyAnEmptyString('principal', $formvalues) ? $formvalues['activitycredit'][0]['principal'] = NULL : $formvalues['activitycredit'][0]['principal'] = $formvalues['principal'];
				isArrayKeyAnEmptyString('interestrate', $formvalues) ? $formvalues['activitycredit'][0]['interestrate'] = NULL : $formvalues['activitycredit'][0]['interestrate'] = $formvalues['interestrate'];
				isArrayKeyAnEmptyString('paybackamount', $formvalues) ? $formvalues['activitycredit'][0]['paybackamount'] = NULL : $formvalues['activitycredit'][0]['paybackamount'] = $formvalues['paybackamount'];
				isArrayKeyAnEmptyString('installment', $formvalues) ? $formvalues['activitycredit'][0]['installment'] = NULL : $formvalues['activitycredit'][0]['installment'] = $formvalues['installment'];
				isArrayKeyAnEmptyString('installmentunit', $formvalues) ? $formvalues['activitycredit'][0]['installmentunit'] = NULL : $formvalues['activitycredit'][0]['installmentunit'] = $formvalues['installmentunit'];
				isArrayKeyAnEmptyString('paybackperiod', $formvalues) ? $formvalues['activitycredit'][0]['paybackperiod'] = NULL : $formvalues['activitycredit'][0]['paybackperiod'] = $formvalues['paybackperiod'];
				isArrayKeyAnEmptyString('paybackperiodunit', $formvalues) ? $formvalues['activitycredit'][0]['paybackperiodunit'] = NULL : $formvalues['activitycredit'][0]['paybackperiodunit'] = $formvalues['paybackperiodunit'];
				isArrayKeyAnEmptyString('creditdate', $formvalues) ? $formvalues['activitycredit'][0]['creditdate'] = NULL : $formvalues['activitycredit'][0]['creditdate'] = changeDateFromPageToMySQLFormat($formvalues['creditdate']);
				isArrayKeyAnEmptyString('financesourceid', $formvalues) ? $formvalues['activitycredit'][0]['financesourceid'] = NULL : $formvalues['activitycredit'][0]['financesourceid'] = $formvalues['financesourceid'];
				isArrayKeyAnEmptyString('financesourcetext', $formvalues) ? $formvalues['activitycredit'][0]['financesourcetext'] = NULL : $formvalues['activitycredit'][0]['financesourcetext'] = $formvalues['financesourcetext'];
				isArrayKeyAnEmptyString('clientid', $formvalues) ? $formvalues['activitycredit'][0]['clientid'] = NULL : $formvalues['activitycredit'][0]['clientid'] = $formvalues['clientid'];
				isArrayKeyAnEmptyString('quantity', $formvalues) ? $formvalues['activitycredit'][0]['quantity'] = NULL : $formvalues['activitycredit'][0]['quantity'] = $formvalues['quantity'];
				isArrayKeyAnEmptyString('quantityunit', $formvalues) ? $formvalues['activitycredit'][0]['quantityunit'] = NULL : $formvalues['activitycredit'][0]['quantityunit'] = $formvalues['quantityunit'];
				isArrayKeyAnEmptyString('price', $formvalues) ? $formvalues['activitycredit'][0]['price'] = NULL : $formvalues['activitycredit'][0]['price'] = $formvalues['price'];
				isArrayKeyAnEmptyString('clienttype', $formvalues) ? $formvalues['activitycredit'][0]['clienttype'] = NULL : $formvalues['activitycredit'][0]['clienttype'] = $formvalues['clienttype'];
				isArrayKeyAnEmptyString('sourcetype', $formvalues) ? $formvalues['activitycredit'][0]['sourcetype'] = NULL : $formvalues['activitycredit'][0]['sourcetype'] = $formvalues['sourcetype'];
				isArrayKeyAnEmptyString('contract', $formvalues) ? $formvalues['activitycredit'][0]['contract'] = NULL : $formvalues['activitycredit'][0]['contract'] = $formvalues['contract'];
			} else {
				$formvalues['activitycredit'] = array();
			}
		}
		
		# process season labour details
		$detailsarray = array();
		if(!isArrayKeyAnEmptyString('labourdetails', $formvalues)){
			foreach ($formvalues['labourdetails'] as $key => $value){
				if(isEmptyString($value['activityname'])){
					unset($value[$key]);
				} else {
					$countfields = array('itempaid','fieldsize','fieldsizeunit');
					foreach ($value as $thekey => $thevalue){
						if(isEmptyString($thevalue)){
							if(in_array($thekey, $countfields)){
								$value[$thekey] = NULL;
							} else {
								$value[$thekey] = 0;
							}
						}
					}
					$detailsarray[$key] = $value;
					if(!isArrayKeyAnEmptyString('id', $value)){
						$detailsarray[$key]['id'] = $value['id'];
					}
					$detailsarray[$key]['farmerid'] = $formvalues['farmerid'];
					$detailsarray[$key]['farmid'] = $formvalues['farmid'];
					$detailsarray[$key]['seasonid'] = $formvalues['seasonid'];
					if(!isArrayKeyAnEmptyString('labourdetails_fieldsizeunit_'.$key, $formvalues)){
						$detailsarray[$key]['fieldsizeunit'] = $formvalues['labourdetails_fieldsizeunit_'.$key];
					} else {
						$detailsarray[$key]['fieldsizeunit'] = NULL;
					}
				}
			}
			// unset($formvalues['labourdetails']);
		}
		if(count($detailsarray) > 0){
			$formvalues['labourdetails'] = $detailsarray;
		} else {
			$formvalues['labourdetails'] = array();
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	# after save custom logic
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	$loan = $this->getCreditDetails();
    	if(!isEmptyString($loan->getID())){
    		$loan->setPlantingID($this->getID());
    		$loan->save();
    	}
    	// exit();
    	return true;
    }
    # after update custom logic
	function afterUpdate(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
		$loan = $this->getCreditDetails();
    	if(!isEmptyString($loan->getID())){
    		$loan->setPlantingID($this->getID());
    		$loan->save();
    	}
    	// exit();
    	return true;
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
	# determine tillage method
    function getMethodText() {
    	$text = '--';
    	if(!isEmptyString($this->getMethod())){
    		$values = getPlantingMethods();
    		$text = $values[$this->getMethod()];
    	}
    	return $text;
    }
	# determine seeding rate units
    function getSeedingRateUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getSeedingRateUnit())){
    		$values = getSeedingUnits();
    		$text = $values[$this->getSeedingRateUnit()];
    	}
    	return $text;
    }
	# determine field size units
    function getFieldSizeUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getFieldSizeUnit())){
    		$values = getAreaUnits();
    		$text = $values[$this->getFieldSizeUnit()];
    	}
    	return $text;
    }
	# determine planting units
    function getTotalPlantedUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getTotalPlantedUnit())){
    		$values = getHarvestQuantityUnits();
    		$text = $values[$this->getTotalPlantedUnit()];
    	}
    	return $text;
    }
	# generate next activity reference counter
    function getNextReferencePointer() {
    	$conn = Doctrine_Manager::connection();
    	$session = SessionWrapper::getInstance();
    	$farmerid = $session->getVar('farmerid');
		$sql = "SELECT COUNT(id) FROM seasonplanting WHERE seasonid = ".$this->getSeasonID()." "; 
		$result = $conn->fetchOne($sql);
		return str_pad(($result+1), 3, "0", STR_PAD_LEFT);
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
	# determine all notes for entry
	function getNotesDetails() {
    	$q = Doctrine_Query::create()->from('Notes n')->where("n.plantingid = '".$this->getID()."'")->orderby('n.datenoted DESC');
		$result = $q->execute();
		return $result;
	}
	# determine credit history for activity
	function getCreditDetails() {
    	$q = Doctrine_Query::create()->from('Loan l')->where("l.plantingid = '".$this->getID()."'");
		$result = $q->execute();
		return $result->get(0);
	}
	# determine the family labour history
	function getFamilyLabourDetails() {
    	$q = Doctrine_Query::create()->from('SeasonLabour l')->where("l.plantingid = '".$this->getID()."' AND l.type = 1 ");
		$result = $q->execute();
		return $result;
	}
	# determine the hired labour history
	function getHiredLabourDetails() {
    	$q = Doctrine_Query::create()->from('SeasonLabour l')->where("l.plantingid = '".$this->getID()."' AND l.type = 2 ");
		$result = $q->execute();
		return $result;
	}
	# determine the total labor cost
	function getTotalLaborCost() {
		$labourdetails = $this->getHiredLabourDetails();
		$sumamount = 0;
		foreach($labourdetails as $labour){
			$sumamount += $labour->getamount();
		}
		return $sumamount;
	}
}

?>