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
		$this->hasColumn('addressid', 'integer', null);
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
		
		$this->hasOne('Farmer as manager', 
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
		$this->hasOne('Address as address',
						 array(
								'local' => 'addressid',
								'foreign' => 'id'
							)
					); 
		$this->hasMany('Address as addresses',
						 array(
								'local' => 'id',
								'foreign' => 'farmgroupid'
							)
					);
		$this->hasMany('Farmer as farmers',
						 array(
								'local' => 'id',
								'foreign' => 'farmgroupid'
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
    	$farmerid = $session->getVar('farmerid');
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
		if(isArrayKeyAnEmptyString('addressid', $formvalues)){
			unset($formvalues['addressid']); 
		}
		if(isArrayKeyAnEmptyString('regdate', $formvalues)){
			$formvalues['regdate'] = NULL; 
		}
		
		# set new regno from refno
		if(!isArrayKeyAnEmptyString('refno', $formvalues)){
			$prefix = FARMGROUP_REG_PREFIX;
			$regno = $prefix.'/'.$formvalues['refno'];
			$formvalues['regno'] = $regno;
		}
		# process address information
		$address = array(); 
		$theaddress = $this->getAddress();
		$address[0]['id'] = $theaddress->getID();
		$address[0]['type'] = 2;
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$address[0]['farmgroupid'] = $formvalues['id'];
		}
		$address[0]['country'] = !isArrayKeyAnEmptyString('country', $formvalues) ? $formvalues['country'] : NULL;
		if(!isArrayKeyAnEmptyString('districtid', $formvalues)){
			$address[0]['districtid'] = $formvalues['districtid'];
		}
		if(!isArrayKeyAnEmptyString('countyid', $formvalues)){
			$address[0]['countyid'] = $formvalues['countyid'];
		}
		if(!isArrayKeyAnEmptyString('subcountyid', $formvalues)){
			$address[0]['subcountyid'] = $formvalues['subcountyid'];
		}
		if(!isArrayKeyAnEmptyString('parishid', $formvalues)){
			$address[0]['parishid'] = $formvalues['parishid'];
		}
		if(!isArrayKeyAnEmptyString('villageid', $formvalues)){
			$address[0]['villageid'] = $formvalues['villageid'];
		}
		if(!isArrayKeyAnEmptyString('streetaddress', $formvalues)){
			$address[0]['streetaddress'] = $formvalues['streetaddress'];
		}
		
		if(count($address) > 0){
			$formvalues['addresses'] = $address;
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
			$formvalues['manager']['type'] = 4;
			$formvalues['manager']['firstname'] = $formvalues['contactname'];
			$formvalues['manager']['lastname'] = "-";
			$formvalues['manager']['email'] = $formvalues['email'];
			$formvalues['manager']['createdby'] = $farmerid;
			// $formvalues['manager']['isinvited'] = $formvalues['isinvited'];
		} else {
			unset($formvalues['manager']);
		}
		
        // debugMessage($formvalues); 
        // exit();
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
    	$farmerid = $session->getVar('farmerid');
    	$userid = $session->getVar('userid');
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	if(!isEmptyString($this->getAddress()->getID())){
    		$this->setAddressID($this->getAddress()->getID());
    		$update = true;
    	}
    	if(isEmptyString($this->getRegDate())){
    		$this->setRegDate(date("Y-m-d"));
    		$update = true;
    	}
    	# generate registration number for farmer
    	if(isEmptyString($this->getRegNo())){
			$this->setRegNo($this->getNextRegNo());
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
    	$farmerid = $session->getVar('farmerid');
    	$userid = $session->getVar('userid');
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	if(isEmptyString($this->getRegDate())){
    		$this->setRegDate(date("Y-m-d"));
    		$update = true;
    	}
    	# generate registration number for farmer
    	if(isEmptyString($this->getRegNo())){
			$this->setRegNo($this->getNextRegNo());
			$update = true;
    	}
    	
    	# save changes 
    	if($update){
    		$this->save();
    	}
    	
    	return true;
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
	
	# generate next registration number
	function getNextRegNo(){
		$regno  = '';
		$prefix = FARMGROUP_REG_PREFIX;
		$regno = $prefix.'/'.$this->getNextRefNo();
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
	# determine the address for farmer
	function getAddress() {
		$address_object = new Address();
		$add = $this->getAddresses();
		// debugMessage($add->toArray());
		if (!isEmptyString($add->get(0)->getID())) {
			$address_object = $add->get(0);
		}
		return $address_object; 
	}
	# cleanup by creating address entry if does not exit
	function cleanUpAddress() {
		if(isEmptyString($this->getAddress()->getID())){
			$address = $this->getAddress();
			$address->setFarmGroupID($this->getID());
			$address->setCreatedBy(1);
			
			$address->save();
			if(!isEmptyString($address->getID())){
				$this->setAddressID($address->getID());
				$this->clearRelated(); 
				$this->save();
			}
		}
		return true;
	}
	# custom logic to determine the farmers in the Farm Group
	function getListOfFarmers() {
		$q = Doctrine_Query::create()->from('Farmer f')->where("f.farmgroupid = '".$this->getID()."' AND f.id <> '".$this->getManagerID()."' ")->orderby("f.firstname ASC");
		$result = $q->execute();
		return $result;
	}
	# count the number of farmers in the group
	function getCountFarmers() {
		$farmers = $this->getListOfFarmers();
		return $farmers->count();
	}
	# custom logic to determine the farmers in the Farm Group
	function getFeaturedFarmers($limit) {
		$q = Doctrine_Query::create()->from('Farmer f')->where("f.farmgroupid = '".$this->getID()."' AND f.id <> '".$this->getManagerID()."' ")->orderby("f.datecreated DESC")->limit($limit);
		$result = $q->execute();
		return $result;
	}
	# determine the invited farmers
	function getInvitedFarmers(){
		$q = Doctrine_Query::create()->from('Farmer f')->where("f.farmgroupid = '".$this->getID()."' AND f.id <> '".$this->getManagerID()."' AND f.invitedbyid = '".$this->getManagerID()."' ");
		$result = $q->execute();
		return $result;
	}
	# determine the activated invited farmers
	function getActiveFarmers(){
		$q = Doctrine_Query::create()->from('Farmer f')->innerjoin("f.user as u")->where("f.farmgroupid = '".$this->getID()."' AND f.id <> '".$this->getManagerID()."' AND u.isactive = '1' ");
		$result = $q->execute();
		return $result;
	}
	# count the number of farmers in the group that are registered
	function getCountRegisteredFarmers() {
		$farmers = $this->getInvitedFarmers();
		return $farmers->count();
		/*$conn = Doctrine_Manager::connection();
		$query = "SELECT count(f.id) FROM farmer f inner join useraccount u on (f.userid = u.id) WHERE (u.farmgroupid = '".$this->getID()."' AND f.userid IS NOT NULL AND u.isactive = 1 AND f.id <> '".$this->getManager()->getUserID()."') ";
		debugMessage($query);
		$result = $conn->fetchOne($query);
		return $result;*/
	}
	# male farmers
	function getMaleFarmers(){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT count(f.id) FROM farmer f inner join useraccount u on (f.userid = u.id) WHERE (f.farmgroupid = '".$this->getID()."' AND u.gender = 1 AND f.id <> '".$this->getManagerID()."') ";
		$result = $conn->fetchOne($query);
		return $result;
		/*$q = Doctrine_Query::create()->from('Farmer f')->innerJoin('f.user u')->where("f.farmgroupid = '".$this->getID()."' AND u.gender = 1 AND f.id <> '".$this->getManager()->getUserID()."' ");
		$result = $q->execute();
		return $result->count();*/
	}
	# female farmers
	function getFeMaleFarmers() {
		$conn = Doctrine_Manager::connection();
		$query = "SELECT count(f.id) FROM farmer f inner join useraccount u on (f.userid = u.id) WHERE (f.farmgroupid = '".$this->getID()."' AND u.gender = 2 AND f.id <> '".$this->getManagerID()."') ";
		$result = $conn->fetchOne($query);
		return $result;
		/*$q = Doctrine_Query::create()->from('Farmer f')->innerJoin('f.user u')->where("f.farmgroupid = '".$this->getID()."' AND u.gender = 2 AND f.id <> '".$this->getManager()->getUserID()."' ");
		$result = $q->execute();
		return $result->count();*/
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
		if(!isEmptyString($this->getAddress()->getCountry())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getDistrictID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getDistrictID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getCountyID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getSubCountyID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getParishID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getVillageID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getStreetAddress())){
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
}
?>