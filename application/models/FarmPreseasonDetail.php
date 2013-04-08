<?php

class FarmPreseasonDetail extends BaseRecord {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('farmpreseasondetail');
		$this->hasColumn('preseasonid', 'integer', null);
		$this->hasColumn('farmid', 'integer', null);
		$this->hasColumn('cropid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('fieldsize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('fieldsizeunit', 'integer', null);
		$this->hasColumn('inputsource', 'string', 255);
		$this->hasColumn('totalplanted', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('totalplantedunit', 'integer', null);
		$this->hasColumn('yield', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('yieldunit', 'integer', null);
		$this->hasColumn('totalharvest', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('totalharvestunit', 'integer', null);
		$this->hasColumn('quantitysold', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('quantitysoldunit', 'integer', null);
		$this->hasColumn('unitprice', 'decimal', 10, array('default' => '0'));
		$this->hasColumn('totalsalesamount', 'decimal', 10, array('default' => '0'));
		$this->hasColumn('totalexpenseamount', 'decimal', 10, array('default' => '0'));
		$this->hasColumn('saletype', 'integer', null);
		$this->hasColumn('productionconstraints','string', 500);
		$this->hasColumn('marketingconstraints','string', 500);
		$this->hasColumn('transactionconstraints','string', 500);
		$this->hasColumn('nextseasonrevenue', 'decimal', 10, array('default' => '0'));
		$this->hasColumn('nextseasonprodn', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('nextseasonprodnunit', 'integer', null);
		$this->hasColumn('financetype', 'integer', null, array('default' => '0'));
	}
	/**
	 * Contructor method for custom initialization
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("regdate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"cropid.notblank" => $this->translate->_("farm_preseasoncrop_error")
       	       						));
	}
	/**
	 * Model relationships
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('FarmPreseason as preseason',
						 array(
								'local' => 'preseasonid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Farm as farm',
						 array(
								'local' => 'farmid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Commodity as crop', 
								array(
									'local' => 'cropid',
									'foreign' => 'id'
								)
						);
		$this->hasMany('Loan as loans',
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
		if(isArrayKeyAnEmptyString('preseasonid', $formvalues)){
			unset($formvalues['preseasonid']); 
		}
		if(isArrayKeyAnEmptyString('farmid', $formvalues)){
			unset($formvalues['farmid']); 
		}
		if(isArrayKeyAnEmptyString('fieldsize', $formvalues)){
			$formvalues['fieldsize'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('fieldsizeunit', $formvalues)){
			$formvalues['fieldsizeunit'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('totalplanted', $formvalues)){
			$formvalues['totalplanted'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('totalplantedunit', $formvalues)){
			$formvalues['totalplantedunit'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('yield', $formvalues)){
			$formvalues['yield'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('yieldunit', $formvalues)){
			$formvalues['yieldunit'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('totalharvest', $formvalues)){
			$formvalues['totalharvest'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('totalharvestunit', $formvalues)){
			$formvalues['totalharvestunit'] = NULL;  
		}
		if(isArrayKeyAnEmptyString('nextseasonprodn', $formvalues)){
			$formvalues['nextseasonprodn'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('nextseasonprodnunit', $formvalues)){
			$formvalues['nextseasonprodnunit'] = NULL;  
		}
		if(isArrayKeyAnEmptyString('quantitysold', $formvalues)){
			$formvalues['quantitysold'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('quantitysoldunit', $formvalues)){
			$formvalues['quantitysoldunit'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('unitprice', $formvalues)){
			$formvalues['unitprice'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('totalsalesamount', $formvalues)){
			$formvalues['totalsalesamount'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('nextseasonrevenue', $formvalues)){
			$formvalues['nextseasonrevenue'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('saletype', $formvalues)){
			$formvalues['saletype'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('financetype', $formvalues)){
			$formvalues['financetype'] = NULL; 
		}
		# process address information
        // debugMessage($formvalues); 
        // exit();
		parent::processPost($formvalues);
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
    # determine formated field size
    function getfieldsizeText() {
    	$text = '--';
    	if(!isEmptyString($this->getfieldsize())){
    		$text = clean_num($this->getfieldsize());
    	}
    	if($this->getFieldSizeUnitText() != '--'){
    		$text .= " <span class='pagedescription'>(".$this->getFieldSizeUnitText().")</span>";
    	}
    	return $text;
    }
	# determine item quantity units
    function getTotalPlantedUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getTotalPlantedUnit())){
    		$values = getHarvestQuantityUnits();
    		$text = $values[$this->getTotalPlantedUnit()];
    	}
    	return $text;
    }
	# determine formated planted quantity
    function getTotalPlantedText() {
    	$text = '--';
    	if(!isEmptyString($this->getTotalPlanted())){
    		$text = $this->getTotalPlanted();
    	}
    	if(!isEmptyString($this->getTotalPlanted()) && $this->getTotalPlantedUnit() != '--'){
    		$text .= " <span class='pagedescription'>(".$this->getTotalPlantedUnitText().")</span>";
    	}
    	return $text;
    }
    # determine item rate units
    function getYieldUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getYieldUnit())){
    		$values = getHarvestYieldUnits();
    		$text = $values[$this->getYieldUnit()];
    	}
    	return $text;
    }
	# determine formated yield
    function getYieldText() {
    	$text = '--';
    	if(!isEmptyString($this->getYield())){
    		$text = clean_num($this->getYield());
    	}
    	if($this->getYieldUnitText() != '--'){
    		$text .= " <span class='pagedescription'>(".$this->getYieldUnitText().")</span>";
    	}
    	return $text;
    }
	# determine item quantity units
    function getTotalHarvestUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getTotalHarvestUnit())){
    		$values = getHarvestQuantityUnits();
    		$text = $values[$this->getTotalHarvestUnit()];
    	}
    	return $text;
    }
	# determine formated harvest quantity
    function getTotalHarvestText() {
    	$text = '--';
    	if(!isEmptyString($this->getTotalHarvest())){
    		$text = clean_num($this->getTotalHarvest());
    	}
    	if($this->getTotalHarvestUnitText() != '--'){
    		$text .= " <span class='pagedescription'>(".$this->getTotalHarvestUnitText().")</span>";
    	}
    	return $text;
    }
	# determine item quantity units
    function getQuantitySoldUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getQuantitySoldUnit())){
    		$values = getHarvestQuantityUnits();
    		$text = $values[$this->getQuantitySoldUnit()];
    	}
    	return $text;
    }
	# determine formated harvest quantity
    function getQuantitySoldText() {
    	$text = '--';
    	if(!isEmptyString($this->getQuantitySold())){
    		$text = clean_num($this->getQuantitySold());
    	}
    	if($this->getQuantitySoldUnitText() != '--'){
    		$text .= " <span class='pagedescription'>(".$this->getQuantitySoldUnitText().")</span>";
    	}
    	return $text;
    }
    # determine if loan was financed
    function hasLoan() {
    	return $this->getfinancetype() == 1 ? true : false;
    }
}
?>