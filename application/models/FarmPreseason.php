<?php

class FarmPreseason extends BaseEntity {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('farmpreseason');
		$this->hasColumn('userid', 'integer', null);
		$this->hasColumn('farmerid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('farmid', 'integer', null);
		$this->hasColumn('startday', 'string', 4);
		$this->hasColumn('startmonth', 'string', 4);
		$this->hasColumn('startyear', 'string', 4);
		$this->hasColumn('endday', 'string', 4);
		$this->hasColumn('endmonth', 'string', 4);
		$this->hasColumn('endyear', 'string', 4);
		$this->hasColumn('prevrevenue', 'decimal', 10, array('default' => 0));
		$this->hasColumn('prevprofit', 'decimal', 10, array('default' => 0));
		$this->hasColumn('prevexpenses', 'decimal', 10, array('default' => 0));
		$this->hasColumn('loanid', 'integer', null);
		$this->hasColumn('usedloan', 'integer', null);
		$this->hasColumn('notes','string', 1000);
	}
	/**
	 * Contructor method for custom initialization
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"farmerid.notblank" => $this->translate->_("farm_farmerid_error")
       	       						));
	}
	/**
	 * Model relationships
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('UserAccount as user', 
								array(
									'local' => 'userid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('Farmer as farmer', 
								array(
									'local' => 'farmerid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('Farm as farm', 
								array(
									'local' => 'farmid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('Loan as loan',
							array('local' => 'loanid',
									'foreign' => 'id'
							)
						);
		$this->hasMany('FarmPreseasonDetail as details',
						 array(
								'local' => 'id',
								'foreign' => 'preseasonid'
							)
					);
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
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']); 
		}
		if(isArrayKeyAnEmptyString('farmerid', $formvalues)){
			unset($formvalues['farmerid']); 
		}
		if(isArrayKeyAnEmptyString('farmid', $formvalues)){
			unset($formvalues['farmid']); 
		}
		if(isArrayKeyAnEmptyString('loanid', $formvalues)){
			unset($formvalues['loanid']); 
		}
		if(isArrayKeyAnEmptyString('isdefault', $formvalues)){
			unset($formvalues['isdefault']); 
		}
		if(isArrayKeyAnEmptyString('usedloan', $formvalues)){
			$formvalues['usedloan'] = NULL; 
		}
		
        // debugMessage($formvalues); 
        // exit();
		parent::processPost($formvalues);
	}
	# start period
	function getFullStartDate() {
		$date = "--";
		if(!isEmptyString($this->getStartYear())){
			$date = $this->getStartYear();
		}
		if(!isEmptyString($this->getStartMonth()) && !isEmptyString($this->getStartYear())){
			$months = getAllMonthsAsShortNames();
			$date = $months[$this->getStartMonth()].", ".$this->getStartYear();
		}
		return $date;
	}
	# the projected end date
	function getFullEndDate() {
		$date = "--";
		if(!isEmptyString($this->geEndYear())){
			$date = $this->getEndYear();
		}
		if(!isEmptyString($this->getEndMonth()) && !isEmptyString($this->getEndYear())){
			$months = getAllMonthsAsShortNames();
			$date = $months[$this->getEndMonth()].", ".$this->getEndYear();
		}
		return $date;
	}
	# determine if farmer has estimates for previous 
	function getPreseasonEstimatesStatus(){
		$details = $this->getDetails();
		$details_count = $details->count();
		$total = 0;
		$count = 0;
		if($this->getFarm()->hasPreviousSeason()){
			$total += 10;
		}
		$count += 10; 
		if(!isEmptyString($this->getStartYear())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getEndYear())){
			$total += 10;
		} 
		$count += 10;
		
		if($details_count > 0){
			$total += 10;
			foreach ($details as $history){
				if(!isEmptyString($history->getsaletype())){
					$total += 10;
				}
				$count += 10;
				if(!isEmptyString($history->getfieldsize())){
					$total += 10;
				}
				$count += 10;
				if(!isEmptyString($history->gettotalplanted())){
					$total += 10;
				}
				$count += 10;
				if(!isEmptyString($history->gettotalharvest())){
					$total += 10;
				}
				$count += 10;
				if(!isEmptyString($history->getquantitysold())){
					$total += 10;
				}
				$count += 10;
				if(!isEmptyString($history->getunitprice())){
					$total += 10;
				}
				$count += 10;
				if(!isEmptyString($history->gettotalsalesamount())){
					$total += 10;
				}
				$count += 10;
			}
			$count += 10;
		}
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
}

?>