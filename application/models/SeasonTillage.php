<?php

/**
 * Model for season tillage
 *
 */

class SeasonTillage extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('seasontillage');
		$this->hasColumn('seasonid', 'integer', null, array('notnull' => true, 'notblank' => true));	
		$this->hasColumn('farmid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('ref', 'string', 50);
		$this->hasColumn('activityname', 'string', 255);
		$this->hasColumn('startdate','date', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('enddate','date', null);
		$this->hasColumn('method', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('primaryimplements', 'string', 500); 
		$this->hasColumn('secondaryimplements', 'string', 500); 
		$this->hasColumn('status', 'integer', null, array('default' => '3'));
		$this->hasColumn('fieldsize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('fieldsizeunit', 'integer', null, array('default' => '4'));
		$this->hasColumn('depth', 'integer', null);
		$this->hasColumn('depthunit', 'integer', null, array('default' => '1'));
		$this->hasColumn('width', 'integer', null);
		$this->hasColumn('widthunit', 'integer', null, array('default' => '1'));
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
		$this->hasMany('Loan as activitycredit',
					 		array(
								'local' => 'id',
								'foreign' => 'tillageid'
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
		if(isArrayKeyAnEmptyString('fieldsize', $formvalues)){
			unset($formvalues['fieldsize']); 
		}
		if(isArrayKeyAnEmptyString('fieldsizeunit', $formvalues)){
			unset($formvalues['fieldsizeunit']); 
		}
		if(isArrayKeyAnEmptyString('depth', $formvalues)){
			unset($formvalues['depth']); 
		}
		if(isArrayKeyAnEmptyString('depthunit', $formvalues)){
			unset($formvalues['depthunit']); 
		}
		if(isArrayKeyAnEmptyString('heightunit', $formvalues)){
			unset($formvalues['depthunit']); 
		}
		if(isArrayKeyAnEmptyString('width', $formvalues)){
			unset($formvalues['width']); 
		}
		if(isArrayKeyAnEmptyString('widthunit', $formvalues)){
			unset($formvalues['widthunit']); 
		}
		if(!isArrayKeyAnEmptyString('primaryimplements', $formvalues)){
			if(is_array($formvalues['primaryimplements'])){
				$formvalues['primaryimplements'] = implode(',', $formvalues['primaryimplements']);
			} else {
				$formvalues['primaryimplements'] = NULL;
			}
		} else {
			$formvalues['primaryimplements'] = NULL;
		}
		if(!isArrayKeyAnEmptyString('secondaryimplements', $formvalues)){
			if(is_array($formvalues['secondaryimplements'])){
				$formvalues['secondaryimplements'] = implode(',', $formvalues['secondaryimplements']);
			} else {
				$formvalues['secondaryimplements'] = NULL;
			}
		} else {
			$formvalues['secondaryimplements'] = NULL;
		}
		
		if(!isArrayKeyAnEmptyString('financetype', $formvalues)){
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
		}
		//debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	# after save custom logic
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	/*$loan = $this->getCreditDetails();
    	if(!isEmptyString($loan->getID())){
    		$loan->setTillageID($this->getID());
    		$loan->save();
    	}*/
    	// exit();
    	return true;
    }
    # after update custom logic
	function afterUpdate(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
		/*$loan = $this->getCreditDetails();
    	if(!isEmptyString($loan->getID())){
    		$loan->setTillageID($this->getID());
    		$loan->save();
    	}*/
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
    		$values = getTillageMethods();
    		$text = $values[$this->getMethod()];
    	}
    	return $text;
    }
	# determine tillage depth units
    function getDepthUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getDepthUnit())){
    		$values = getDepthUnits();
    		$text = $values[$this->getDepthUnit()];
    	}
    	return $text;
    }
	# determine tillage width units
    function getWidthUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getWidthUnit())){
    		$values = getDepthUnits();
    		$text = $values[$this->getWidthUnit()];
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
    # determine the primary implements text
    function getPrimaryImplementsText(){
    	$text = '--';
    	if(!isEmptyString($this->getPrimaryImplements())){
    		$allvalues = getPrimaryTillageMethods();
    		$values_array = explode(',', $this->getPrimaryImplements());
    		
    		$list_array = array();
    		foreach ($values_array as $key => $imp){
    			$list_array[$imp] = $allvalues[$imp];
    		}
    		$text = implode(", ", $list_array);
    	}
    	return $text;
    }
    # determine the secondary implements text
	function getSecondaryImplementsText(){
    	$text = '--';
    	if(!isEmptyString($this->getSecondaryImplements())){
    		$allvalues = getSecondaryTillageMethods();
    		$values_array = explode(',', $this->getSecondaryImplements());
    		
    		$list_array = array();
    		foreach ($values_array as $key => $imp){
    			$list_array[$imp] = $allvalues[$imp];
    		}
    		$text = implode(", ", $list_array);
    	}
    	return $text;
    }
	# determine the primary implements as an array
    function getPrimaryImplementsArray(){
    	$current_array = array();
    	if(!isEmptyString($this->getPrimaryImplements())){
    		$current_array = explode(',', $this->getPrimaryImplements());
    	}
    	return $current_array;
    }
	# determine the secondary implements as an array
    function getSecondaryImplementsArray(){
    	$current_array = array();
    	if(!isEmptyString($this->getSecondaryImplements())){
    		$current_array = explode(',', $this->getSecondaryImplements());
    	}
    	return $current_array;
    }
	# generate next activity reference counter
    function getNextReferencePointer() {
    	$conn = Doctrine_Manager::connection();
    	$session = SessionWrapper::getInstance();
    	$farmerid = $session->getVar('farmerid');
		$sql = "SELECT COUNT(id) FROM seasontillage WHERE seasonid = ".$this->getSeasonID()." "; 
		$result = $conn->fetchOne($sql);
		return str_pad(($result+1), 3, "0", STR_PAD_LEFT);
    }
	# determine all expenses for entry
	function getExpensesDetails() {
    	$q = Doctrine_Query::create()->from('SeasonInputDetail s')->where("s.tillageid = '".$this->getID()."'")->orderby('s.inputdate DESC');
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
    	$q = Doctrine_Query::create()->from('Notes n')->where("n.tillageid = '".$this->getID()."'")->orderby('n.datenoted DESC');
		$result = $q->execute();
		return $result;
	}
	# determine credit history for activity
	function getCreditDetails() {
    	$q = Doctrine_Query::create()->from('Loan l')->where("l.tillageid = '".$this->getID()."'");
		$result = $q->execute();
		return $result->get(0);
	}
}

?>