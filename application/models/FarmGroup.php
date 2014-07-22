<?php

class FarmGroup extends BaseEntity {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('farmgroup');
		$this->hasColumn('shortname', 'string', 255);
		$this->hasColumn('orgname', 'string', 255, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('refno', 'string', 15);
		$this->hasColumn('regno', 'string', 15);
		$this->hasColumn('regdate', 'date');
		$this->hasColumn('type', 'integer', null, array( 'notnull' => true, 'notblank' => true));	
		$this->hasColumn('subtype', 'integer', null);	
		$this->hasColumn('parentid', 'integer', null);
		$this->hasColumn('managerid', 'integer', null);
		$this->hasColumn('contactname', 'string', 255);
		$this->hasColumn('email', 'string', 50);
		$this->hasColumn('phone', 'string', 15);
		$this->hasColumn('history', 'string', 1000);
		$this->hasColumn('notes', 'string', 1000);
		$this->hasColumn('moto', 'string', 255);
		$this->hasColumn('signature', 'string', 255);
		$this->hasColumn('logo', 'string', 255);
		$this->hasColumn('profilephoto', 'string', 255);
		
		$this->hasColumn('contactname2', 'string', 255);
		$this->hasColumn('contactemail2', 'string', 50);
		$this->hasColumn('contactphone2', 'string', 15);
		$this->hasColumn('contactname3', 'string', 255);
		$this->hasColumn('contactemail3', 'string', 50);
		$this->hasColumn('contactphone3', 'string', 15);
		
		$this->hasColumn('country', 'string', 2, array('default' => 'UG'));
		$this->hasColumn('districtid', 'integer', null);
		$this->hasColumn('countyid', 'integer', null);
		$this->hasColumn('subcountyid', 'integer', null);
		$this->hasColumn('parishid', 'integer', null);
		$this->hasColumn('villageid', 'integer', null);
		$this->hasColumn('streetaddress', 'string', 255);
		$this->hasColumn('city', 'string', 50);
		$this->hasColumn('state', 'string', 50);
		$this->hasColumn('zipcode', 'string', 15);	
	}
	/**
	 * Contructor method for custom initialization
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("regdate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"orgname.notblank" => $this->translate->_("farmgroup_orgname_error"),
       									"type.notblank" => $this->translate->_("farmgroup_type_error")
       	       						));
	}
	/**
	 * Model relationships
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('UserAccount as manager', 
								array(
									'local' => 'managerid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('FarmGroup as parent', 
								array(
									'local' => 'parentid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('FarmGroup as subgroups',
						 array(
								'local' => 'parentid',
								'foreign' => 'id'
							)
					); 
		$this->hasMany('UserAccount as users',
						 array(
								'local' => 'id',
								'foreign' => 'farmgroupid'
							)
					);
		$this->hasOne('Location as district',
						 array(
								'local' => 'districtid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Location as county',
						 array(
								'local' => 'countyid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Location as subcounty',
						 array(
								'local' => 'subcountyid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Location as parish',
						 array(
								'local' => 'parishid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Location as village',
						 array(
								'local' => 'villageid',
								'foreign' => 'id'
							)
					); 
	}
	/**
	 * Custom model validation
	 */
	function validate() {
		# execute the column validation 
		parent::validate();
		if($this->refNoExists()){
			$this->getErrorStack()->add("refno.unique", "The reference <b>".$this->getRefNo()."</b> already exists for another Farm Group. <br />Please specify another.");
		}
		if($this->regNoExists()){
			$this->getErrorStack()->add("regno.unique", "The reference <b>".$this->getRegNo()."</b> already exists for another Farm Group. <br />Please specify another.");
		}
	}
	# determine if the refno has already been assigned to another organisation
	function refNoExists($ref =''){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
		
		if(isEmptyString($ref)){
			$ref = $this->getRefNo();
		}
		# unique email
		$ref_query = "SELECT id FROM farmgroup WHERE refno = '".$ref."' AND refno <> '' ".$id_check;
		// debugMessage($ref_query);
		$ref_result = $conn->fetchOne($ref_query);
		// debugMessage($ref_result);
		if(isEmptyString($ref_result)){
			return false;
		}
		return true;
	}
	# determine if the regno has already been assigned to another organisation
	function regNoExists($ref =''){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
		if(isEmptyString($ref)){
			$ref = $this->getRegNo();
		}
		# unique email
		$ref_query = "SELECT id FROM farmgroup WHERE regno = '".$ref."' AND regno <> '' ".$id_check."";
		$ref_result = $conn->fetchOne($ref_query);
		if(isEmptyString($ref_result)){
			return false;
		}
		return true;
	}
	/**
	 * Preprocess model data
	 */
	function processPost($formvalues){
		// debugMessage($formvalues);
		$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
    	
		// set default values for integers, dates, decimals
		if(isArrayKeyAnEmptyString('managerid', $formvalues)){
			$formvalues['managerid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			$formvalues['type'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('subtype', $formvalues)){
			$formvalues['subtype'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('parentid', $formvalues)){
			$formvalues['parentid'] = NUll; 
		}
		if(isArrayKeyAnEmptyString('regdate', $formvalues)){
			$formvalues['regdate'] = NULL; 
		}
		
		# set new regno from refno
		if(!isArrayKeyAnEmptyString('refno', $formvalues)){
			$prefix = FARMGROUP_REG_PREFIX;
			$regno = $prefix.$formvalues['refno'];
			$formvalues['regno'] = $regno;
		}
		if(isArrayKeyAnEmptyString('country', $formvalues)){
			$formvalues['country'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('districtid', $formvalues)){
			$formvalues['districtid'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('countyid', $formvalues)){
			unset($formvalues['countyid']);
		}
		if(isArrayKeyAnEmptyString('subcountyid', $formvalues)){
			unset($formvalues['subcountyid']);
		}
		if(isArrayKeyAnEmptyString('parishid', $formvalues)){
			unset($formvalues['parishid']);
		}
		if(isArrayKeyAnEmptyString('villageid', $formvalues)){
			unset($formvalues['villageid']);
		}
		
		if(!isArrayKeyAnEmptyString('phone', $formvalues)){
			$formvalues['phone'] = getFullPhone($formvalues['phone']);
		}
		if(!isArrayKeyAnEmptyString('contactphone2', $formvalues)){
			$formvalues['contactphone2'] = getFullPhone($formvalues['contactphone2']);
		}
		if(!isArrayKeyAnEmptyString('contactphone3', $formvalues)){
			$formvalues['contactphone3'] = getFullPhone($formvalues['contactphone3']);
		}
		
		# farm group contact person
		if(!isArrayKeyAnEmptyString('contactname', $formvalues) && !isArrayKeyAnEmptyString('email', $formvalues)){
			if(!isArrayKeyAnEmptyString('id', $formvalues)){
				$formvalues['manager']['farmgroupid'] = $formvalues['id'];
			}
			$formvalues['manager']['firstname'] = $formvalues['contactname'];
			$formvalues['manager']['lastname'] = "-";
			$formvalues['manager']['email'] = $formvalues['email'];
			$formvalues['manager']['createdby'] = $userid;
		} else {
			unset($formvalues['manager']);
		}
		
        /*debugMessage($formvalues); 
        exit();*/
		parent::processPost($formvalues);
	}
	/**
	 * Return the person's full names, which is a concatenation of the first and the surname
	 *
	 * @return String
	 */
	function getName() {
	    return $this->getOrgName();
	}
	/**
     * Determine the type of person
     * @return bool
     */
    function getTypeLabel(){
    	$label = '--';
    	$alltypes = getFarmGroupTypes();
    	if(!isEmptyString($this->getType())){
    		$label = $alltypes[$this->getType()];
    	}
    	return $label; 
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
    	
    	if(isEmptyString($this->getRegDate())){
    		$this->setRegDate(date("Y-m-d"));
    		$update = true;
    	}
    	# generate registration number for farmer
    	if(isEmptyString($this->getRefNo())){
    		$this->setRefNo($this->generateRefNo());
			$this->setRegNo($this->getCurrentRegNo());
			$session->setVar('custommessage', 'Registration ID# '.$this->getRegNo().' generated.');
			$update = true;
    	}
    	
    	# save changes 
    	if($update){
    		$this->save();
    	}
    	
    	// find any duplicates and delete them
    	$duplicates = $this->getDuplicates();
		if($duplicates->count() > 0){
			$duplicates->delete();
		}
    	// exit();
    	return true;
    }
    /**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterUpdate(){
    	$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	if(isEmptyString($this->getRegDate())){
    		$this->setRegDate(date("Y-m-d"));
    		$update = true;
    	}
    	# generate registration number for farmer
    	if(isEmptyString($this->getRefNo())){
    		$this->setRefNo($this->generateRefNo());
			$this->setRegNo($this->getCurrentRegNo());
			$session->setVar('custommessage', 'Registration ID# '.$this->getRegNo().' generated.');
			$update = true;
    	}
    	
    	# save changes 
    	if($update){
    		$this->save();
    	}
    	
    	return true;
    }
	# generate refno, determine next alphabet concat string 
	function generateRefNo(){
		$ref = '';
		$id = $this->getID();
		$nid = number_pad($id, 4);
		
		$str = '';
		$ref = $str.$nid;
		// exit();
		return $ref;
	}
	# generate next registration number
	function getCurrentRegNo(){
		$regno  = '';
		$session = SessionWrapper::getInstance();
		$prefix = FARMGROUP_REG_PREFIX;
		if(isKenya()){
			$prefix = FARMGROUP_REG_PREFIX_KE;
		}
		$regno = $prefix.$this->generateRefNo();
		//debugMessage($prefix);
		return $regno;
	}
	# fetch next id
	function getNextInsertID(){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT max(id) FROM farmgroup ";
		$query2 = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='farmgroup'";
		$result = $conn->fetchOne($query2);
		return $result+1;
	}
	function getNextRefNo(){
		return number_pad($this->getNextInsertID(),4);
	}
	# determine if person has profile image
	function hasLogo(){
		$real_path = APPLICATION_PATH."/../public/uploads/farmgroups/group_";
		$real_path = $real_path.$this->getID().DIRECTORY_SEPARATOR."large_".$this->getLogo();
		if(file_exists($real_path) && !isEmptyString($this->getLogo())){
			return true;
		}
		return false;
	}
	# determine path to small profile picture
	function getSmallLogoPath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/farmgroups/default/small_male.jpg';
		if($this->hasLogo()){
			$path = $baseUrl.'/uploads/farmgroups/group_'.$this->getID().'/small_'.$this->getLogo();
		}
		return $path;
	}
	# determine path to thumbnail profile picture
	function getThumbnailLogoPath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/farmgroups/default/thumbnail_group.jpg';
		if($this->hasLogo()){
			$path = $baseUrl.'/uploads/farmgroups/group_'.$this->getID().'/thumbnail_'.$this->getLogo();
		}
		return $path;
	}
	# determine path to medium profile picture
	function getMediumLogoPath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/farmgroups/default/medium_group.jpg';
		if($this->hasLogo()){
			$path = $baseUrl.'/uploads/farmgroups/group_'.$this->getID().'/medium_'.$this->getLogo();
		}
		return $path;
	}
	# determine path to large profile picture
	function getLargeLogoPath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/farmgroups/default/large_logo.jpg'; 
		if($this->hasLogo()){
			$path = $baseUrl.'/uploads/farmgroups/group_'.$this->getID().'/large_'.$this->getLogo();
		}
		// debugMessage($path);
		return $path;
	}
	
	/**
	 * Return the date of birth 
	 * @return string dateofbirth 
	 */
	function getRegDateFormatted() {
		$date = "--";
		if(!isEmptyString($this->getRegDate())){
			$date = changeMySQLDateToPageFormat($this->getRegDate());
		} 
		return $date;
	}
	# custom logic to determine the farmers in the Farm Group
	function getListOfFarmers() {
		$q = Doctrine_Query::create()->from('UserAccount u')->where("u.farmgroupid = '".$this->getID()."'")->andwhere("u.type = '2'")->orderby("u.firstname ASC");
		$result = $q->execute();
		return $result;
	}
	# count the number of farmers in the group
	function getCountFarmers() {
		$users = $this->getListOfFarmers();
		return $users->count();
	}
	# custom logic to determine the farmers in the Farm Group
	function getFeaturedFarmers($limit) {
		$q = Doctrine_Query::create()->from('UserAccount u')->where("u.farmgroupid = '".$this->getID()."'")->andwhere("u.type = '2'")->orderby("u.datecreated DESC")->limit($limit);
		$result = $q->execute();
		return $result;
	}
	# determine the invited farmers
	function getInvitedFarmers(){
		$q = Doctrine_Query::create()->from('UserAccount u')->where("u.farmgroupid = '".$this->getID()."'")->andwhere("u.type = '2'");
		$result = $q->execute();
		return $result;
	}
	# determine the activated invited farmers
	function getActiveFarmers(){
		$q = Doctrine_Query::create()->from('UserAccount u')->where("u.farmgroupid = '".$this->getID()."'")->andwhere("u.isactive = '1'")->andwhere("u.type = '2'");
		$result = $q->execute();
		return $result;
	}
	# count the number of farmers in the group that are registered
	function getCountRegisteredFarmers() {
		$users = $this->getActiveFarmers();
		return $users->count();
	}
	# male farmers
	function getMaleFarmers(){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT count(f.id) FROM useraccount u WHERE (u.farmgroupid = '".$this->getID()."' AND u.gender = 1 AND u.type = 2) ";
		$result = $conn->fetchOne($query);
		return $result;
	}
	# female farmers
	function getFeMaleFarmers() {
		$conn = Doctrine_Manager::connection();
		$query = "SELECT count(f.id) FROM useraccount u WHERE (u.farmgroupid = '".$this->getID()."' AND u.gender = 2 AND u.type = 2) ";
		$result = $conn->fetchOne($query);
		return $result;
	}
	# find duplicate farmgroups after save
	function getDuplicates(){
		$q = Doctrine_Query::create()->from('FarmGroup fg')->where("fg.orgname = '".$this->getOrgName()."' AND fg.id <> '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	}
	# determine the sub groups for the farm group
	function getListOfSubGroups() {
		$q = Doctrine_Query::create()->from('FarmGroup f')->where("f.parentid = '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	}
	# determine if farm group has subgroups
	function hasSubGroups(){
		$result = $this->getListOfSubGroups();
		if($result->count() == 0){
			return false;
		}
		return true;
	}
	# determine group
	function getGroupStatus(){
		$total = 0;
		$count = 0;
		if(!isEmptyString($this->getOrgName())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getNotes())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getType())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getCountry())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getDistrictID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getDistrictID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getCountyID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getSubCountyID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getParishID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getVillageID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getStreetAddress())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getManagerID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getContactName())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getEmail())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getPhone())){
			$total += 10;
		} 
		$count += 10;
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
	# determine if a farm group has subgroup
	function isSubGroup(){
		return !isEmptyString($this->getParentID()) ? true : false;
	}
	function isGroup(){
		return isEmptyString($this->getParentID()) ? true : false;
	}
	# determine the payments made
	function getAllPayments() {
		$q = Doctrine_Query::create()->from('Payment p')->where("p.farmgroupid = '".$this->getID()."'")->orderby("p.trxdate desc");
		$result = $q->execute();
		// debugMessage($result->toArray());
		if(!$result){
			$result = $payment = new Payment();
		}
		return $result;
	}
	# determine the subcription history
	function getAllSubscription() {
		$q = Doctrine_Query::create()->from('Subscription s')->where("s.farmgroupid = '".$this->getID()."'")->orderby("s.enddate desc");
		$result = $q->execute();
		// debugMessage($result->toArray());
		if(!$result){
			$result = $subscrip = new Subscription();
		}
		return $result;
	}
	/**
	 * Get the full name of the country from the two digit code
	 * 
	 * @return String The full name of the state 
	 */
	function getCountryName() {
		if(isEmptyString($this->getCountry())){
			return "--";
		}
		$countries = getCountries(); 
		return $countries[$this->getCountry()];
	}
}
?>