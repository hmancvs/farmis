<?php

class FarmLand extends BaseRecord {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('farmland');
		$this->hasColumn('farmid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('name', 'string', 255, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('description', 'string', 1000);
		$this->hasColumn('landsize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('landactivesize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('landunits', 'integer', null);
		$this->hasColumn('landacquiremethod', 'integer', null);
		$this->hasColumn('addressid', 'integer', null);
		$this->hasColumn('sameaddress', 'integer', null);
	}
	/**
	 * Contructor method for custom initialization
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("regdate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"name.notblank" => $this->translate->_("global_name_error"),
       									"farmid.notblank" => $this->translate->_("farm_farmid_error")
       	       						));
	}
	/**
	 * Model relationships
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('Address as address',
						 array(
								'local' => 'addressid',
								'foreign' => 'id'
							)
					); 
		$this->hasMany('Address as addresses',
						 array(
								'local' => 'id',
								'foreign' => 'farmid'
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
		if(isArrayKeyAnEmptyString('landsize', $formvalues)){
			unset($formvalues['landsize']); 
		}
		if(isArrayKeyAnEmptyString('landunits', $formvalues)){
			unset($formvalues['landunits']); 
		}
		if(isArrayKeyAnEmptyString('landacquiremethod', $formvalues)){
			unset($formvalues['landacquiremethod']); 
		}
		
		# process address information
        // debugMessage($formvalues); 
        // exit();
		parent::processPost($formvalues);
	}
    /**
     * Determine the type of person
     * @return bool
     */
    function getLandUnitsLabel(){
    	$label = '--';
    	$allmeasures = getLandMeasureUnits();
    	if(!isEmptyString($this->getLandUnits())){
    		$label = $allmeasures[$this->getLandUnits()];
    	}
    	return $label;
    }
    # determine text string for available land size
    function displayActiveLandSize(){
    	if(isEmptyString($this->getLandActiveSize()) || $this->getLandActiveSize() == 0) {
    		return '--';
    	} else {
    		$ret = '--';
    		if(!isEmptyString($this->getLandUnitsLabel())){
    			$ret = $this->getLandActiveSize().'&nbsp; <span class="pagedescription">('.$this->getLandUnitsLabel().')</span>';
    		}
    		return $ret;
    	}
    }
	# determine text string for active land size
    function displayLandSize(){
    	if(isEmptyString($this->getLandSize()) || $this->getLandSize() == 0) {
    		return '--';
    	} else {
    		$ret = '--';
    		if(!isEmptyString($this->getLandUnitsLabel())){
    			$ret = $this->getLandSize().'&nbsp; <span class="pagedescription">('.$this->getLandUnitsLabel().')</span>';
    		}
    		return $ret;
    	}
    }
 	/**
     * Determine the type of person
     * @return bool
     */
    function getLandAcquireMethodLabel(){
    	$label = '--';
    	$allmethods = getLandAcquireMethods();
    	if(!isEmptyString($this->getLandUnits())){
    		$label = $allmethods[$this->getLandAcquireMethod()];
    	}
    	return $label;
    }
}
?>