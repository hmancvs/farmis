<?php

/**
 * Model for sales
 *
 */

class Sales extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('sales');
		$this->hasColumn('farmid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('farmerid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('seasonid', 'integer', null);
		$this->hasColumn('cropid', 'integer', null);
		$this->hasColumn('ref', 'string', 50);
		$this->hasColumn('type', 'integer', null, array('default' => 1)); // 1 Season, 2 Non Season/Other sales
		
		$this->hasColumn('startdate','date', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('enddate','date', null);
		$this->hasColumn('status', 'integer', null, array('default' => 3));
		$this->hasColumn('quantity', 'integer', null);
		$this->hasColumn('quantityunit', 'integer', null);
		$this->hasColumn('unitprice', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('totalamount', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('totalexpenses', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('clienttype', 'integer', null);
		$this->hasColumn('contract','string', 255);
		$this->hasColumn('clientname','string', 255);
		$this->hasColumn('clientphone','string', 255);
		$this->hasColumn('addtodir', 'integer', null);
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
       									"farmerid.notblank" => $this->translate->_("season_farmerid_error"),
       									"farmid.notblank" => $this->translate->_("season_farmid_error"),
       									"startdate.notblank" => $this->translate->_("season_activitydate_error")
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
		$this->hasOne('Farmer as farmer', 
							array(
								'local' => 'farmerid',
								'foreign' => 'id'
							)
						);
		$this->hasOne('Commodity as crop',
							array('local' => 'cropid',
									'foreign' => 'id'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		}
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']); 
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			unset($formvalues['enddate']); 
		}
		if(isArrayKeyAnEmptyString('cropid', $formvalues)){
			unset($formvalues['cropid']); 
		}
		if(isArrayKeyAnEmptyString('seasonid', $formvalues)){
			unset($formvalues['seasonid']); 
		}
		if(isArrayKeyAnEmptyString('quantity', $formvalues)){
			$formvalues['quantity'] = 0; 
		}
		if(isArrayKeyAnEmptyString('quantityunit', $formvalues)){
			unset($formvalues['quantityunit']); 
		}
		if(isArrayKeyAnEmptyString('unitprice', $formvalues)){
			$formvalues['unitprice'] = 0;  
		}
		if(isArrayKeyAnEmptyString('totalamount', $formvalues)){
			$formvalues['totalamount'] = 0; 
		}
		if(isArrayKeyAnEmptyString('totalexpenses', $formvalues)){
			$formvalues['totalexpenses'] = 0; 
		}
		if(isArrayKeyAnEmptyString('clienttype', $formvalues)){
			unset($formvalues['clienttype']); 
		}
		parent::processPost($formvalues);
	}
	# generate next activity reference counter
    function getNextReferencePointer() {
    	$conn = Doctrine_Manager::connection();
    	$session = SessionWrapper::getInstance();
    	$farmerid = $session->getVar('farmerid');
		$sql = "SELECT COUNT(id) FROM sales WHERE seasonid = ".$this->getSeasonID()." "; 
		$result = $conn->fetchOne($sql);
		return str_pad(($result+1), 3, "0", STR_PAD_LEFT);
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
	# determine item quantity units
    function getQuantityUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getQuantityUnit())){
    		$values = getHarvestQuantityUnits();
    		$text = $values[$this->getQuantityUnit()];
    	}
    	return $text;
    }
	# determine item quantity units
    function getClientTypeText() {
    	$text = '--';
    	if(!isEmptyString($this->getClientType())){
    		$values = getSaleToTypes();
    		$text = $values[$this->getClientType()];
    	}
    	return $text;
    }
	# determine all expenses for entry
	function getExpensesDetails() {
    	$q = Doctrine_Query::create()->from('SeasonInputDetail s')->where("s.saleid = '".$this->getID()."'")->orderby('s.inputdate DESC');
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
    	$q = Doctrine_Query::create()->from('Notes n')->where("n.saleid = '".$this->getID()."'")->orderby('n.datenoted DESC');
		$result = $q->execute();
		return $result;
	}
}

?>