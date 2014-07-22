<?php

/**
 * Model for inventory
 *
 */

class Inventory extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('inventory');
		$this->hasColumn('userid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('seasonid', 'integer', null);
		$this->hasColumn('type', 'integer', null, array('notnull' => true, 'notblank' => true, 'default' => 1)); // 1 Inpug (Assest), 2 Processing, 3 Output  
		$this->hasColumn('categoryid', 'integer', null);
		$this->hasColumn('itemname', 'string', 255, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('description','string', 1000);
		$this->hasColumn('photo', 'string', 255);
		$this->hasColumn('serialno', 'string', 50);
		$this->hasColumn('modelno', 'string', 50);
		$this->hasColumn('receiptno', 'string', 50);
		$this->hasColumn('status', 'string', 255);
		$this->hasColumn('purchasedate','date', null);
		$this->hasColumn('quantity', 'integer', null, array('default' => '1'));
		$this->hasColumn('quantityunit', 'string', 50);
		$this->hasColumn('unitcost', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('totalcost', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('vendor', 'string', 255);
		$this->hasColumn('vendorid', 'integer', null);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		$this->addDateFields(array("purchasedate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"userid.notblank" => $this->translate->_("inventory_userid_error"),
       									"type.notblank" => $this->translate->_("inventory_type_error"),
       									"itemname.notblank" => $this->translate->_("inventory_itemname_error")
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
		$this->hasOne('Season as season',
							array('local' => 'seasonid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('InventoryCategory as category',
							array('local' => 'categoryid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('Contact as thevendor',
							array('local' => 'vendorid',
									'foreign' => 'id'
							)
						);
		$this->hasMany('InventoryService as services',
					 		array(
								'local' => 'id',
								'foreign' => 'inventoryid'
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
		if(isArrayKeyAnEmptyString('purchasedate', $formvalues)){
			unset($formvalues['purchasedate']); 
		}
		if(isArrayKeyAnEmptyString('quantity', $formvalues)){
			unset($formvalues['quantity']); 
		}
		if(isArrayKeyAnEmptyString('quantityunit', $formvalues)){
			unset($formvalues['quantityunit']); 
		}
		if(isArrayKeyAnEmptyString('unitcost', $formvalues)){
			unset($formvalues['unitcost']); 
		}
		if(isArrayKeyAnEmptyString('totalcost', $formvalues)){
			unset($formvalues['unitcost']); 
		}
		if(isArrayKeyAnEmptyString('vendorid', $formvalues)){
			unset($formvalues['vendorid']); 
		}
		if(isArrayKeyAnEmptyString('seasonid', $formvalues)){
			unset($formvalues['seasonid']); 
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	# determine quantiy details label
	function getQuantityText() {
		$qtytext = '--';
		if(!isEmptyString($this->getQuantity())){
			$qtytext = $this->getQuantity();
		}
		if(!isEmptyString($this->getQuantity()) && !isEmptyString($this->getQuantityUnit())){
			$qtytext .= "&nbsp;<span class='pagedescription'>(".$this->getQuantityUnit().")</span>";
		}
	 	return $qtytext;
	}
	# determine if person has profile image
	function hasProfileImage(){
		$real_path = APPLICATION_PATH.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user_".$this->getUserID().DIRECTORY_SEPARATOR."inventory".DIRECTORY_SEPARATOR."inventory_".$this->getID().DIRECTORY_SEPARATOR."large_".$this->getPhoto();
		
		// debugMessage($real_path);
		if(file_exists($real_path) && !isEmptyString($this->getPhoto())){
			return true;
		}
		return false;
	}
	# determine path to thumbnail profile picture
	function getThumbnailPicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/images/defaultupload.png';
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/farms/farm_'.$this->getID().'/inventory_'.$this->getID().'/thumbnail_'.$this->getPhoto();
		}
		return $path;
	}
	# determine path to large profile picture
	function getLargePicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/images/defaultupload.png';
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/farms/farm_'.$this->getID().'/inventory_'.$this->getID().'/large_'.$this->getPhoto(); 
		}
		// debugMessage($path);
		return $path;
	}
	# determine all expenses for entry
	function getServiceDetails() {
    	$q = Doctrine_Query::create()->from('InventoryService s')->where("s.inventoryid = '".$this->getID()."'")->orderby('s.servicedate DESC');
		$result = $q->execute();
		return $result;
	}
	# determine all notes for entry
	function getNotesDetails() {
    	$q = Doctrine_Query::create()->from('Notes n')->where("n.inventoryid = '".$this->getID()."'")->orderby('n.datenoted DESC');
		$result = $q->execute();
		return $result;
	}
}

?>