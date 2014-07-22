<?php 

class Notes extends BaseRecord {
	
    public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		$this->setTableName('notes');
		$this->hasColumn('type', 'integer', null, array('notnull' => true, 'notblank' => true, 'default' => 1)); // 1 - farmer, 2 - Farm, 3 - Season, 4 - inventory, 5-Inputs, 6-Tillage, 7-Planting, 8-Treatment, 9-Harvest, 10-Storage, 11-Sales  
       	$this->hasColumn('description','string', 500);
        $this->hasColumn('datenoted', 'date', null);
        $this->hasColumn('notedbyid', 'integer', null);
        $this->hasColumn('userid', 'integer', null);
		$this->hasColumn('seasonid', 'integer', null);	
		$this->hasColumn('inventoryid', 'integer', null);
		$this->hasColumn('inputid', 'integer', null);	
		$this->hasColumn('tillageid', 'integer', null);	
		$this->hasColumn('plantingid', 'integer', null);
		$this->hasColumn('trackingid', 'integer', null);
		$this->hasColumn('activityid', 'integer', null);
		$this->hasColumn('harvestid', 'integer', null);	
		$this->hasColumn('saleid', 'integer', null);
    }
	/**
    * Contructor method for custom functionality - add the fields to be marked as dates
    */
	public function construct() {
		parent::construct();
       $this->addDateFields(array("datenoted"));
       
       // set the custom error messages
       $this->addCustomErrorMessages(array(
       									"type.notblank" => $this->translate->_("notes_type_error")
       								));
    }
	
    public function setUp() {
		parent::setUp();
		
		// match the parent id
		$this->hasOne('Season as season',
							array('local' => 'seasonid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('UserAccount as user', 
							array(
								'local' => 'userid',
								'foreign' => 'id'
							)
						);
		$this->hasOne('UserAccount as notedby', 
								array(
									'local' => 'notedbyid',
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
		if(isArrayKeyAnEmptyString('datenoted', $formvalues)){
			unset($formvalues['datenoted']); 
		}
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']); 
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
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
}
?>