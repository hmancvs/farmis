<?php

class FarmCrop extends BaseRecord {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('farmcrop');
		$this->hasColumn('userid', 'integer', null);
		$this->hasColumn('cropid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('receiveprices', 'integer', null, array('default' => 1));
		$this->hasColumn('receiveupdates', 'integer', null, array('default' => 1));
	}
	/**
	 * Contructor method for custom initialization
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("regdate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"cropid.notblank" => "Please select a court"
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
		$this->hasOne('Commodity as crop', 
								array(
									'local' => 'cropid',
									'foreign' => 'id'
								)
						);
	}
	
	/**
	 * Preprocess model data
	 */
	function processPost($formvalues){
		// debugMessage($formvalues);
		$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
    	
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']); 
		}
		if(isArrayKeyAnEmptyString('receiveprices', $formvalues)){
			unset($formvalues['receiveprices']); 
		}
		if(isArrayKeyAnEmptyString('receiveupdates', $formvalues)){
			unset($formvalues['receiveupdates']); 
		}
		
		# process address information
        // debugMessage($formvalues); 
        // exit();
		parent::processPost($formvalues);
	}
	/**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
    	$conn = Doctrine_Manager::connection();
   	 	$update = false;
   	 	
    	// find any duplicates and delete them
    	$duplicates = $this->getDuplicates();
		if($duplicates->count() > 0){
			$duplicates->delete();
		}
    	// exit();
    	return true;
    }
    # find duplicate farmgroups after save
	function getDuplicates(){
		$q = Doctrine_Query::create()->from('FarmCrop f')->where("f.userid = '".$this->getUserID()."' AND f.cropid = '".$this->getCropID()."' AND f.id <> '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	} 
}
?>