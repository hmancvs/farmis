<?php

/**
 * Model for commodity for which prices are added 
 *
 */

class Commodity extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('commodity');
		$this->hasColumn('name', 'string', 150, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('description', 'string', 500);
		$this->hasColumn('parentid', 'integer'); 
		$this->hasColumn('categoryid', 'integer', null,array('notnull' => true, 'notblank' => true) );
		$this->hasColumn('unitid', 'integer', null); 
		$this->hasColumn('minprice', 'integer', 11);
		$this->hasColumn('maxprice', 'integer', 11);
		$this->hasColumn('image','string', 255);
		$this->hasColumn('allowfarmer', 'integer', 11, array('default' => 0));
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"name.notblank" => $this->translate->_("commodity_name_error"),
       									"categoryid.notblank" => $this->translate->_("commodity_category_error")
       	       						));
	}
	public function setUp() {
		parent::setUp();
		
		// match the parent id
		$this->hasOne('Commodity as parent',
						 array(
								'local' => 'parentid',
								'foreign' => 'id'
							)
					); 
		// the category to which it belongs
		$this->hasOne('CommodityCategory as category',
						 array(
								'local' => 'categoryid',
								'foreign' => 'id'
							)
					);
		// the units for the commodity 
		$this->hasOne('CommodityUnit as units',
							array('local' => 'unitid',
									'foreign' => 'id'
							)
						); 
	}
	/*	
	 * Custom model validation
	 */
	function validate() {
		// execute the column validation 
		parent::validate();
		
		// connection		
		$conn = Doctrine_Manager::connection();
		
		// query for check if location exists
		$unique_query = "SELECT id FROM commodity WHERE name = '".$this->getName()."' AND id <> '".$this->getID()."'";
		$result = $conn->fetchOne($unique_query);
		// debugMessage($unique_query);
		// debugMessage("result is ".$result);
		if(!isEmptyString($result)){ 
			$this->getErrorStack()->add("unique.name", sprintf($this->translate->_("commodity_name_unique"),$this->getName()));
		}
	}
	/*
	 * 
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if (!isArrayKeyAnEmptyString('name', $formvalues)) {
			$formvalues['name'] = trim($formvalues['name']);
		}
		// check if the parentid is specified
		if (isArrayKeyAnEmptyString('parentid', $formvalues)) {
			$formvalues['parentid'] = NULL;
		}
		if (isArrayKeyAnEmptyString('unitid', $formvalues)) {
			$formvalues['unitid'] = NULL;
		}
		if (isArrayKeyAnEmptyString('minprice', $formvalues)) {
			$formvalues['minprice'] = NULL;
		}
		if (isArrayKeyAnEmptyString('maxprice', $formvalues)) {
			$formvalues['maxprice'] = NULL;
		}
		if(isArrayKeyAnEmptyString('image', $formvalues)){
			unset($formvalues['image']);
		}
		parent::processPost($formvalues);
	}
	/**
	 * Update the folder and file name for the uploaded documents 
	 */
	function afterSave(){
		
		return true;
	}
	/**
	 * Update the folder and file name for the uploaded documents 
	 */
	function afterUpdate(){
		
		return true;
	}
	/**
	 * Get the name of the commodity depending on whether it has a parent or not 
	 *
	 * @return String 
	 */
	function getFullName() {
		$name = $this->_get('name'); ; 
		if (!isEmptyString($this->getParentID())) {
			$name = $this->getParent()->_get('name')."(".$name.")"; 
		}
		return $name; 
	}
    /**
     * Get a description of the units
     *
     * @return String 
     */
    function getUnitsDescription() {
    	return $this->getUnits()->getName(); 
    }
	/**
	 * image path
	 */	
	function getImagePath() {
		// return empty string if empty
		$path = '--';
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		
		if($this->hasIDImage()){
			$path = $baseUrl.'/uploads/commodity/'.$this->getID().".jpg";
		}
		if(!isEmptyString($this->getImage())){
			$path = $baseUrl.'/uploads/commodity/'.$this->getImage();
		}
		
		return $path; 
	}
	# determine if image already exists with 
	function hasIDImage(){
		// $real_path = APPLICATION_PATH."/../public/uploads/commodity";
		$real_path = APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.PUBLICFOLDER.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'commodity';
		$real_path = $real_path.DIRECTORY_SEPARATOR.$this->getID().".jpg";
		if(file_exists($real_path)){
			return true;
		}
		return false;
	}
}

?>