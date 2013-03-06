<?php

/**
 * Model for table customfield
 *
 */

class CustomField extends BaseRecord  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('customfield');
		$this->hasColumn('farmerid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('categoryid', 'integer', null);
		$this->hasColumn('tabletype', 'integer', null, array('default' => 1)); // 1 - Inventory Category, 2 -  
		$this->hasColumn('fieldname', 'string', 255, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('fieldvalue','string', 255, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('fieldtype', 'integer', null);
		$this->hasColumn('description', 'string', 255);
		$this->hasColumn('isrequired', 'integer', null);
		$this->hasColumn('defaultvalue', 'string', 500);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"farmerid.notblank" => $this->translate->_("customfield_farmerid_error"),
       									"fieldname.notblank" => $this->translate->_("customfield_fieldname_error"),
       									"fieldvalue.notblank" => $this->translate->_("customfield_fieldvalue_error")
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
		$this->hasOne('InventoryCategory as category',
							array('local' => 'categoryid',
									'foreign' => 'id'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('categoryid', $formvalues)){
			unset($formvalues['categoryid']); 
		}
		if(isArrayKeyAnEmptyString('fieldtype', $formvalues)){
			unset($formvalues['fieldtype']); 
		}
		if(isArrayKeyAnEmptyString('isrequired', $formvalues)){
			unset($formvalues['isrequired']); 
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
}

?>