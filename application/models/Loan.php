<?php

/**
 * Model for sales
 *
 */

class Loan extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('loan');
		$this->hasColumn('farmid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('farmerid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('seasonid', 'integer', null);
		$this->hasColumn('type', 'integer', null, array('default' => 1)); // 1 Season, 2 Non Season/Other sales
		
		$this->hasColumn('inventoryid', 'integer', null);
		$this->hasColumn('inputid', 'integer', null);
		$this->hasColumn('tillageid', 'integer', null);	
		$this->hasColumn('plantingid', 'integer', null);
		$this->hasColumn('trackingid', 'integer', null);
		$this->hasColumn('activityid', 'integer', null);
		$this->hasColumn('harvestid', 'integer', null);	
		$this->hasColumn('saleid', 'integer', null);
		
		$this->hasColumn('principal', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('interestrate', 'integer', null);
		$this->hasColumn('installment', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('installmentunit', 'integer', null);
		$this->hasColumn('paybackamount', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('paybackperiod', 'integer', null);
		$this->hasColumn('paybackperiodunit', 'integer', null);
		$this->hasColumn('creditdate','date', null);
		$this->hasColumn('sourcetype', 'integer', null);
		$this->hasColumn('financesourceid', 'integer', null);
		$this->hasColumn('financesourcetext','string', 255);
		$this->hasColumn('clienttype', 'integer', null);
		$this->hasColumn('clientid', 'integer', null);
		$this->hasColumn('clienttext','string', 255);
		$this->hasColumn('stage', 'integer', null);
		$this->hasColumn('contract', 'string', 1000);
		$this->hasColumn('quantity', 'integer', null);
		$this->hasColumn('quantityunit', 'integer', null);
		$this->hasColumn('price', 'decimal', 11, array('default' => '0'));
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
       									"farmid.notblank" => $this->translate->_("season_farmid_error")
       	       						));
	}
	public function setUp() {
		parent::setUp();
		
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
		$this->hasOne('Season as season',
							array('local' => 'seasonid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('Inventory as inventory',
							array('local' => 'inventoryid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonInput as input',
							array('local' => 'inputid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonTillage as tillage',
							array('local' => 'tillageid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonPlanting as planting',
							array('local' => 'plantingid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonTracking as treatment',
							array('local' => 'trackingid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonActivity as activity',
							array('local' => 'activityid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonHarvest as harvest',
							array('local' => 'harvestid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('Sales as sale',
							array('local' => 'saleid',
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
		if(isArrayKeyAnEmptyString('farmerid', $formvalues)){
			unset($formvalues['farmerid']); 
		}
		if(isArrayKeyAnEmptyString('farmid', $formvalues)){
			unset($formvalues['farmid']); 
		}
		if(isArrayKeyAnEmptyString('seasonid', $formvalues)){
			unset($formvalues['seasonid']); 
		}
		if(isArrayKeyAnEmptyString('inventoryid', $formvalues)){
			unset($formvalues['inventoryid']); 
		}
		if(isArrayKeyAnEmptyString('notedbyid', $formvalues)){
			unset($formvalues['notedbyid']); 
		}
		if(isArrayKeyAnEmptyString('inputid', $formvalues)){
			$formvalues['inputid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('tillageid', $formvalues)){
			$formvalues['tillageid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('plantingid', $formvalues)){
			$formvalues['plantingid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('trackingid', $formvalues)){
			$formvalues['trackingid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('activityid', $formvalues)){
			$formvalues['activityid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('harvestid', $formvalues)){
			$formvalues['harvestid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('saleid', $formvalues)){
			$formvalues['saleid'] = NULL;
		}
		
		isArrayKeyAnEmptyString('principal', $formvalues) ? $formvalues['principal'] = NULL : $formvalues['principal'] = $formvalues['principal'];
		isArrayKeyAnEmptyString('interestrate', $formvalues) ? $formvalues['interestrate'] = NULL : $formvalues['interestrate'] = $formvalues['interestrate'];
		isArrayKeyAnEmptyString('paybackamount', $formvalues) ? $formvalues['paybackamount'] = NULL : $formvalues['paybackamount'] = $formvalues['paybackamount'];
		isArrayKeyAnEmptyString('installment', $formvalues) ? $formvalues['installment'] = NULL : $formvalues['installment'] = $formvalues['installment'];
		isArrayKeyAnEmptyString('installmentunit', $formvalues) ? $formvalues['installmentunit'] = NULL : $formvalues['installmentunit'] = $formvalues['installmentunit'];
		isArrayKeyAnEmptyString('paybackperiod', $formvalues) ? $formvalues['paybackperiod'] = NULL : $formvalues['paybackperiod'] = $formvalues['paybackperiod'];
		isArrayKeyAnEmptyString('paybackperiodunit', $formvalues) ? $formvalues['paybackperiodunit'] = NULL : $formvalues['paybackperiodunit'] = $formvalues['paybackperiodunit'];
		isArrayKeyAnEmptyString('creditdate', $formvalues) ? $formvalues['creditdate'] = NULL : $formvalues['creditdate'] = $formvalues['creditdate'];
		isArrayKeyAnEmptyString('financesourceid', $formvalues) ? $formvalues['financesourceid'] = NULL : $formvalues['financesourceid'] = $formvalues['financesourceid'];
		isArrayKeyAnEmptyString('financesourcetext', $formvalues) ? $formvalues['financesourcetext'] = NULL : $formvalues['financesourcetext'] = $formvalues['financesourcetext'];
		isArrayKeyAnEmptyString('clientid', $formvalues) ? $formvalues['clientid'] = NULL : $formvalues['clientid'] = $formvalues['clientid'];
		isArrayKeyAnEmptyString('quantity', $formvalues) ? $formvalues['quantity'] = NULL : $formvalues['quantity'] = $formvalues['quantity'];
		isArrayKeyAnEmptyString('quantityunit', $formvalues) ? $formvalues['quantityunit'] = NULL : $formvalues['quantityunit'] = $formvalues['quantityunit'];
		isArrayKeyAnEmptyString('price', $formvalues) ? $formvalues['price'] = NULL : $formvalues['price'] = $formvalues['price'];
		isArrayKeyAnEmptyString('clienttype', $formvalues) ? $formvalues['clienttype'] = NULL : $formvalues['clienttype'] = $formvalues['clienttype'];
		isArrayKeyAnEmptyString('sourcetype', $formvalues) ? $formvalues['sourcetype'] = NULL : $formvalues['sourcetype'] = $formvalues['sourcetype'];
		isArrayKeyAnEmptyString('contract', $formvalues) ? $formvalues['contract'] = NULL : $formvalues['contract'] = $formvalues['contract'];
		// debugMessage($formvalues); // exit();
		parent::processPost($formvalues);
	}
	# determine payback period duration
	function getPayBackPeriodText() {
		$univalues = getLoanFrequencyValues();
		if(!isEmptyString($this->getPayBackPeriodUnit())){
			return $this->getPayBackPeriod()." ".$univalues[$this->getPayBackPeriodUnit()];
		}
		return '--';
	}
	# determine payback period duration
	function getInstallmentText() {
		$univalues = getLoanRepaymentFrequencyValues();
		$text = '--';
		if(!isEmptyString($this->getInstallment()) && !isEmptyString($this->getInstallmentUnit())) {
			return formatMoney($this->getInstallment())." / ".$univalues[$this->getInstallmentUnit()];
		}
		return $text;
	}
	# determine full name of the credit source institution
	function getFinancialSourceValue() {
		if(isEmptyString($this->getFinanceSourceID())){
			return '--';
		}
		$allsources = getAllFinancialInstitutions();
		return $allsources[$this->getFinanceSourceID()];
	}
	# determine the loan payment histry
    function getPaymentDetails(){
    	// l.farmid = '".$this->getID()."'
    	$q = Doctrine_Query::create()->from('LoanPayment lp')->where("lp.loanid = '".$this->getID()."'")->orderby('lp.paymentdate DESC');
		$result = $q->execute();
		return $result;
    }
	# determine full name of the client
	function getTheClient() {
		if(isEmptyString($this->getClientID())){
			return '--';
		}
		$allclients = getAllClients();
		return $allclients[$this->getClientID()];
	}
}
?>