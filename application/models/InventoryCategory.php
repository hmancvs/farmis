<?php

/**
 * Model for inventory category
 *
 */

class InventoryCategory extends BaseRecord  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('inventorycategory');
		$this->hasColumn('userid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('name', 'string', 255, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('description','string', 1000);
		$this->hasColumn('dateadded','date', null);
		$this->hasColumn('addedbyid', 'integer', null);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("dateadded"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"userid.notblank" => $this->translate->_("inventory_userid_error"),
       									"name.notblank" => $this->translate->_("inventory_categoryname_error")
       	       						));
	}
	public function setUp() {
		parent::setUp();
		
		// match the parent id
		$this->hasOne('UserAccount as user',
							array('local' => 'userid',
									'foreign' => 'id'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('dateadded', $formvalues)){
			unset($formvalues['dateadded']); 
		}
		if(isArrayKeyAnEmptyString('addedbyid', $formvalues)){
			unset($formvalues['addedbyid']); 
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
}

?>