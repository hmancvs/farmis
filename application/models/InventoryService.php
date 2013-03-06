<?php

/**
 * Model for inventory service
 *
 */

class InventoryService extends BaseRecord  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('inventoryservice');
		$this->hasColumn('inventoryid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('seasonid', 'integer', null);	
		$this->hasColumn('type', 'integer', null, array('notnull' => true, 'notblank' => true, 'default' => 1)); // 1   
		$this->hasColumn('description','string', 1000, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('servicedate','date', null);
		$this->hasColumn('cost', 'decimal', 11, array('default' => '0'));
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("servicedate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"inventoryid.notblank" => $this->translate->_("inventory_inventoryid_error"),
       									"type.notblank" => $this->translate->_("inventory_servicetype_error"),
       									"description.notblank" => $this->translate->_("inventory_servicedescription_error")
       	       						));
	}
	public function setUp() {
		parent::setUp();
		
		// match the parent id
		$this->hasOne('Farm as farm',
							array('local' => 'farmid',
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
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		}
		if(isArrayKeyAnEmptyString('seasonid', $formvalues)){
			unset($formvalues['seasonid']); 
		}
		if(isArrayKeyAnEmptyString('cost', $formvalues)){
			unset($formvalues['cost']); 
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	# determine tillage method
    function getTypeText() {
    	$text = '--';
    	if(!isEmptyString($this->getType())){
    		$alltypes = getServiceTypes();
    		$text = $alltypes[$this->getType()];
    	}
    	return $text;
    }
}

?>