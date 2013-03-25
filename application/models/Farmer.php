<?php

class Farmer extends BaseEntity {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('farmer');
		$this->hasColumn('regno', 'string', 15);
		$this->hasColumn('refno', 'string', 15);
		$this->hasColumn('userid', 'integer', null);
		$this->hasColumn('farmgroupid', 'integer', null);
		$this->hasColumn('subgroupid', 'integer', null);
		$this->hasColumn('regdate', 'date');
		
		$this->hasColumn('firstname', 'string', 255, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('lastname', 'string', 255, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('othernames', 'string', 255);
		$this->hasColumn('alias', 'string', 255);
		$this->hasColumn('salutation', 'string', 15);
		
		$this->hasColumn('email', 'string', 50);
		$this->hasColumn('isinvited', 'integer', null, array('default' => 0));
		$this->hasColumn('isphoneinvited', 'integer', null, array('default' => 0));
		$this->hasColumn('invitedbyid', 'integer', null);
		$this->hasColumn('hasacceptedinvite', 'integer', null, array('default' => 0));
		$this->hasColumn('dateinvited','date');
		
		$this->hasColumn('signature', 'string', 50);
		$this->hasColumn('educationlevel', 'integer', null); 
		$this->hasColumn('maritalstatus', 'integer', null);
		$this->hasColumn('numberofchildren', 'integer', null);
		$this->hasColumn('numberofdependants', 'integer', null);
		$this->hasColumn('totalhousehold', 'integer', null);
		$this->hasColumn('nextofkin_name', 'string', 255);
		$this->hasColumn('nextofkin_phone', 'string', 50);
		$this->hasColumn('nextofkin_email', 'string', 50);
		
		$this->hasColumn('lat', 'string', 10);
		$this->hasColumn('lng', 'string', 10);
		$this->hasColumn('lat_gps', 'string', 10);
		$this->hasColumn('lng_gps', 'string', 10);
		
		$this->hasColumn('farmingtypes', 'string', 50);
		$this->hasColumn('supporttypes', 'string', 50);
		$this->hasColumn('supportprovider', 'string', 255);
		$this->hasColumn('activitytypes', 'string', 50);
		$this->hasColumn('leadershiprole', 'string', 50);
		
		$this->hasColumn('selfregistered', 'integer', null, array('default' => 0));
	}
	/**
	 * Contructor method for custom initialization
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("dateinvited","regdate"));
		
		# set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"firstname.notblank" => $this->translate->_("farmerfirstname_error"),
       									"surname.notblank" => $this->translate->_("farmersurname_error"),
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
		$this->hasOne('FarmGroup as farmgroup',
						 array(
								'local' => 'farmgroupid',
								'foreign' => 'id'
							)
					);
		$this->hasOne('FarmGroup as subgroup',
						 array(
								'local' => 'subgroupid',
								'foreign' => 'id'
							)
					);
		$this->hasOne('UserAccount as invitedby', 
								array(
									'local' => 'invitedbyid',
									'foreign' => 'id',
								)
						);
		$this->hasMany('Farm as farms',
						 array(
								'local' => 'id',
								'foreign' => 'farmerid'
							)
					);
		$this->hasMany('Season as seasons',
						 array(
								'local' => 'id',
								'foreign' => 'farmerid'
							)
					);
		$this->hasMany('FarmCrop as farmcrops',
						 array(
								'local' => 'id',
								'foreign' => 'farmerid'
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
			$this->getErrorStack()->add("refno.unique", "The reference <b>".$this->getRefNo()."</b> already exists for another Farmer. <br />Please specify another.");
		}
		if($this->regNoExists()){
			$this->getErrorStack()->add("regno.unique", "The reference <b>".$this->getRegNo()."</b> already exists for another Farmer. <br />Please specify another.");
		}
		// debugMessage('in validate');
		// debugMessage($this->toArray(true));
		
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
		$ref_query = "SELECT id FROM farmer WHERE refno = '".$ref."' AND refno <> '' ".$id_check;
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
		$ref_query = "SELECT id FROM farmer WHERE regno = '".$ref."' AND regno <> '' ".$id_check."";
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
		# debugMessage($formvalues);
		# set default values for integers, dates, decimals
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']); 
		}
		if(isArrayKeyAnEmptyString('farmgroupid', $formvalues)){
			unset($formvalues['farmgroupid']); 
		}
		if(isArrayKeyAnEmptyString('subgroupid', $formvalues)){
			unset($formvalues['subgroupid']);
		}
		if(isArrayKeyAnEmptyString('educationlevel', $formvalues)){
			unset($formvalues['educationlevel']); 
		}
		if(isArrayKeyAnEmptyString('regdate', $formvalues)){
			unset($formvalues['regdate']); 
		}
		# set new regno from refno
		if(!isArrayKeyAnEmptyString('refno', $formvalues) && !isArrayKeyAnEmptyString('farmgroupid', $formvalues)){
			$fg = new FarmGroup();
			$fg->populate($formvalues['farmgroupid']);
			$prefix = FARMER_REG_PREFIX;
			$regno = $prefix.'/'.$fg->getRefNo()."/".$formvalues['refno'];
			$formvalues['regno'] = $regno;
		}
		
		if(!isArrayKeyAnEmptyString('farmingtypeids', $formvalues)) {
			$ids = $formvalues['farmingtypeids']; 
			$typelist = ''; 
			if(count($ids) > 0){
				$typelist = createHTMLCommaListFromArray($ids, ",");
			}
			$formvalues['farmingtypes'] = $typelist; 
			# remove the usergroups_groupid array, it will be ignored, but to be on the safe side
			unset($formvalues['farmingtypeids']); 
		} else {
			unset($formvalues['farmingtypes']); 
		}
		if(!isArrayKeyAnEmptyString('supporttypeids', $formvalues)) {
			$ids = $formvalues['supporttypeids']; 
			$typelist = ''; 
			if(count($ids) > 0){
				$typelist = createHTMLCommaListFromArray($ids, ",");
			}
			$formvalues['supporttypes'] = $typelist; 
			# remove the usergroups_groupid array, it will be ignored, but to be on the safe side
			unset($formvalues['supporttypeids']); 
		} else {
			unset($formvalues['supporttypes']); 
		}
		if(!isArrayKeyAnEmptyString('activitytypeids', $formvalues)) {
			$ids = $formvalues['activitytypeids']; 
			$typelist = ''; 
			if(count($ids) > 0){
				$typelist = createHTMLCommaListFromArray($ids, ",");
			}
			$formvalues['activitytypes'] = $typelist; 
			# remove the usergroups_groupid array, it will be ignored, but to be on the safe side
			unset($formvalues['activitytypeids']); 
		} else {
			unset($formvalues['activitytypes']); 
		}
		
		if(isArrayKeyAnEmptyString('maritalstatus', $formvalues)){
			unset($formvalues['maritalstatus']); 
		}
		if(isArrayKeyAnEmptyString('numberofchildren', $formvalues)){
			unset($formvalues['numberofchildren']); 
		}
		if(isArrayKeyAnEmptyString('numberofdependants', $formvalues)){
			unset($formvalues['numberofdependants']); 
		}
		if(isArrayKeyAnEmptyString('totalhousehold', $formvalues)){
			unset($formvalues['totalhousehold']); 
		}
		if(isArrayKeyAnEmptyString('isinvited', $formvalues)){
			unset($formvalues['isinvited']);
		}
		if(isArrayKeyAnEmptyString('isphoneinvited', $formvalues)){
			unset($formvalues['isphoneinvited']);
		}
		if(isArrayKeyAnEmptyString('hasacceptedinvite', $formvalues)){
			unset($formvalues['hasacceptedinvite']); 
		}
		if(isArrayKeyAnEmptyString('dateinvited', $formvalues)){
			unset($formvalues['dateinvited']); 
		}
		if(isArrayKeyAnEmptyString('lat', $formvalues)){
			$formvalues['lat'] = '0.326477'; 
		}
		if(isArrayKeyAnEmptyString('lng', $formvalues)){
			$formvalues['lng'] = '32.56693'; 
		}
		
		# preprocess birth info
		if(!isArrayKeyAnEmptyString('dateofbirth', $formvalues) || !isArrayKeyAnEmptyString('birthday', $formvalues) || !isArrayKeyAnEmptyString('birthmonth', $formvalues)  || !isArrayKeyAnEmptyString('birthyear', $formvalues)) {
			if(isArrayKeyAnEmptyString('dateofbirth', $formvalues)){
				$formvalues['dateofbirth'] = NULL; 
			} else {
				if(!isEmptyString($formvalues['dateofbirth'])){
					$formvalues['dateofbirth'] = changeDateFromPageToMySQLFormat($formvalues['dateofbirth']);
				} else {
					$formvalues['dateofbirth'] = NULL; 
				}
			}
			if(isArrayKeyAnEmptyString('birthday', $formvalues)){
				$formvalues['birthday'] = NULL; 
			}
			if(isArrayKeyAnEmptyString('birthmonth', $formvalues)){
				$formvalues['birthmonth'] = NULL; 
			}
			if(isArrayKeyAnEmptyString('birthyear', $formvalues)){
				$formvalues['birthyear'] = NULL; 
			}
			if(isArrayKeyAnEmptyString('birthyear', $formvalues)){
				$formvalues['birthyear'] = NULL; 
			}
			
			# if date got updated by select fields only, update birth field on farmer
			if(!isArrayKeyAnEmptyString('birthday', $formvalues) && !isArrayKeyAnEmptyString('birthmonth', $formvalues)  && !isArrayKeyAnEmptyString('birthyear', $formvalues)){
				$formvalues['dateofbirth'] = $formvalues['birthday']."-".$formvalues['birthmonth']."-".$formvalues['birthyear'];
			} else {
				$formvalues['dateofbirth'] = NULL;
			}
		}
		if(!isArrayKeyAnEmptyString('dateofbirth', $formvalues)){
			$formvalues['user']['dateofbirth'] = changeDateFromPageToMySQLFormat($formvalues['dateofbirth']);
		}
		/*if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$formvalues['user']['farmerid'] = $formvalues['id'];
		}*/
		if(!isArrayKeyAnEmptyString('firstname', $formvalues)){
			$formvalues['user']['firstname'] = $formvalues['firstname'];
		}
		if(!isArrayKeyAnEmptyString('lastname', $formvalues)){
			$formvalues['user']['lastname'] = $formvalues['lastname'];
		}
		if(!isArrayKeyAnEmptyString('gender', $formvalues)){
			$formvalues['user']['gender'] = $formvalues['gender'];
		}
		if(!isArrayKeyAnEmptyString('country2', $formvalues)){
			$formvalues['user']['country'] = $formvalues['country2'];
		}
		if(!isArrayKeyAnEmptyString('locationid', $formvalues)){
			$formvalues['user']['locationid'] = $formvalues['locationid'];
		}
		if(!isArrayKeyAnEmptyString('locationid2', $formvalues)){
			$formvalues['user']['locationid'] = $formvalues['locationid2'];
		}
		if(!isArrayKeyAnEmptyString('email', $formvalues)){
			$formvalues['user']['email'] = $formvalues['email'];
		}
		if(!isArrayKeyAnEmptyString('email2', $formvalues)){
			$formvalues['user']['email2'] = $formvalues['email2'];
		}
		if(!isArrayKeyAnEmptyString('bio', $formvalues)){
			$formvalues['user']['bio'] = $formvalues['bio'];
		}
		
		# process address information
		$address = array(); 
		$theaddress = $this->getUser()->getAddress();
		$formvalues['user']['address']['id'] = $this->getUser()->getAddressID();
		$formvalues['user']['address']['type'] = 1;
		
		if(!isArrayKeyAnEmptyString('createdby', $formvalues)){
			$formvalues['user']['address']['createdby'] = $formvalues['createdby'];
		}
		if(!isArrayKeyAnEmptyString('userid', $formvalues)){
			$formvalues['user']['address']['userid'] = $formvalues['userid'];
		}
		if(!isArrayKeyAnEmptyString('userid', $formvalues)){
			$formvalues['user']['address']['createdby'] = $formvalues['userid'];
		}
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$formvalues['user']['address']['farmerid'] = $formvalues['id'];
		} else {
			$formvalues['user']['address']['farmerid'] = NULL;
		}
		$formvalues['user']['address']['country'] = !isArrayKeyAnEmptyString('country', $formvalues) ? $formvalues['country'] : NULL;
		if(!isArrayKeyAnEmptyString('locationid2', $formvalues)){
			$formvalues['user']['address']['districtid'] = $formvalues['locationid2'];
			$formvalues['user']['locationid'] = $formvalues['locationid2'];
		}
		if(!isArrayKeyAnEmptyString('districtid', $formvalues)){
			$formvalues['user']['address']['districtid'] = $formvalues['districtid'];
			$formvalues['user']['locationid'] = $formvalues['districtid']; 
		}
		if(!isArrayKeyAnEmptyString('locationid', $formvalues)){
			$formvalues['user']['address']['districtid'] = $formvalues['locationid'];
			$formvalues['user']['locationid'] = $formvalues['locationid']; 
		}
		if(!isArrayKeyAnEmptyString('countyid', $formvalues)){
			$formvalues['user']['address']['countyid'] = $formvalues['countyid'];
		}
		if(!isArrayKeyAnEmptyString('subcountyid', $formvalues)){
			$formvalues['user']['address']['subcountyid'] = $formvalues['subcountyid'];
		}
		if(!isArrayKeyAnEmptyString('parishid', $formvalues)){
			$formvalues['user']['address']['parishid'] = $formvalues['parishid'];
		}
		if(!isArrayKeyAnEmptyString('villageid', $formvalues)){
			$formvalues['user']['address']['villageid'] = $formvalues['villageid'];
		}
		if(!isArrayKeyAnEmptyString('streetaddress', $formvalues)){
			$formvalues['user']['address']['streetaddress'] = $formvalues['streetaddress'];
		}
		
