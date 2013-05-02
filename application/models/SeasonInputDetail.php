<?php
/**
 * Model for season input detail
 *
 */
class SeasonInputDetail extends BaseRecord {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		$this->setTableName('seasoninputdetail');
		$this->hasColumn('type', 'integer', null, array('default' => NULL));
		$this->hasColumn('name','string', 255, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('description','string', 500);
		$this->hasColumn('inputdate','date', null);
		$this->hasColumn('source','string', 255);
		$this->hasColumn('quantity', 'integer', null);
		$this->hasColumn('unitcost', 'string', 10, array('default' => 0));
		$this->hasColumn('amount', 'string', 10, array('default' => NULL));
		$this->hasColumn('notes','string', 1000);
		$this->hasColumn('inputid', 'integer', null);
		$this->hasColumn('tillageid', 'integer', null);	
		$this->hasColumn('plantingid', 'integer', null);
		$this->hasColumn('trackingid', 'integer', null);
		$this->hasColumn('activityid', 'integer', null);
		$this->hasColumn('harvestid', 'integer', null);	
		$this->hasColumn('saleid', 'integer', null);		
	}
	
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("inputdate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"name.notblank" => $this->translate->_("seasoninput_detail_name_error"),
       									"amount.notblank" => $this->translate->_("seasoninput_detail_amount_error")
       	       						));
	}
	
	public function setUp() {
		parent::setUp(); 
		
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
			$formvalues['type'] = NULL;
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
		parent::processPost($formvalues);
	}
	# get type type label for input
	function getTypeText(){
		$text = '--';
		if(!isEmptyString($this->getInputID())){
			if(!isEmptyString($this->getType())){
				$alltypes = getAllInputTypes();
				$text = $alltypes[$this->getType()];
			}
		} else {
			if(!isEmptyString($this->getType())){
				$alltypes = getAllExpenseTypes();
				$text = $alltypes[$this->getType()];
			}
		}
		
		return $text;
	}
	# after save custom logic
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	// find any duplicated users and delete them
    	$duplicates = $this->getDuplicateEntries();
		if($duplicates->count() > 0){
			$duplicates->delete();
		}
    	// exit();
    	return true;
    }
	# after save custom logic
    function afterUpdate(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	// find any duplicated users and delete them
    	$duplicates = $this->getDuplicateEntries();
		if($duplicates->count() > 0){
			$duplicates->delete();
		}
    	// exit();
    	return true;
    }
	# find expenses that could have been saved as a result of duplicates
	function getDuplicateEntries(){
		$q = Doctrine_Query::create()->from('SeasonInputDetail d')->where("d.type = '".$this->getType()."' AND d.name = '".$this->getName()."' AND d.inputdate = '".$this->getInputDate()."' AND d.quantity = '".$this->getQuantity()."' AND d.amount = '".$this->getAmount()."' AND d.id <> '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	}
}
?>