		if(!isArrayKeyAnEmptyString('added_by_farmgroup', $formvalues)){
			$formvalues['user']['type'] = 2;
			$formvalues['user']['firstname'] = $formvalues['firstname'];
			$formvalues['user']['lastname'] = $formvalues['lastname'];
			$formvalues['user']['gender'] = $formvalues['gender'];
			$formvalues['user']['email'] = $formvalues['email'];
			if(!isEmptyString($formvalues['phone'])){
				$formvalues['user']['phones'][0]['phone'] = getFullPhone($formvalues['phone']);
				$formvalues['user']['phones'][0]['isprimary'] = 1;
			}
			$formvalues['user']['createdby'] = $formvalues['addedbyid'];
			$formvalues['user']['locationid'] = $formvalues['districtid'];
			$formvalues['user']['usergroups'][0]["groupid"] = 2;
		}
		
		$phones = array();
		if(!isArrayKeyAnEmptyString('phone', $formvalues)){
			$phones[0]['phone'] = getFullPhone($formvalues['phone']);
			$phones[0]['isprimary'] = 1;
			if(!isArrayKeyAnEmptyString('userid', $formvalues)){
				$phones[0]['userid'] = $formvalues['userid'];
			}
		}
		if(!isArrayKeyAnEmptyString('phone2', $formvalues)){
			$phones[1]['phone'] = getFullPhone($formvalues['phone2']);
			$phones[1]['isprimary'] = 0;
			if(!isArrayKeyAnEmptyString('userid', $formvalues)){
				$phones[1]['userid'] = $formvalues['userid'];
			}
		}
		if(count($phones) > 0){
			$formvalues['user']['phones'] = $phones;
		}
        // debugMessage($formvalues); 
        // exit();
		parent::processPost($formvalues);
	}
	/**
	 * Return the full names, which is a concatenation of the first and the surname
	 *
	 * @return String
	 */
	function getName() {
	    return $this->getFirstName()." ".$this->getLastName()." ".$this->getOtherNames();
	}
	/**
	 * Return the full names, which is a concatenation of the first and the surname
	 *
	 * @return String
	 */
	function getListName() {
		
	    return $this->getName();
	}
	/**
     * Determine the gender strinig of a person
     * @return String the gender
     */
    function getGenderLabel(){
    	return $this->getUser()->getGender() == '1' ? 'Male' : 'Female'; 
    }
 	/**
     * Determine if a person is male
     * @return bool
     */
    function isMale(){
    	return $this->getUser()->getGender() == '1' ? true : false; 
    }
	/**
     * Determine if a person is female
     * @return bool
     */
    function isFemale(){
    	return $this->getUser()->getGender() == '2' ? true : false; 
    }
	# determine if is an admin
	function isAdmin(){
    	return $this->getUser()->getType() == 1 ? true : false; 
    }
	# determine if is a farmer
	function isFarmer(){
    	return $this->getUser()->getType() == 2 ? true : false; 
    }
	# determine if is a farm group admin
	function isFarmGroupAdmin(){
    	return $this->getUser()->getType() == 3 ? true : false; 
    }
	# determine if the farmer is the contact person of the farm group
	function isFarmGroupManager(){
		if(isEmptyString($this->getFarmGroupID())){
			return false;
		}
		$farmmanagerid = $this->getFarmGroup()->getManagerID();
		if(isEmptyString($farmmanagerid)){
			return false;
		} else {
			if($farmmanagerid == $this->getID()){
				return true;
			}
		}
	}
	# determine if the farmer registered themselves 
	function isSelfRegistered(){
		return isEmptyString($this->getFarmGroupID()) ? true : false;
	}
	/**
     * Determine the type of person
     * @return bool
     */
    function getTypeLabel(){
    	$label = '';
    	return $label; 
    }
	/**
     * Determine the person's life status label
     * @return String the life status 
     */
    function getSalutationLabel(){
    	$salution = '';
    	if(!isEmptyString($this->getSalutation()) && $this->getSalutation() != 0){
    		$lab = LookupType::getLookupValueDescription("SALUTATION", $this->getSalutation());
    		$salution = ', '.$lab;
    	}
    	return $salution; 
    }
    # determine current education level
    function getEducationLevelText() {
    	$text = '--';
    	if(!isEmptyString($this->getEducationLevel())){
    		$educlevels = getAllEducationLevels();
    		$text = $educlevels[$this->getEducationLevel()];
    	}
    	return $text;
    }
	# determine current education level
    function getMaritalStatusText() {
    	$text = '--';
    	if(!isEmptyString($this->getMaritalStatus())){
    		$allmaritalstatuses = getAllMaritalStatuses();
    		$text = $allmaritalstatuses[$this->getMaritalStatus()];
    	}
    	return $text;
    }
    # determine if person has been invited
    function hasNotBeenInvited() {
    	return $this->getIsInvited() == 0 ? true : false;
    }
    # determine if person has been subscribed
    function isSubscribed() {
    	return !isEmptyString($this->getUserID()) && $this->getUser()->isUserActive() ? true : false;
    }
	# determine if farmer has gps location so as to plot out their data
    function hasGPSCoordinates() {
    	//return !isEmptyString($this->getLat()) && !isEmptyString($this->getLng()) ? true : false;
    	return true;
    }
    function getLatGPSFormatted(){
    	return "0° 19' 35.3172";
    }
	function getLngGPSFormatted(){
    	return "32° 34' 0.9474";
    }
	function getLatGPSFormatted2(){
    	return "0° 19 35.3172";
    }
	function getLngGPSFormatted2(){
    	return "32° 34 0.9474";
    }
    function beforeSave() {
    	if(isEmptyString($this->getUser()->getPhones()->get(0)->getPhone())){
    		$this->getUser()->clearRelated('phones');
    		debugMessage('deleted');
    	}
    	return true;
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
   	 	
    	# generate registration number for farmer
    	if($this->getRegNo() != $this->getCurrentRegNo()){
			$this->setRegNo($this->getCurrentRegNo());
			$update = true;
    	}
        
    	$updateuser = false;
        if(!isEmptyString($this->getUserID())){
	    	if(isEmptyString($this->getUser()->getFarmerID())){
	    		$updateuser = true;
	    		$this->getUser()->setCreatedBy($userid);
	    		$this->getUser()->setFarmerID($this->getID());
	    	}
        }
    	if($updateuser){
    		$this->getUser()->save();
    	}
    	
    	# save changes 
    	if($update){
	        # clear related so that there is no attempt to resave
    		$this->clearRelated(); 
	        // debugMessage($this->toArray());
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
    	
    	# clear related so that there is no attempt to resave
    	$this->clearRelated(); 
    	
    	# generate registration number for farmer
    	if($this->getRegNo() != $this->getCurrentRegNo()){
			$this->setRegNo($this->getCurrentRegNo());
			$update = true;
    	}
    	
    	$signupaddress = $this->getUser()->getAddresses()->get(0);
		if(!isEmptyString($signupaddress->getID())){
    		$this->getUser()->setAddressID($signupaddress->getID());
    		$this->getUser()->save();
    		$update = true;
    	}
    	
    	# save changes 
    	if($update){
	        # clear related so that there is no attempt to resave
    		$this->clearRelated(); 
	        // debugMessage($this->toArray());
    		$this->save();
    	}
    	
    	# set the farmerid on user if not set
    	$updateuser = false;
        if(!isEmptyString($this->getUserID())){
	    	if(isEmptyString($this->getUser()->getFarmerID())){
	    		$updateuser = true;
	    		$this->getUser()->setCreatedBy($userid);
	    		$this->getUser()->setFarmerID($this->getID());
	    	}
        }
    	if($updateuser){
    		$this->getUser()->save();
    	}
		// $user->save();
		// exit();	
    	return true;
    }
	/*
	 * Custom update logic after invite
	 */
	function transactionInviteUpdate(){
		$conn = Doctrine_Manager::connection();
		// begin transaction to save
		try {
			$conn->beginTransaction();
			// save
			$this->save();
			// set owner and 
			$this->getUser()->setCreatedBy($this->getUserID());
			$this->getUser()->cleanUpAddress();
			if(isEmptyString($this->getRegNo())){
				$this->setRegNo($this->getNextRegNo());
	    	}
    	
			$this->save();
			// commit changes
			$conn->commit();
		} catch(Exception $e){
			$conn->rollback();
			// debugMessage('Error is '.$e->getMessage());
			throw new Exception($e->getMessage());
		}
		
		$this->sendInviteConfirmationNotification();
		// exit();
		return true;
	}
	# set the subscription period for the farm group
	function setNewSubscription(){
		# set subscription entry for user
		# current plan
		$plan = new MembershipPlan();
		$plan->populate($this->getUser()->getMembershipPlanID());
		# new subscription
		$subscription = new Subscription();
		$subscription->setUserID($this->getUserID());
		$subscription->setPlanID($this->getUser()->getMembershipPlanID());
		$startdate = date("Y-m-d");	
		$expirydate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate)) . " +".$plan->getUsageDays()." days "));
		$subscription->setStartDate($startdate);
		$subscription->setEndDate($expirydate);
		$subscription->setIsTrial(1);
		$subscription->setIsActive(1);
		$subscription->save();
		
		return true;
	}
	# determine if person has signature
	function hasSignature(){
		$real_path = APPLICATION_PATH.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user_";
		$real_path = $real_path.$this->getUserID().DIRECTORY_SEPARATOR."sign".DIRECTORY_SEPARATOR."large_".$this->getSignature();
		if(file_exists($real_path) && !isEmptyString($this->getSignature())){
			return true;
		}
		return false;
	}
	# determine path to signature
	function getSignaturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/images/defaultupload_small.png';
		if($this->hasSignature()){
			$path = $baseUrl.'/uploads/user_'.$this->getUserID().'/sign/thumbnail_'.$this->getSignature();
		}
		return $path;
	}
	# determine path to large signature image
	function getLargeSignPath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/images/defaultupload_small.png';
		if($this->hasSignature()){
			$path = $baseUrl.'/uploads/user_'.$this->getUserID().'/sign/large_'.$this->getSignature();
		}
		return $path;
	}
	# generate next registration number
	function getNextRegNo(){
		$regno  = '';
		$prefix = FARMER_REG_PREFIX;
		if($this->hasFarmGroup()){
			$regno = $prefix.'/'.$this->getFarmGroup()->getRefNo()."/".$this->getNextRefNo();
		} else {
			$currentyear = date("Y");
			$yeardigits = substr($currentyear, strlen($currentyear) - 2, strlen($currentyear));
			$currentmonth = date("m");
			$regno = $prefix.'/'.$yeardigits.$currentmonth.'/'.$this->getNextRefNo();
		}
		return $regno;
	}
	# generate next registration number
	function getCurrentRegNo(){
		$regno  = '';
		$prefix = FARMER_REG_PREFIX;
		if($this->hasFarmGroup()){
			$regno = $prefix.'/'.$this->getFarmGroup()->getRefNo()."/".$this->getRefNo();
		} else {
			$currentyear = date("Y");
			$yeardigits = substr($currentyear, strlen($currentyear) - 2, strlen($currentyear));
			$currentmonth = date("m");
			if(isEmptyString($this->getRefNo())){
				$regno = $prefix.'/'.$yeardigits.$currentmonth.'/'.$this->getCurrentRefNo();
			} else {
				$regno = $prefix.'/'.$yeardigits.$currentmonth.'/'.$this->getRefNo();
			}
			
		}
		return $regno;
	}
	# fetch next id
	function getNextInsertID(){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT max(id) FROM farmer ";
		$query2 = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='farmer'";
		$result = $conn->fetchOne($query2);
		return $result+1;
	}
	function getNextRefNo(){
		return number_pad($this->getNextInsertID(),4);
	}
	function getCurrentRefNo(){
		return isEmptyString($this->getRefNo()) ? number_pad($this->getID(),4) : $this->getRefNo();
	}
	# Send notification to invite person to create an account
	function sendProfileInvitationNotification() {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View(); 

		// assign values
		$template->assign('firstname', isEmptyString($this->getFirstName()) ? 'Friend' : $this->getFirstName());
		$template->assign('inviter', isEmptyString($this->getInvitedByID()) ? 'FARMIS Admin' : $this->getInvitedBy()->getName() );
		// the actual url will be built in the view
		$viewurl = $template->serverUrl($template->baseUrl('signup/index/profile/'.encode($this->getID())."/")); 
		$template->assign('invitelink', $viewurl);
		
		// determine if farm group manager is being invited
		$template->assign('isfarmgroupmanager', '0');
		if($this->getID() == $this->getFarmGroup()->getManagerID()){
			$template->assign('isfarmgroupmanager', '1');
			$template->assign('groupname', $this->getFarmGroup()->getName());
		}
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$mail->setSubject(sprintf($this->translate->_('useraccount_email_subject_invite'), $this->translate->_('appname')));
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('invitenotification.phtml'));
		//debugMessage($template->render('invitenotification.phtml')); exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	/**
	 * Send notification to inform user that profile has been activated
	 * @return bool whether or not the notification email has been sent
	 */
	function sendInviteConfirmationNotification() {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View(); 

		// assign values
		$template->assign('firstname', $this->getFirstName());
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$subject = sprintf($this->translate->_('useraccount_email_subject_invite_confirmation'), $this->translate->_('appname'));
		$mail->setSubject($subject);
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('inviteconfirmation.phtml'));
		$message_contents = $template->render('signupnotification.phtml');
		// debugMessage($template->render('inviteconfirmation.phtml')); exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		
		# save copy of message to user's application inbox
		$message_dataarray = array(
			"senderid" => 1,
			"subject" => $subject,
			"contents" => $message_contents,
			"recipients" => array(
								md5(1) => array("recipientid" => $this->getUserID())
							)
		);
		// process message data
		$message = new Message();
		$message->processPost($message_dataarray);
		$message->save();
		
		return true;
	}
	# Send contact us notification
	function sendContactNotification($dataarray) {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View(); 
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// debugMessage($first);
		// assign values
		$template->assign('name', $dataarray['name']);
		$template->assign('email', $dataarray['email']);
		$template->assign('subject', $dataarray['subject']);
		$template->assign('message', nl2br($dataarray['message']));
		
		$mail->setSubject("New FARMIS Contact Us Message: ".$dataarray['subject']);
		// set the send of the email address
		$mail->setFrom($dataarray['email'], $dataarray['name']);
		
		// configure base stuff
		$mail->addTo($this->config->notification->supportemailaddress);
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('contactconfirmation.phtml'));
		// debugMessage($template->render('contactconfirmation.phtml')); exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	# tell friends about farmis notification
	function tellFriendsNotification($dataarray) {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View(); 
		
		$first = $dataarray[0];
		
		// assign values
		$template->assign('sendername', $first['sendername']);
		$mail->setSubject($first['subject']);
		// set the send of the email address
		$mail->setFrom($first['senderemail'], $first['sendername']);
		
		// set the subject for the different participants and check that user can receive email
		foreach($dataarray as $key => $line) {
			$template->assign('themessage', $line['message']);
			
			// the actual url will be built in the view
			// $viewurl = $template->serverUrl($template->baseUrl('annnouncement')); 
			// $template->assign('detailslink', $viewurl);
			$mail->addTo($line['email']);
			$mail->setBodyHtml($template->render('emailfriendsnotification.phtml'));
			// debugMessage($template->render('emailfriendsnotification.phtml'));
			
			$mail->send();
			// clear body and recipient in each email
			$mail->clearRecipients();
			$mail->setBodyHtml('');
		}
		
		return true;
	}
	# determine the default farm for farmer
	function getFarm() {
		// debugMessage($relativeid);
		$q = Doctrine_Query::create()->from('Farm f')->where("f.farmerid = '".$this->getID()."' AND f.isdefault = '1' ");
		$result = $q->fetchOne();
		// debugMessage($result->toArray());
		if(!$result){
			$result = new Farm();
		}
		return $result;
	}
	# return the farmid 
	function getFarmID(){
		return $this->getFarm()->getID();
	}
	
	# find duplicate farmgroups after save
	function getDuplicates(){
		$q = Doctrine_Query::create()->from('Farmer f')->where("f.firstname = '".$this->getFirstName()."' AND f.lastname = '".$this->getLastName()."' AND f.farmgroupid = '".$this->getFarmGroupID()."' AND f.id <> '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	} 
	# invite one user to join. already existing persons
	function inviteOne() {
		$this->setDateInvited(date('Y-m-d'));
		$this->setIsInvited('1');
		$this->setHasAcceptedInvite('0');
		// set email on user
		if(!isEmptyString($this->getUserID())){
			$this->getUser()->setEmail($this->getEmail());
		}
		// set farmer id on user
		if(isEmptyString($this->getUser()->getFarmerID())){
			$this->getUser()->setFarmerID($this->getID());
		}
		#  inviting farm group admin
		if($this->isFarmGroupManager() && isEmptyString($this->getUserID())){
			$this->getUser()->setFirstName($this->getFirstName());
			$this->getUser()->setLastName($this->getLastName());
			$this->getUser()->setCreatedBy($this->getInvitedByID());
			$this->getUser()->setEmail($this->getEmail());
			$this->getFarmGroup()->setEmail($this->getEmail());
			if(!isEmptyString($this->getFarmGroup()->getPhone())){
				$this->getUser()->getPhones()->get(0)->setPhone($this->getFarmGroup()->getPhone());
			}
			$this->getUser()->getUserGroups()->get(0)->setGroupID(2);
			if(!isEmptyString($this->getFarmGroup()->getAddress()->getCountry())){
				$this->getUser()->getAddress()->setCountry($this->getFarmGroup()->getAddress()->getCountry());
			}
			if(!isEmptyString($this->getFarmGroup()->getAddress()->getDistrictID())){
				$this->getUser()->setLocationID($this->getFarmGroup()->getAddress()->getDistrictID());
				$this->getUser()->getAddress()->setDistrictID($this->getFarmGroup()->getAddress()->getDistrictID());	
			}
			if(!isEmptyString($this->getFarmGroup()->getAddress()->getCountyID())){
				$this->getUser()->getAddress()->setCountyID($this->getFarmGroup()->getAddress()->getCountyID());	
			}
			if(!isEmptyString($this->getFarmGroup()->getAddress()->getSubCountyID())){
				$this->getUser()->getAddress()->setSubCountyID($this->getFarmGroup()->getAddress()->getSubCountyID());	
			}
			if(!isEmptyString($this->getFarmGroup()->getAddress()->getVillageID())){
				$this->getUser()->getAddress()->setVillageID($this->getFarmGroup()->getAddress()->getVillageID());	
			}
			if(!isEmptyString($this->getFarmGroup()->getAddress()->getVillageID())){
				$this->getUser()->getAddress()->setVillageID($this->getFarmGroup()->getAddress()->getVillageID());	
			}
			$this->getUser()->getAddress()->setCreatedBy($this->getInvitedByID());
		}
		// debugMessage($this->toArray()); exit();
		$this->save();
		
		// send email
		$this->sendProfileInvitationNotification();
		
		return true;
	}
	# invite user by phone to join
	function inviteOneByPhone() {
		$this->setDateInvited(date('Y-m-d'));
		$this->setIsPhoneInvited('1');
		$this->setIsInvited('0');
		$this->getUser()->setActivationKey($this->getUser()->generateActivationKey());
		$this->setHasAcceptedInvite('0');
		
		// set farmer id on user
		if(isEmptyString($this->getUser()->getFarmerID())){
			$this->getUser()->setFarmerID($this->getID());
		}
		
		// debugMessage($this->toArray(true)); exit();
		$this->getUser()->save();
		$this->save();
		// send email
		$this->sendMobilePhoneInvitation();
	
		return true;
	}
	# send invitition message to user inbox
	function sendMobilePhoneInvitation() {
		$message = $this->getSignupInviteContent();
		// debugMessage($message);
		// $sendresult = sendSMSMessage($this->getUser()->getPhone(), $message);
		// debugMessage($sendresult);
		# saving of message to application inbox is not valid here
		return true;
	}
	# content for requesting activation code via  phone
	function getSignupInviteContent(){
		$template = new Zend_View();
		$signup_url = $template->serverUrl($template->baseUrl('signup/activate'));
		return "Dear ".$this->getUser()->getFirstName().", \nYour FARMIS activation code is: ".$this->getUser()->getActivationKey()." \nGo to ".$signup_url." and enter this code to complete.";
	} 
	# determine level of completion for primary profile
	function getStep1_1_Status(){
		$total = 0;
		$count = 0;
		if(!isEmptyString($this->getFirstName())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getLastName())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getOtherNames())){
			$total += 5;
		} 
		$count += 5;
		if(!isEmptyString($this->getSalutation())){
			$total += 5;
		} 
		$count += 5;
		if(!isEmptyString($this->getUser()->Gender())){
			$total += 10;
		} 
		$count += 10;
		
		if(!isEmptyString($this->getUser()->getDateOfBirth())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getLocationID())){
			$total += 10;
		} 
		$count += 10;
		//debugMessage($count);
		//debugMessage($total);
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
	# determine if farmer has profile picture
	function hasProfileImage(){
		if(!isEmptyString($this->getUser()->hasProfileImage())){
			return true;
		}
		return false;
	}
	# determine level of completion for primary profile
	function getStep1_3_Status(){
		$total = 0;
		$count = 0;
		if(!isEmptyString($this->getUser()->getEmail())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getPhone())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getPhones()->get(0)->isValidated())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getAddress()->getCountry())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getAddress()->getDistrictID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getAddress()->getDistrictID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getAddress()->getCountyID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getAddress()->getSubCountyID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getAddress()->getParishID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getAddress()->getVillageID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getUser()->getAddress()->getStreetAddress())){
			$total += 10;
		} 
		$count += 10;
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
	# determine level of completion for primary profile
	function getStep1_4_Status(){
		$total = 0;
		$count = 0;
		if(!isEmptyString($this->getSignature())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getEducationLevel())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getMaritalStatus())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getNumberOfChildren())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getNumberOfDependants())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getNextOfKin_Name())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getNextOfKin_Phone())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getNextOfKin_Email())){
			$total += 10;
		} 
		$count += 10;
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
	# determine if farmer has a farm group
	function hasFarmGroup(){
		return isEmptyString($this->getFarmGroupID()) ? false : true;
	}
	# determine if farmer has a sub group
	function hasSubGroup(){
		return isEmptyString($this->getSubGroupID()) ? false : true;
	}
	# format the farming types from the comma list
	function getFarminigTypesLabel(){
		$label = '--';
		if(!isEmptyString($this->getFarmingTypes())){
			$lookup_array = getFarmingTypes();
			$list_array = explode(',', $this->getFarmingTypes());
			$list_text_array = array();
			if(count($list_array) > 0){
				foreach ($list_array as $value){
					$list_text_array[$value] = $lookup_array[$value];
				}
				asort($list_text_array);
			}
			$label = createHTMLCommaListFromArray($list_text_array, ", ");
		}
		return $label;
	}
	# list of farming typeids
	function getFarmingTypeIDs(){
		$dataarray = array();
		if(!isEmptyString($this->getFarmingTypes())){
			$list_array = explode(',', $this->getFarmingTypes());
			if(is_array($list_array)){
				$dataarray = $list_array;
			}
		}
		return $dataarray;
	}
	# format the support types from the comma list
	function getSupportTypesLabel(){
		$label = '--';
		if(!isEmptyString($this->getSupportTypes())){
			$lookup_array = getSupportTypes();
			$list_array = explode(',', $this->getSupportTypes());
			$list_text_array = array();
			if(count($list_array) > 0){
				foreach ($list_array as $value){
					$list_text_array[$value] = $lookup_array[$value];
				}
				asort($list_text_array);
			}
			$label = createHTMLCommaListFromArray($list_text_array, ", ");
		}
		return $label;
	}
	# list of support typeids
	function getSupportTypeIDs(){
		$dataarray = array();
		if(!isEmptyString($this->getSupportTypes())){
			$list_array = explode(',', $this->getSupportTypes());
			if(is_array($list_array)){
				$dataarray = $list_array;
			}
		}
		return $dataarray;
	}
	# format the activity types from the comma list
	function getActivityTypesLabel(){
		$label = '--';
		if(!isEmptyString($this->getActivityTypes())){
			$lookup_array = getOtherActivityTypes();
			$list_array = explode(',', $this->getActivityTypes());
			$list_text_array = array();
			if(count($list_array) > 0){
				foreach ($list_array as $value){
					$list_text_array[$value] = $lookup_array[$value];
				}
				asort($list_text_array);
			}
			$label = createHTMLCommaListFromArray($list_text_array, ", ");
		}
		return $label;
	}
	# list of activities typeids
	function getActivityTypeIDs(){
		$dataarray = array();
		if(!isEmptyString($this->getActivityTypes())){
			$list_array = explode(',', $this->getActivityTypes());
			if(is_array($list_array)){
				$dataarray = $list_array;
			}
		}
		return $dataarray;
	}
	# return all farmers
	function getAllFarmers(){
		$q = Doctrine_Query::create()->from('Farmer f')->where("f.farmgroupid <> '' ")->limit('10');
		$result = $q->execute();
		return $result;
	}
}
?>