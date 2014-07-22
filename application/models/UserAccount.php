<?php

class UserAccount extends BaseEntity {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('useraccount');
		$this->hasColumn('type', 'integer', null, array( 'notnull' => true, 'notblank' => true, 'default' => '2'));
		$this->hasColumn('firstname', 'string', 255, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('lastname', 'string', 255, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('othernames', 'string', 255);
		$this->hasColumn('email', 'string', 50/*, array('notnull' => true, 'notblank' => true)*/);
		$this->hasColumn('email2', 'string', 50);
		$this->hasColumn('username', 'string', 15/*, array('notnull' => true, 'notblank' => true)*/);
		$this->hasColumn('password', 'string', 50);
		$this->hasColumn('trx_password', 'string', 50);
		$this->hasColumn('gender', 'integer', null); # 1=Male, 2=Female, 3=Unknown
		$this->hasColumn('dateofbirth','date');
		
		$this->hasColumn('country', 'string', 2, array('default' => 'UG'));
		$this->hasColumn('locationid', 'integer', null);
		$this->hasColumn('countyid', 'integer', null);
		$this->hasColumn('subcountyid', 'integer', null);
		$this->hasColumn('parishid', 'integer', null);
		$this->hasColumn('villageid', 'integer', null);
		$this->hasColumn('streetaddress', 'string', 255);
		$this->hasColumn('city', 'string', 50);
		$this->hasColumn('state', 'string', 50);
		$this->hasColumn('zipcode', 'string', 15);		
		
		$this->hasColumn('isactive', 'integer', null, array('default' => '0')); # 0=noactivated, 1=active, 2=deactivated
		$this->hasColumn('activationkey', 'string', 15);
		$this->hasColumn('activationdate', 'date');
		$this->hasColumn('agreedtoterms', 'integer', null, array('default' => '0'));	# 0=NO, 1=YES
		$this->hasColumn('membershipplanid', 'integer', null, array('default' => '1'));
		$this->hasColumn('notes', 'string', 1000);
		$this->hasColumn('securityquestion', 'integer', null);
		$this->hasColumn('securityanswer', 'integer', null);
		$this->hasColumn('bio', 'string', 1000);
		$this->hasColumn('profilephoto', 'string', 50);
		$this->hasColumn('emailmeoncomment', 'int', array('default' => '1'));
		$this->hasColumn('emailmeonmessage', 'int', array('default' => '1'));
		$this->hasColumn('dashwizard', 'integer', null, array('default' => '1')); # 0=hidden, 1=shown
		$this->hasColumn('dashwelcome', 'integer', null, array('default' => '1')); # 0=hidden, 1=shown
		
		$this->hasColumn('receivephonealerts', 'integer', null, array('default' => '1')); # 0=hidden, 1=shown
		$this->hasColumn('receiveemailalerts', 'integer', null, array('default' => '1')); # 0=hidden, 1=shown
		$this->hasColumn('updatesfrequency', 'integer', null, array('default' => '1')); # 0=hidden, 1=shown
		
		$this->hasColumn('regno', 'string', 15);
		$this->hasColumn('refno', 'string', 25);
		$this->hasColumn('farmgroupid', 'integer', null);
		$this->hasColumn('subgroupid', 'integer', null);
		$this->hasColumn('regdate', 'date');
		$this->hasColumn('alias', 'string', 255);
		$this->hasColumn('salutation', 'string', 15);
		
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
		$this->hasColumn('regsource', 'integer', null, array('default' => 0));
		
		# override the not null and not blank properties for the createdby column in the BaseEntity
		$this->hasColumn('createdby', 'integer', 11);
		
		$this->hasColumn('businessname', 'string', 255);
		$this->hasColumn('shortname', 'string', 50);
		$this->hasColumn('description', 'string', 255);
		$this->hasColumn('type', 'integer', null);
		$this->hasColumn('regno', 'string', 15);
		$this->hasColumn('regdate', 'date');
		$this->hasColumn('bizstartmonth', 'string', 4, array('default' => NULL));
		$this->hasColumn('bizstartyear', 'string', 4, array('default' => NULL));
		$this->hasColumn('logo', 'string', 255);
		$this->hasColumn('landsize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('landactivesize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('landunits', 'integer', null, array('default' => 1));
		$this->hasColumn('landacquiremethod', 'integer', null, array('default' => 1));
		$this->hasColumn('landarea', 'string', 1000);
		$this->hasColumn('gpsmeta', 'string', 500);
		$this->hasColumn('numberofbranches', 'integer', null);
		$this->hasColumn('numberofemployees', 'integer', null);
		$this->hasColumn('numberoffields', 'integer', null, array('default' => 1));
		$this->hasColumn('hashistory', 'integer', null, array('default' => 0));
		$this->hasColumn('farmingtools', 'string', 50);
		
		$this->hasColumn('phone', 'string', 15);	
		$this->hasColumn('phone_activationkey', 'string', 15);
		$this->hasColumn('phone_activationdate', 'date');
		$this->hasColumn('phone_isactivated', 'integer', null, array('default' => '0'));
		
		$this->hasColumn('phone2', 'string', 15);	
		$this->hasColumn('phone2_activationkey', 'string', 15);
		$this->hasColumn('phone2_activationdate', 'date');
		$this->hasColumn('phone2_isactivated', 'integer', null, array('default' => '0'));
	}
	
	# Contructor method for custom initialization
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("expirydate", "activationdate", "regdate"));
		
		# set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"type.notblank" => $this->translate->_("useraccount_type_error"),
       									"firstname.notblank" => $this->translate->_("useraccount_firstname_error"),
       									"lastname.notblank" => $this->translate->_("useraccount_lastname_error")
       	       						));
	}
	
	# Model relationships
	public function setUp() {
		parent::setUp(); 
		# copied directly from BaseEntity since the createdby can be NULL when a user signs up 
		# automatically set timestamp column values for datecreated and lastupdatedate 
		$this->actAs('Timestampable', 
						array('created' => array(
												'name' => 'datecreated'
											),
							 'updated' => array(
												'name'     =>  'lastupdatedate',    
												'onInsert' => false,
												'options'  =>  array('notnull' => false)
											)
						)
					);
		$this->hasMany('UserGroup as usergroups',
							array('local' => 'id',
									'foreign' => 'userid'
							)
						);
		$this->hasOne('UserAccount as creator', 
								array(
									'local' => 'createdby',
									'foreign' => 'id'
								)
						);
		$this->hasOne('Location as location',
						 array(
								'local' => 'locationid',
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
		$this->hasOne('MembershipPlan as plan', 
								array(
									'local' => 'membershipplanid',
									'foreign' => 'id'
								)
						);
		
		$this->hasMany('Payment as payments',
						 array(
								'local' => 'id',
								'foreign' => 'userid'
							)
					);
		$this->hasMany('Subscription as subscriptions',
						 array(
								'local' => 'id',
								'foreign' => 'userid'
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
		$this->hasMany('Season as seasons',
						 array(
								'local' => 'id',
								'foreign' => 'userid'
							)
					);
		$this->hasMany('FarmCrop as crops',
						 array(
								'local' => 'id',
								'foreign' => 'userid'
							)
					);
		$this->hasMany('FarmPreseason as preseasons',
						 array(
								'local' => 'id',
								'foreign' => 'userid'
							)
					);
		$this->hasMany('FarmPreseasonDetail as preseasonlines',
						 array(
								'local' => 'id',
								'foreign' => 'userid'
							)
					);
	}
	protected $varisinvited;
	protected $varisphoneinvited;
	protected $varpassword;
	protected $varsendlogintoemail;
	
	function setVarIsinvited($varisinvited){
		$this->varisinvited = $varisinvited;
	}
	function getVarIsinvited() {
		return $this->varisinvited;
	}
	function setVarIsphoneinvited($varisphoneinvited){
		$this->varisphoneinvited = $varisphoneinvited;
	}
	function getVarIsphoneinvited() {
		return $this->varisphoneinvited;
	}
	function setVarPassword($varpassword){
		$this->varpassword = $varpassword;
	}
	function getVarPassword() {
		return $this->varpassword;
	}
	function setVarSendlogintoemail($varsendlogintoemail){
		$this->varsendlogintoemail = $varsendlogintoemail;
	}
	function getVarSendlogintoemail() {
		return $this->varsendlogintoemail;
	}
	/**
	 * Custom model validation
	 */
	function validate() {
		# execute the column validation 
		parent::validate();
		// debugMessage($this->toArray(true));
		if(!isEmptyString($this->getUsername())){
			if($this->usernameExists()){
				$this->getErrorStack()->add("username.unique", sprintf($this->translate->_("useraccount_username_unique_error"), $this->getUsername()));
			}
		}
		if(!isEmptyString($this->getEmail())){
			if($this->emailExists()){
				$this->getErrorStack()->add("email.unique", sprintf($this->translate->_("useraccount_email_unique_error"), $this->getEmail()));
			}
		}
		if(!isEmptyString($this->getRefNo())){
			if($this->isKenyan() AND $this->refnoExists('', 'KE')){
				$this->getErrorStack()->add("refno.unique", $this->translate->_("useraccount_refno_unique_error"));
			}
		}
		
		$phone1 = $this->getPhone();
		if(!isEmptyString($phone1)){
			if($this->phoneExists($phone1, $this->getCountry())){
				$this->getErrorStack()->add("phone.unique", sprintf($this->translate->_("useraccount_phone_unique_error"), $this->getFormattedPhone()));
			}
		}
		$phone2 = $this->getPhone2();
		if(!isEmptyString($phone2)){
			if($this->phoneExists($phone2, $this->getCountry())){
				$this->getErrorStack()->add("phone.unique", sprintf($this->translate->_("useraccount_phone_unique_error"), $this->getFormattedPhone2()));
			}
		}
		if(!isEmptyString($phone1) && !isEmptyString($phone2)){
			if($phone2 == $phone1){
				$this->getErrorStack()->add("phone.unique", 'Phone Numbers cannot be the same');
			}
		}
		# check that at least one group has been specified
		if ($this->getUserGroups()->count() == 0) {
			$this->getErrorStack()->add("groups", $this->translate->_("useraccount_group_error"));
		}
	}
	# determine if the username has already been assigned
	function usernameExists($username =''){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
		
		if(isEmptyString($username)){
			$username = $this->getUsername();
		}
		$query = "SELECT id FROM useraccount WHERE username = '".$username."' AND username <> '' ".$id_check;
		// debugMessage($query);
		$result = $conn->fetchOne($query);
		// debugMessage($result);
		if(isEmptyString($result)){
			return false;
		}
		return true;
	}
	# determine if the email has already been assigned
	function emailExists($email =''){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
		
		if(isEmptyString($email)){
			$email = $this->getEmail();
		}
		$query = "SELECT id FROM useraccount WHERE email = '".$email."' AND email <> '' ".$id_check;
		// debugMessage($ref_query);
		$result = $conn->fetchOne($query);
		// debugMessage($ref_result);
		if(isEmptyString($result)){
			return false;
		}
		return true;
	}
	# determine if the phone has already been assigned
	function phoneExists($phone ='', $country = 'UG'){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND id <> '".$this->getID()."' ";
		}
		
		if(isEmptyString($phone)){
			$phone = $this->getPhone();
		}
		$query = "SELECT id FROM useraccount WHERE phone = '".$phone."' AND phone <> '' AND phone_isactivated = 1 ".$id_check;
		// debugMessage($ref_query);
		$result = $conn->fetchOne($query);
		// debugMessage($ref_result);
		if(isEmptyString($result)){
			return false;
		}
		return true;
	}
	# determine if the refno has already been assigned
	function refnoExists($idno ='', $country = 'UG'){
		$conn = Doctrine_Manager::connection();
		# validate unique username and email
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND u.id <> '".$this->getID()."' ";
		}
		
		if(isEmptyString($idno)){
			$idno = $this->getRefNo();
		}
		$query = "SELECT u.id FROM useraccount u WHERE u.refno = '".$idno."' AND u.country = '".$country."' ".$id_check;
		// debugMessage($query);
		$result = $conn->fetchOne($query);
		// debugMessage($ref_result);
		if(isEmptyString($result)){
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
		$ref_query = "SELECT id FROM useraccount WHERE regno = '".$ref."' AND regno <> '' ".$id_check."";
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
		$session = SessionWrapper::getInstance();
		$userid = $session->getVar('userid');
		
		# if the passwords are not changed , set value to null
		if(isArrayKeyAnEmptyString('password', $formvalues)){
			unset($formvalues['password']); 
		} else {
			$this->setVarPassword($formvalues['password']);
			$formvalues['password'] = sha1($formvalues['password']); 
		}
		
		if(!isArrayKeyAnEmptyString('phone', $formvalues)){
			if(strtoupper($formvalues['country']) == 'KE'){
				$formvalues['phone'] = str_pad(ltrim($formvalues['phone'], '0'), 12, COUNTRY_CODE_KE, STR_PAD_LEFT);
			} else {
				$formvalues['phone'] = str_pad(ltrim($formvalues['phone'], '0'), 12, COUNTRY_CODE_UG, STR_PAD_LEFT);
			}
		}
		if(!isArrayKeyAnEmptyString('phone2', $formvalues)){
			if(strtoupper($formvalues['country']) == 'KE'){
				$formvalues['phone2'] = str_pad(ltrim($formvalues['phone2'], '0'), 12, COUNTRY_CODE_KE, STR_PAD_LEFT);
			} else {
				$formvalues['phone2'] = str_pad(ltrim($formvalues['phone2'], '0'), 12, COUNTRY_CODE_UG, STR_PAD_LEFT);
			}
		}
	
		if(!isArrayKeyAnEmptyString('firstname', $formvalues)){
			$formvalues['firstname'] = ucfirst($formvalues['firstname']);
		}
		if(!isArrayKeyAnEmptyString('lastname', $formvalues)){
			$formvalues['lastname'] = ucfirst($formvalues['lastname']);
		}
		# force setting of default none string column values. enum, int and date 	
		if(isArrayKeyAnEmptyString('isactive', $formvalues)){
			unset($formvalues['isactive']); 
		}
		if(isArrayKeyAnEmptyString('agreedtoterms', $formvalues)){
			unset($formvalues['agreedtoterms']); 
		}
		if(isArrayKeyAnEmptyString('gender', $formvalues)){
			unset($formvalues['gender']); 
		}
		if(isArrayKeyAnEmptyString('activationdate', $formvalues)){
			unset($formvalues['activationdate']); 
		}
		if(isArrayKeyAnEmptyString('membershipplanid', $formvalues)){
			unset($formvalues['membershipplanid']); 
		}
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		}
		if(!isArrayKeyAnEmptyString('country2', $formvalues)){
			$formvalues['country'] = $formvalues['country2'];
		}
		if(isArrayKeyAnEmptyString('locationid', $formvalues)){
			unset($formvalues['locationid']); 
		}
		if(!isArrayKeyAnEmptyString('locationid', $formvalues)){
			$formvalues['locationid'] = $formvalues['locationid'];
		}
		if(!isArrayKeyAnEmptyString('locationid2', $formvalues)){
			$formvalues['locationid'] = $formvalues['locationid2'];
		}
		if(isArrayKeyAnEmptyString('locationid', $formvalues)){
			unset($formvalues['locationid']);
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
		
		if(isArrayKeyAnEmptyString('emailmeoncomment', $formvalues)){
			unset($formvalues['emailmeoncomment']); 
		}
		if(isArrayKeyAnEmptyString('emailmeonmessage', $formvalues)){
			unset($formvalues['emailmeonmessage']); 
		}
		if(isArrayKeyAnEmptyString('dashwizard', $formvalues)){
			unset($formvalues['dashwizard']);
		}
		if(isArrayKeyAnEmptyString('dashwelcome', $formvalues)){
			unset($formvalues['dashwelcome']);
		}
		# move the data from $formvalues['usergroups_groupid'] into $formvalues['usergroups'] array
		# the key for each group has to be the groupid
		if(isArrayKeyAnEmptyString('id', $formvalues)) {
			if(!isArrayKeyAnEmptyString('type', $formvalues)) {
				$formvalues['usergroups_groupid'] = array($formvalues['type']);
			}
		}
		if (array_key_exists('usergroups_groupid', $formvalues)) {
			$groupids = $formvalues['usergroups_groupid']; 
			$usergroups = array(); 
			foreach ($groupids as $id) {
				$usergroups[]['groupid'] = $id; 
			}
			$formvalues['usergroups'] = $usergroups; 
			# remove the usergroups_groupid array, it will be ignored, but to be on the safe side
			unset($formvalues['usergroups_groupid']); 
		}
		
		# add the userid if the useraccount is being edited
		if (!isArrayKeyAnEmptyString('id', $formvalues)) {
			if (array_key_exists('usergroups', $formvalues)) {
				$usergroups = $formvalues['usergroups']; 
				foreach ($usergroups as $key=>$value) {
					$formvalues['usergroups'][$key]["userid"] = $formvalues["id"];
				}
			} 
		}
		
		if(!isArrayKeyAnEmptyString('country', $formvalues)){
			if($formvalues['country'] == 'KE'){
				if(!isArrayKeyAnEmptyString('refno', $formvalues)){
					$formvalues['refno'] = $formvalues['refno'];
				}
			}
		}
		
		if(isArrayKeyAnEmptyString('farmgroupid', $formvalues)){
			if(!isArrayKeyAnEmptyString('farmgroupid_old', $formvalues)){
				$formvalues['farmgroupid'] = NULL;
			} else {
				unset($formvalues['farmgroupid']); 
			}
		}
		if(isArrayKeyAnEmptyString('subgroupid', $formvalues)){
			if(!isArrayKeyAnEmptyString('subgroupid_old', $formvalues)){
				$formvalues['subgroupid'] = NULL;
			} else {
				unset($formvalues['subgroupid']); 
			}
		}
		if(isArrayKeyAnEmptyString('educationlevel', $formvalues)){
			if(!isArrayKeyAnEmptyString('educationlevel_old', $formvalues)){
				$formvalues['educationlevel'] = NULL;
			} else {
				unset($formvalues['educationlevel']); 
			}
		}
		if(isArrayKeyAnEmptyString('regdate', $formvalues)){
			unset($formvalues['regdate']);
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
			if(!isArrayKeyAnEmptyString('farmingtypeids_old', $formvalues)){
				$formvalues['farmingtypes'] = NULL;
			} else {
				unset($formvalues['farmingtypes']); 
			}
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
			if(!isArrayKeyAnEmptyString('supporttypes_old', $formvalues)){
				$formvalues['supporttypes'] = NULL;
			} else {
				unset($formvalues['supporttypes']); 
			}
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
			if(!isArrayKeyAnEmptyString('activitytypes_old', $formvalues)){
				$formvalues['activitytypes'] = NULL;
			} else {
				unset($formvalues['activitytypes']); 
			}
		}
		
		if(!isArrayKeyAnEmptyString('farmingtoolsids', $formvalues)) {
			// if(!isEmptyString($formvalues['farmingtoolsids'])){
			$ids = $formvalues['farmingtoolsids']; 
			$typelist = ''; 
			if(count($ids) > 0){
				$typelist = createHTMLCommaListFromArray($ids, ",");
			}
			$formvalues['farmingtools'] = $typelist; 
			# remove the usergroups_groupid array, it will be ignored, but to be on the safe side
			unset($formvalues['farmingtoolsids']); 
			
		} else {
			if(!isArrayKeyAnEmptyString('farmingtools_old', $formvalues)){
				$formvalues['farmingtools'] = NULL;
			} else {
				unset($formvalues['farmingtools']); 
			}
		}
		
		if(isArrayKeyAnEmptyString('maritalstatus', $formvalues)){
			if(!isArrayKeyAnEmptyString('maritalstatus_old', $formvalues)){
				$formvalues['maritalstatus'] = NULL;
			} else {
				unset($formvalues['maritalstatus']); 
			}
		}
		if(isArrayKeyAnEmptyString('numberofchildren', $formvalues)){
			if(!isArrayKeyAnEmptyString('numberofchildren_old', $formvalues)){
				$formvalues['numberofchildren'] = NULL;
			} else {
				unset($formvalues['numberofchildren']); 
			} 
		}
		if(isArrayKeyAnEmptyString('numberofdependants', $formvalues)){
			if(!isArrayKeyAnEmptyString('numberofdependants_old', $formvalues)){
				$formvalues['numberofdependants'] = NULL;
			} else {
				unset($formvalues['numberofdependants']); 
			}  
		}
		if(isArrayKeyAnEmptyString('totalhousehold', $formvalues)){
			if(!isArrayKeyAnEmptyString('totalhousehold_old', $formvalues)){
				$formvalues['totalhousehold'] = NULL;
			} else {
				unset($formvalues['totalhousehold']); 
			}
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
			$formvalues['dateofbirth'] = changeDateFromPageToMySQLFormat($formvalues['dateofbirth']);
		}
		
		if(!isArrayKeyAnEmptyString('password', $formvalues)){
			$formvalues['isinvited'] = NULL;
			$formvalues['isphoneinvited'] = NULL;
			$formvalues['invitedbyid'] = NULL;
		}
		
		if(!isArrayKeyAnEmptyString('adminactivate', $formvalues)){
			if($formvalues['adminactivate'] == 1){
				$formvalues['isactive'] = 1;
				$formvalues['membershipplanid'] = 1;
				$formvalues['activationdate'] = date("Y-m-d H:i:s");
				$formvalues['agreedtoterms'] = 1;
				$formvalues['isinvited'] = NULL;
				$formvalues['isphoneinvited'] = NULL;
				$formvalues['invitedbyid'] = NULL;
			}
		}
		
		if(!isArrayKeyAnEmptyString('parishname', $formvalues) && isArrayKeyAnEmptyString('parishid', $formvalues)){
			$formvalues['parish']['locationtype'] = 5;
			$formvalues['parish']['createdby'] = $userid;
			$formvalues['parish']['name'] = $formvalues['parishname'];
			if(!isArrayKeyAnEmptyString('locationid', $formvalues)){	
				$formvalues['parish']['districtid'] = $formvalues['locationid'];
				$regionid = getRegionForDistrict($formvalues['locationid']);
				if(!isEmptyString($regionid)){
					$formvalues['parish']['regionid'] = $regionid;
				}
			}
			if(!isArrayKeyAnEmptyString('countyid', $formvalues)){	
				$formvalues['parish']['countyid'] = $formvalues['countyid'];
			}
			if(!isArrayKeyAnEmptyString('subcountyid', $formvalues)){		
				$formvalues['parish']['subcountyid'] = $formvalues['subcountyid'];
			}
		}
		if(!isArrayKeyAnEmptyString('villagename', $formvalues) && isArrayKeyAnEmptyString('villageid', $formvalues)){
			$formvalues['village']['locationtype'] = 6;
			$formvalues['village']['createdby'] = $userid;
			$formvalues['village']['name'] = $formvalues['villagename'];
			if(!isArrayKeyAnEmptyString('locationid', $formvalues)){	
				$formvalues['village']['districtid'] = $formvalues['locationid'];
				$regionid = getRegionForDistrict($formvalues['locationid']);
				if(!isEmptyString($regionid)){
					$formvalues['village']['regionid'] = $regionid;
				}
			}
			if(!isArrayKeyAnEmptyString('countyid', $formvalues)){	
				$formvalues['village']['countyid'] = $formvalues['countyid'];
			}
			if(!isArrayKeyAnEmptyString('subcountyid', $formvalues)){		
				$formvalues['village']['subcountyid'] = $formvalues['subcountyid'];
			}
			if(!isArrayKeyAnEmptyString('parishid', $formvalues)){	
				$formvalues['village']['parishid'] = $formvalues['parishid'];
			}
		}
		
		$crops = array();
		if(!isArrayKeyAnEmptyString('regsource', $formvalues)){
			if($formvalues['regsource'] == 1 && $formvalues['regsource'] == 3){
				if(!isArrayKeyAnEmptyString('receivephonealerts', $formvalues)){
					$formvalues['receivephonealerts'] = $formvalues['receivephonealerts'];
				} else {
					$formvalues['receivephonealerts'] = NULL;
				}
				
				if(!isArrayKeyAnEmptyString('receiveemailalerts', $formvalues)){
					$formvalues['receiveemailalerts'] = $formvalues['receiveemailalerts'];
				} else {
					$formvalues['receiveemailalerts'] = NULL;
				}
				if(!isArrayKeyAnEmptyString('updatesfrequency', $formvalues)){
					$formvalues['updatesfrequency'] = $formvalues['updatesfrequency'];
				}
			}
		}
		
		$crops = array();
		if(!isArrayKeyAnEmptyString('cropids', $formvalues)){
			foreach ($formvalues['cropids'] as $key => $value){
				if(!isArrayKeyAnEmptyString('id', $formvalues)){
					$existing_crops = $this->getCropsForUser($formvalues['id'], $value);
					$crops[$existing_crops['id']]['id'] = $existing_crops['id'];
					$crops[$existing_crops['id']]['userid'] = $formvalues['id'];
					$crops[$existing_crops['id']]['cropid'] = $value;
				} else {
					$crops[md5($key)]['cropid'] = $value;
				} 
			}
			
		}
		if(count($crops) > 0){
			$formvalues['crops'] = $crops;
		}
		 
		if(!isArrayKeyAnEmptyString('isphoneinvited', $formvalues) && isArrayKeyAnEmptyString('phone', $formvalues)){
			if($formvalues['isphoneinvited'] == 1){
				unset($formvalues['isphoneinvited']);
			}
		}
		if(!isArrayKeyAnEmptyString('isinvited', $formvalues) && isArrayKeyAnEmptyString('email', $formvalues)){
			if($formvalues['isinvited'] == 1){
				unset($formvalues['isinvited']);
			}
		}
		
		if(!isArrayKeyAnEmptyString('isinvited', $formvalues)){
			$this->setVarIsinvited($formvalues['isinvited']);
		}
		if(!isArrayKeyAnEmptyString('isphoneinvited', $formvalues)){
			$this->setVarIsphoneinvited($formvalues['isphoneinvited']);
		}
		
		if(isArrayKeyAnEmptyString('businessname', $formvalues)){
			if(!isArrayKeyAnEmptyString('firstname', $formvalues) && !isArrayKeyAnEmptyString('lastname', $formvalues)){
				$formvalues['businessname'] = $formvalues['firstname'].' '.$formvalues['lastname']."'s Farm";				
			}
		}
		if(isArrayKeyAnEmptyString('bizstartmonth', $formvalues)){
			if(!isArrayKeyAnEmptyString('bizstartmonth_old', $formvalues)){
				$formvalues['bizstartmonth'] = NULL;
			} else {
				unset($formvalues['bizstartmonth']); 
			}
		}
		if(isArrayKeyAnEmptyString('bizstartyear', $formvalues)){
			if(!isArrayKeyAnEmptyString('bizstartyear_old', $formvalues)){
				$formvalues['bizstartyear'] = NULL;
			} else {
				unset($formvalues['bizstartyear']); 
			}
		}
		if(isArrayKeyAnEmptyString('landsize', $formvalues)){
			if(!isArrayKeyAnEmptyString('landsize_old', $formvalues)){
				$formvalues['landsize'] = NULL;
			} else {
				unset($formvalues['landsize']); 
			}
		}
		if(isArrayKeyAnEmptyString('landactivesize', $formvalues)){
			if(!isArrayKeyAnEmptyString('landactivesize_old', $formvalues)){
				$formvalues['landactivesize'] = NULL;
			} else {
				unset($formvalues['landactivesize']); 
			}
		}
		if(isArrayKeyAnEmptyString('landunits', $formvalues)){
			if(!isArrayKeyAnEmptyString('landunits_old', $formvalues)){
				$formvalues['landunits'] = NULL;
			} else {
				unset($formvalues['landunits']); 
			}
		}
		if(isArrayKeyAnEmptyString('landacquiremethod', $formvalues)){
			if(!isArrayKeyAnEmptyString('landacquiremethod_old', $formvalues)){
				$formvalues['landacquiremethod'] = NULL;
			} else {
				unset($formvalues['landacquiremethod']); 
			}
		}
		if(isArrayKeyAnEmptyString('landarea', $formvalues)){
			if(!isArrayKeyAnEmptyString('landarea_old', $formvalues)){
				$formvalues['landarea'] = NULL;
			} else {
				unset($formvalues['landarea']); 
			}
		}
		if(isArrayKeyAnEmptyString('numberofbranches', $formvalues)){
			if(!isArrayKeyAnEmptyString('numberofbranches_old', $formvalues)){
				$formvalues['numberofbranches'] = NULL;
			} else {
				unset($formvalues['numberofbranches']); 
			}
		}
		if(isArrayKeyAnEmptyString('numberofemployees', $formvalues)){
			if(!isArrayKeyAnEmptyString('numberofemployees_old', $formvalues)){
				$formvalues['numberofemployees'] = NULL;
			} else {
				unset($formvalues['numberofemployees']); 
			}
		}
		if(isArrayKeyAnEmptyString('numberoffields', $formvalues)){
			if(!isArrayKeyAnEmptyString('numberoffields_old', $formvalues)){
				$formvalues['numberoffields'] = NULL;
			} else {
				unset($formvalues['numberoffields']); 
			}
		}
		if(isArrayKeyAnEmptyString('hashistory', $formvalues)){
			unset($formvalues['hashistory']);
		}
		if(!isArrayKeyAnEmptyString('profiledby', $formvalues)){
			if($formvalues['profiledby'] != $userid){
				$formvalues['invitedbyid'] = $userid;
			}
			$formvalues['createdby'] = $formvalues['profiledby'];
		}
		// debugMessage($formvalues); // exit();
		parent::processPost($formvalues);
	}
	/*
	 * Custom save logic
	 */
	function transactionSave(){
		$conn = Doctrine_Manager::connection();
		$session = SessionWrapper::getInstance();
		$userid = $session->getVar('userid');
		
		# begin transaction to save
		try {
			$conn->beginTransaction();
			# initial save
			$this->save();
			
			# update the ids on the profiles
			if($this->isSelfRegistered() && $this->isFarmer()){
				$this->setCreatedBy($this->getID());
				$this->setActivationKey($this->generateActivationKey());
				
				# generate registration number for farmer
				if($this->isUgandan()){
					$this->setRefNo($this->getCurrentRefNo());
					$this->setRegNo($this->getCurrentRegNo());
				}
				$this->setPhone_ActivationKey($this->getActivationKey());
			}
			
			# save current profile changes
			$this->save(); // debugMessage($this->toArray());
			
		 	# commit changes
			$conn->commit();
		} catch(Exception $e){
			$conn->rollback();
			// debugMessage('Error is '.$e->getMessage());
			throw new Exception($e->getMessage());
		}
		
		// find any duplicates and delete them
    	$duplicates = $this->getDuplicates();
    	$countdup = $duplicates->count();
		if($countdup > 0){
			$duplicates->delete();
		}
		
		# send signup notification to email for public registration
		if($this->isSelfRegistered()){
			$this->sendSignupNotification();
			# send signup activation to phone
			if(!isEmptyString($this->getPhone())){
				$this->sendSignupCodeToMobile();
			}
		} else {
			if($this->isFarmer()){
				$session->setVar('custommessage', 'Farmer ID# '.$this->getRefNo().' generated.');
			}
		}
		
		// exit();
		return true;
	}
	function beforeSave() {
    	return true;
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
    	
    	# clear related so that there is no attempt to resave
    	$this->clearRelated(); 
    	
    	# generate registration number for farmer
    	if(isEmptyString($this->getRefNo())){
			$this->setRefNo($this->generateRefNo());
			$this->setRegNo($this->getCurrentRegNo());
			$this->save();
    		if($this->isFarmer()){
				$session->setVar('custommessage', 'Farmer ID# '.$this->getRefNo().' generated.');
			}
		}
    	
   		# invite user to activate
		if($this->getVarIsinvited() == 1 && !isEmptyString($this->getEmail())){
			$this->inviteOne();
			$session->setVar('emailinvitesuccess', sprintf($this->translate->_("farmer_invite_email_success"), $this->getEmail()));
		}
		// invite the farmer to activate via phone
		if($this->getVarIsphoneinvited() == 1 && !isEmptyString($this->getPhone())){
			$this->inviteOneByPhone();
			$session->setVar('phoneinvitesuccess', sprintf($this->translate->_("farmer_invite_phone_success"), $this->getFormattedPhone()));
		}
		# send credentials to email 
		if($this->getVarSendlogintoemail() == 1 && !isEmptyString($this->_getParam('email'))){
			$password = $this->getVarPassword();
			$this->sendCredentialsByEmail($password);
			$session->setVar('emailinvitesuccess', sprintf($this->translate->_("farmer_login_email_success"), $this->getEmail()));
		}
        
		// $user->save();
		// exit();	
    	return true;
    }
	/**
	 * Reset the password for  the user. All checks and validations have been completed
	 * 
	 * @param String $newpassword The new password. If the new password is not defined, a new random password is generated
	 *
	 * @return Boolean TRUE if the password is changed, FALSE if it fails to change the user's password.
	 */
	 function resetPassword($newpassword = "") {
	 	# check if the password is empty 
	 	if (isEmptyString($newpassword)) {
	 		# generate a new random password
	 		$newpassword = $this->generatePassword(); 
	 	}
	 	return $this->changePassword("", $newpassword, false); 
	}
	/**
	 * Change the password for the user. All checks and validations have been completed
	 * 
	 * @param String $providedpassword The password provided on the screen
	 * @param String $newpassword The new password
	 *
	 * @return TRUE if the password is changed, FAlSE if it fails to change the user's password.
	 */
	function changePassword($providedpassword, $newpassword){
		// now change the password
		$this->setPassword(sha1($newpassword));
      	$this->setActivationKey('');
      	$this->setIsActive(1);
      	$this->setAgreedToTerms(1);
      	if(isEmptyString($this->getActivationDate())){
      		$startdate = date("Y-m-d H:i:s");
			$this->setActivationDate($startdate);
      	}
      	// debugMessage($this->toArray()); // exit();
      	try {
      		$this->save();
      		# Log to audit trail that a password has been changed.
			/*$audit_values = array("transactiontype" => USER_CHANGE_PASSWORD, "userid" => $this->getID(), "executedby" => $this->getID(), "success" => 'Y');
			$audit_values['transactiondetails'] = $this->getName()." changed account password";*/
			// $this->notify(new sfEvent($this, USER_CHANGE_PASSWORD, $audit_values));
      	
      	} catch (Exception $e){
      		# Log to audit trail that user has failed to change password
			/*$audit_values = array("transactiontype" => USER_CHANGE_PASSWORD, "userid" => $this->getID(), "executedby" => $this->getID(), "success" => 'N');
			$audit_values['transactiondetails'] = $this->getName()." failed to change account password". $e->getMessage();*/
			// $this->notify(new sfEvent($this, USER_CHANGE_PASSWORD, $audit_values));
			debugMessage('error is '.$e->getMessage());
      	}
      	// debugMessage($this->toArray());
		return true;
	}
	/*
	 * Reset the user's password and send a notification to complete the recovery  
	 *
	 * @return Boolean TRUE if resetting is successful and FALSE if emailaddress security questions and answer is invalid or has no record in the database
	 */
	function recoverPassword() {
      // save to the audit trail
		$audit_values = array("transactiontype" => USER_RECOVER_PASSWORD); 
		// set the updater of the account only when specified
		if (!isEmptyString($this->getLastUpdatedBy())) {
			$audit_values['executedby'] = $this->getLastUpdatedBy();
		}
		
		# check that the user's email exists and that they are signed up
		/*if(!$this->findByEmail($this->getEmail())){
			$audit_values['transactiondetails'] = "Recovery of password for '".$this->getEmail()."' failed - user not found";
			// $this->notify(new sfEvent($this, USER_RECOVER_PASSWORD, $audit_values));
			return false;
		}*/
			
		# reset the password and set the next password change date
		$this->setActivationKey($this->generateActivationKey());
		# save the activation key for the user 
		$this->save();
		
		# Send the user the reset password email
		$this->sendRecoverPasswordEmail();
		
		// save the audit trail record
		// the transaction details is the email address being used to
		$audit_values['userid'] = $this->getID(); 
		$audit_values['transactiondetails'] = "Password Recovery link for '".$this->getEmail()."' sent to '".$this->getEmail()."'";
		$audit_values['success'] = 'Y';
		// s$this->notify(new sfEvent($this, USER_RECOVER_PASSWORD, $audit_values));
		
		return true;
	}
	/**
	 * Send an email with a link to activate the members' account
	 */
	function sendRecoverPasswordEmail() {
		$template = new EmailTemplate(); 
		// create mail object
		$mail = getMailInstance(); 

		// assign values
		$template->assign('firstname', $this->getFirstName());
		// just send the parameters for the activationurl, the actual url will be built in the view 
		// $template->assign('resetpasswordurl', array("controller"=> "user","action"=> "resetpassword", "actkey" => $this->getActivationKey(), "id" => encode($this->getID())));
		$viewurl = $template->serverUrl($template->baseUrl('user/resetpassword/id/'.encode($this->getID())."/actkey/".$this->getActivationKey()."/")); 
		$template->assign('resetpasswordurl', $viewurl);
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail());
		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$mail->setSubject($this->translate->_('useraccount_email_subject_recoverpassword'));
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('recoverpassword.phtml'));
		// debugMessage($template->render('recoverpassword.phtml')); 
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
   }
   /**
    * Process the activation key from the activation email
    * 
    * @param $actkey The activation key 
    * 
    * @return bool TRUE if the signup process completes successfully, false if activation key is invalid or save fails
    */
   function activateAccount($actkey, $acttype = false, $checkkey = true) {
   		# save to the audit trail
		$isphoneactivation = $acttype;
		# validate the activation key 
		if($this->getActivationKey() != $actkey && $checkkey){
			// debugMessage('failed');
			# Log to audit trail when an invalid activation key is used to activate account
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "N");
			$audit_values["transactiondetails"] = "Invalid Activation Code specified for User(".$this->getID().") (".$this->getEmail()."). "; 
			// $this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
			$this->getErrorStack()->add("user.activationkey", $this->translate->_("useraccount_invalid_actkey_error"));
			return false;
		}
		
		# set active to true and blank out activation key
		$this->setIsActive(1);		
		$this->setActivationKey("");
		$startdate = date("Y-m-d H:i:s");
		$this->setActivationDate($startdate);
		
		# save
		try {
			$this->save();
			
			# if user activated via phone. automatically set thier phone as validated.
			if($isphoneactivation){
				# activate account
				$this->activate();
				# send confirmation to mobile
				$this->sendSignupConfirmationToMobile();
			} else {
				# save copy of welcome message to user's inbox
				$subject = "Account Successfully Activated";
				$message_contents = $this->getSignupAccountConfirmationContent();
				$message_dataarray = array(
					"senderid" => 1,
					"subject" => $subject,
					"contents" => $message_contents,
					"recipients" => array(
										md5(1) => array("recipientid" => $this->getID())
									)
				);
				// process message data
				$message = new Message();
				$message->processPost($message_dataarray);
				$message->save();
			}
			
			# set subscription entry for user
			$this->setNewSubscription();
			// debugMessage($subscription->toArray());
			
			# Add to audittrail that a new user has been activated.
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "Y");
			$audit_values["transactiondetails"] = $this->getID()." (".$this->getEmail().") has completed the sign up process"; 
			// $this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
		
			return true;
			
		} catch (Exception $e){
			$this->getErrorStack()->add("user.activation", $this->translate->_("useraccount_activation_error"));
			$this->logger->err("Error activating useraccount ".$this->getEmail()." ".$e->getMessage());
			// debugMessage($e->getMessage());
			# log to audit trail when an error occurs in updating payee details on user account
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "N");
			$audit_values["transactiondetails"] = "An error occured in activating account for User(".$this->getID().") (".$this->getEmail()."): ".$e->getMessage(); 
			// $this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
			return false;
		}
   	}
   
   	# change user's email
	function changeEmailOnAccount($actkey) {
		$session = SessionWrapper::getInstance(); 
		# validate the activation key 
		if($this->getActivationKey() != $actkey){
			// debugMessage('failed');
			# Log to audit trail when an invalid activation key is used to activate account
			$this->getErrorStack()->add("profile.emailchangekey", "Invalid key specified for activation");
			$session->setVar(ERROR_MESSAGE, "Invalid key specified for activation");
			return false;
		} else {
			# set active to true and blank out activation key
			$this->setActivationKey("");
			$this->setEmail($this->getTempEmail());
			$this->setTempEmail('');
			
			$this->save();
			
			return true;
		}
   }
	# change user's email
	function changePhoneOnAccount($actkey) {
		$session = SessionWrapper::getInstance(); 
		# validate the activation key 
		if($this->getActivationKey() != $actkey){
			// debugMessage('failed');
			# Log to audit trail when an invalid activation key is used to activate account
			$this->getErrorStack()->add("profile.emailchangekey", "Invalid key specified for activation");
			$session->setVar(ERROR_MESSAGE, "Invalid key specified for activation");
			return false;
		} else {
			# set active to true and blank out activation key
			$this->setActivationKey("");
			$this->setPhone($this->getTempPhone());
			$this->setTempPhone('');
			
			$this->save();
			
			return true;
		}
   }
	/**
    * Process the deactivation for an agent
    * 
    * @param $actkey The activation key 
    * 
    * @return bool TRUE if the signup process completes successfully, false if activation key is invalid or save fails
    */
   function deactivateAccount() {
   		# save to the audit trail
   		
		# set active to true and blank out activation key
		$this->setIsActive('0');		
		$this->setActivationKey('');
		// $this->setActivationDate(NULL);
		
		# save
		try {
			$this->save();
			return true;
			
		} catch (Exception $e){
			$this->getErrorStack()->add("user.activation", $this->translate->_("useraccount_activation_error"));
			$this->logger->err("Error activating useraccount ".$this->getEmail()." ".$e->getMessage());
			# log to audit trail when an error occurs in updating payee details on user account
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "N");
			$audit_values["transactiondetails"] = "An error occured in activating account for ".$this->getFirstName()." ".$this->getLastName(). " (".$this->getEmail()."). ".$e->getMessage(); 
			// $this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
			return false;
		}
   }
	/**
	 * Send a notification to agent that their account will be approved shortly
	 * 
	 * @return bool whether or not the signup notification email has been sent
	 *
	 */
	function sendSignupNotification() {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance(); 

		# assign values
		$template->assign('firstname', $this->getFirstName());
		$viewurl = $template->serverUrl($template->baseUrl('signup/activate/id/'.encode($this->getID())."/actkey/".$this->getActivationKey()."/"));
		if($this->getRegSource() == 1){
			$viewurl = $template->serverUrl($template->baseUrl('mobile/activate/id/'.encode($this->getID())."/actkey/".$this->getActivationKey()."/"));
		} 
		$template->assign('activationurl', $viewurl);
		$template->assign('actcode', $this->getActivationKey());
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		# configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		# set the send of the email address
		$subject = sprintf($this->translate->_('useraccount_email_subject_signup'), $this->translate->_('appname'));
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$mail->setSubject($subject);
		# render the view as the body of the email
		$mail->setBodyHtml($template->render('signupnotification.phtml'));
		// debugMessage($template->render('signupnotification.phtml')); // exit();
		$message_contents = $template->render('signupnotification.phtml');
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
								md5(1) => array("recipientid" => $this->getID())
							)
		);
		// process message data
		$message = new Message();
		$message->processPost($message_dataarray);
		$message->save();
		
		return true;
	}
	
	# set activation code to change user's email
	function triggerEmailChange($newemail) {
		$this->setActivationKey($this->generateActivationKey());
		$this->setTempEmail($newemail);
		$this->save();
		$this->sendNewEmailActivation();
		return true;
	}
	
	# send new email change confirmation
	function sendNewEmailActivation() {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View();
		
		// assign values
		$template->assign('firstname', $this->getFirstName());
		$template->assign('newemail', $this->getTempEmail());
		$viewurl = $template->serverUrl($template->baseUrl('profile/newemail/id/'.encode($this->getID()).'/actkey/'.$this->getActivationKey())); 
		$template->assign('activationurl', $viewurl);
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$mail->setSubject($this->translate->_('useraccount_email_subject_changeemail'));
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('emailchangenotification.phtml'));
		// debugMessage($template->render('emailchangenotification.phtml')); exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
/**
	 * Send a notification to agent that their account will be approved shortly
	 * 
	 * @return bool whether or not the signup notification email has been sent
	 *
	 */
	function sendDeactivateNotification() {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance(); 

		// assign values
		$template->assign('firstname', $this->getFirstName());
		// $template->assign('activationurl', array("action"=> "activate", "actkey" => $this->getActivationKey(), "id" => encode($this->getID())));
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$mail->setSubject("Account Deactivation");
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('accountdeactivationconfirmation.phtml'));
		// debugMessage($template->render('accountdeactivationconfirmation.phtml')); // exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	# change email notification to new address
	function sendNewEmailNotification($newemail) {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance(); 
		
		// assign values
		$template->assign('firstname', $this->getFirstName());
		$template->assign('fromemail', $this->getEmail());
		$template->assign('toemail', $newemail);
		$template->assign('code', $this->getActivationKey());
		$viewurl = $template->serverUrl($template->baseUrl('profile/changeemail/id/'.encode($this->getID())."/actkey/".$this->getActivationKey()."/ref/".encode($newemail)."/"));
		$template->assign('activationurl', $viewurl);
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($newemail, $this->getName());
		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$mail->setSubject("Email Change Request");
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('changeemail_newnotification.phtml'));
		// debugMessage($template->render('changeemail_newnotification.phtml')); exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	
	# change email notification to old address
	function sendOldEmailNotification($newemail) {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance(); 
		
		// assign values
		$template->assign('firstname', $this->getFirstName());
		$template->assign('fromemail', $this->getEmail());
		$template->assign('toemail', $newemail);
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$mail->setSubject("Email Change Request");
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('changeemail_oldnotification.phtml'));
		// debugMessage($template->render('changeemail_oldnotification.phtml')); //exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	/**
	 * Generate a new password incase a user wants a new password
	 * 
	 * @return String a random password 
	 */
    function generatePassword() {
		return $this->generateRandomString($this->config->password->minlength);
    }
	/**
	 * Generate a 10 digit activation key  
	 * 
	 * @return String An activation key
	 */
    function generateActivationKey() {
		return substr(md5(uniqid(mt_rand(), 1)), 0, 6);
    }
   /**
    * Find a user account either by their email address 
    * 
    * @param String $email The email
    * @return UserAccount or FALSE if the user with the specified email does not exist 
    */
	function findByEmail($email) {
		# query active user details using email
		$q = Doctrine_Query::create()->from('UserAccount u')->where('u.email = ?', $email);
		$result = $q->fetchOne(); 
		
		# check if the user exists 
		if(!$result){
			# user with specified email does not exist, therefore is valid
			$this->getErrorStack()->add("user.invalid", $this->translate->_("useraccount_user_invalid_error"));
			return false;
		}
		
		$data = $result->toArray(); 

		# merge all the data including the user groups 
		$this->merge($data);
		# also assign the identifier for the object so that it can be updated
		$this->assignIdentifier($data['id']); 
		
		return true; 
	}
	# find user by email
	function populateByEmail($email) {
		# query active user details using email
		$q = Doctrine_Query::create()->from('UserAccount u')->where('u.email = ?', $email);
		$result = $q->fetchOne(); 
		
		# check if the user exists 
		if(!$result){
			$result = new UserAccount();
		}
		
		return $result; 
	}
	# find user by phone
	function populateByPhone($phone, $key = '') {
		/*# query active user details using email
		$c = new Doctrine_RawSql();
		$c->select('{u.*}, {p.*}');
		$c->from('useraccount u INNER JOIN userphone p ON (p.userid = u.id)');
		$c->where("(p.phone = '".$phone."') AND u.activationkey = '.$key.' ");
		$c->addComponent('u', 'UserAccount u');
		$c->addComponent('p', 'u.phones p');
		
		$user_phone = $c->execute();
		// debugMessage($user_phone->get(0)->toArray());
		return $user_phone->get(0);*/
		
		$query = Doctrine_Query::create()->from('UserAccount u')
		->innerJoin('u.phones p')
		->where("p.phone = '".$phone."'")
		->andWhere("u.activationkey = '".$key."'");
		//debugMessage($query->getSQLQuery());
		$result = $query->execute();
		return $result->get(0);
		
	}
	function fetchByPhone($phone) {
		$phone = substr($this->_getParam("email"), '-9');
		// debugMessage($phone);
		$query = Doctrine_Query::create()->from('UserAccount u')
		->innerJoin('u.phones p')
		->innerJoin('u.farmer f')
		->where("(p.phone LIKE '%".$phone."' OR f.refno = '".$phone."') ");
		
		//debugMessage($query->getSQLQuery());
		$result = $query->execute();
		return $result->get(0);
		
	}
	function findByUsername($username) {
		# query active user details using email
		$q = Doctrine_Query::create()->from('UserAccount u')->where('u.username = ?', $username);
		$result = $q->fetchOne(); 
		
		if($result){
			$data = $result->toArray(); 
		} else {
			$data = $this->toArray(); 
		}
		
		# merge all the data including the user groups 
		$this->merge($data);
		# also assign the identifier for the object so that it can be updated
		if($result){
			$this->assignIdentifier($data['id']);
		} 
		
		return true; 
	}
	/**
	 * Return the user's full names, which is a concatenation of the first and last names
	 *
	 * @return String The full name of the user
	 */
	function getName() {
		return $this->getFirstName()." ".$this->getLastName();
	}
	# function to determine the user's profile path
	function getProfilePath() {
		$path = "";
		$view = new Zend_View();
		// $path = '<a href="'.$view->serverUrl($view->baseUrl('user/'.strtolower($this->getUserName()))).'">'.$view->serverUrl($view->baseUrl('user/'.strtolower($this->getUserName()))).'</a>';
		$path = '<a href="javascript: void(0)">'.$view->serverUrl($view->baseUrl('user/'.strtolower($this->getUserName()))).'</a>';
		return $path;
	}
	/*
	 * TODO Put proper comments
	 */
	function generateRandomString($length) {
		$rand_array = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9");
		$rand_id = "";
		for ($i = 0; $i <= $length; $i++) {
			$rand_id .= $rand_array[rand(0, 35)];
		}
		return $rand_id;
	}
 	/**
     * Return an array containing the IDs of the groups that the user belongs to
     *
     * @return Array of the IDs of the groups that the user belongs to
     */
    function getGroupIDs() {
        $ids = array();
        $groups = $this->getUserGroups();
        //debugMessage($groups->toArray());
        foreach($groups as $thegroup) {
            $ids[] = $thegroup->getGroupID();
        }
        return $ids;
    }
    /**
     * Display a list of groups that the user belongs
     *
     * @return String HTML list of the groups that the user belongs to
     */
    function displayGroups() {
        $groups = $this->getUserGroups();
        $str = "";
        if ($groups->count() == 0) {
            return $str;
        }
        $str .= '<ul class="list">';
        foreach($groups as $thegroup) {
            $str .= "<li>".$thegroup->getGroup()->getName()."</li>"; 
        }
        $str .= "</ul>";
        return $str; 
    }
	
	/**
     * Determine the gender strinig of a person
     * @return String the gender
     */
    function getGenderLabel(){
    	return $this->getGender() == '1' ? 'Male' : 'Female'; 
    }
 	/**
     * Determine if a person is male
     * @return bool
     */
    function isMale(){
    	return $this->getGender() == '1' ? true : false; 
    }
	/**
     * Determine if a person is female
     * @return bool
     */
    function isFemale(){
    	return $this->getGender() == '2' ? true : false; 
    }
    
	# Determine gender text depending on the gender
	function getGenderText(){
		if($this->isMale()){
			return 'Male';
		} else {		
			return 'Female';
		}
	}
	/**
	 * Return the user's gender reference, 'his' for Male and 'her' for female
	 *
	 * @return String The gender reference
	 */
	function getGenderString() {
		$text = 'their';
		switch ($this->getGender()) {
			case 'M':
				$text = 'his';
				break;
			case 'F':
				$text = 'her';
				break;
			default:
				$text = 'their';
		}
		return $text;
	}
	# Determine if user profile has been activated
	function isActivated(){
		return $this->getChangePassword() == 1;
	}
	# Determine if user has accepted terms
	function hasAcceptedTerms(){
		return $this->getAcceptedTerms() == 1;
	}
    # Determine if user is active	 
	function isUserActive() {
		return $this->getIsActive() == 1;
	}
    # Determine if user is deactivated
	function isUserInActive() {
		return $this->getIsActive() == 0;
	}
	# determine if is an admin
	function isAdmin(){
    	return $this->getType() == 1 ? true : false; 
    }
	# determine if is a farmer
	function isFarmer(){
    	return $this->getType() == 2 ? true : false; 
    }
	# determine if is a farm group admin
	function isFarmGroupAdmin(){
    	return $this->getType() == 3 ? true : false; 
    }
	# determine if is a data clerk / pia
	function isDataClerk(){
    	return $this->getType() == 4 ? true : false; 
    }
	function isPIA(){
    	return $this->getType() == 4 ? true : false; 
    }
	# determine if is a data clerk
	function isManagement(){
    	return $this->getType() == 5 ? true : false; 
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
		return isEmptyString($this->getFarmGroupID()) && $this->getselfregistered() == '1' ? true : false;
	}
    # determine if farmer is ugandan
    function isUgandan() {
    	return $this->getCountry() == 'UG' ? true : false; 
    }
	# determine if farmer is kenyan
    function isKenyan() {
    	return $this->getCountry() == 'KE' ? true : false; 
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
    # determine type label
	function getTypeLabel() {
		$text = '--';
		switch ($this->getType()) {
			case '1':
				$text = 'Admin';
				break;
			case '2':
				$text = 'Farmer';
				break;
			case '3':
				$text = 'Group Admin';
				break;
			case '4':
				$text = 'PIA';
				break;
			case '5':
				$text = 'Management';
				break;
			default:
				$text = '--';
		}
		return $text;
	}
	/**
	 * Return the date of birth 
	 * @return string dateofbirth 
	 */
	function getBirthDateFormatted() {
		$birth = "--";
		if(!isEmptyString($this->getDateOfBirth())){
			$birth = changeMySQLDateToPageFormat($this->getDateOfBirth());
		} 
		return $birth;
	}
	# relative path to profile image
	function hasProfileImage(){
		$real_path = APPLICATION_PATH.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user_";
		$real_path = $real_path.$this->getID().DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR."large_".$this->getProfilePhoto();
		if(file_exists($real_path) && !isEmptyString($this->getProfilePhoto())){
			return true;
		}
		return false;
	}
	# determine if person has profile image
	function getRelativeProfilePicturePath(){
		$real_path = APPLICATION_PATH.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user_";
		$real_path = $real_path.$this->getID().DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR."medium_".$this->getProfilePhoto();
		if(file_exists($real_path) && !isEmptyString($this->getProfilePhoto())){
			return $real_path;
		}
		$real_path = APPLICATION_PATH.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user_0".DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR."default_medium_male.jpg";
		if($this->isFemale()){
			$real_path = APPLICATION_PATH.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user_0".DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR."default_medium_female.jpg";
		}
		return $real_path;
	}
	
	# determine path to small profile picture
	function getSmallPicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = "";
		if($this->isMale()){
			$path = $baseUrl.'/uploads/user_0/avatar/default_small_male.jpg';
		}  
		if($this->isFemale()){
			$path = $baseUrl.'/uploads/user_0/avatar/default_small_female.jpg'; 
		}
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/user_'.$this->getID().'/avatar/small_'.$this->getProfilePhoto();
		}
		return $path;
	}
	# determine path to thumbnail profile picture
	function getThumbnailPicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = "";
		if($this->isMale()){
			$path = $baseUrl.'/uploads/user_0/avatar/default_thumbnail_male.jpg';
		}  
		if($this->isFemale()){
			$path = $baseUrl.'/uploads/user_0/avatar/default_thumbnail_female.jpg'; 
		}
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/user_'.$this->getID().'/avatar/thumbnail_'.$this->getProfilePhoto();
		}
		return $path;
	}
	# determine path to medium profile picture
	function getMediumPicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = "";
		if($this->isMale()){
			$path = $baseUrl.'/uploads/user_0/avatar/default_medium_male.jpg';
		}  
		if($this->isFemale()){
			$path = $baseUrl.'/uploads/user_0/avatar/default_medium_female.jpg'; 
		}
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/user_'.$this->getID().'/avatar/medium_'.$this->getProfilePhoto();
		}
		// debugMessage($path);
		return $path;
	}
	# determine path to large profile picture
	function getLargePicturePath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = "";
		if($this->isMale()){
			$path = $baseUrl.'/uploads/user_0/avatar/default_large_male.jpg';
		}  
		if($this->isFemale()){
			$path = $baseUrl.'/uploads/user_0/avatar/default_large_female.jpg'; 
		}
		if($this->hasProfileImage()){
			$path = $baseUrl.'/uploads/user_'.$this->getID().'/avatar/large_'.$this->getProfilePhoto();
		}
		# debugMessage($path);
		return $path;
	}
	# check for user using password and phone number
	function validateUserUsingPhone($password, $phone, $country ='UG'){
		$formattedphone = getFullPhone($phone);
		$conn = Doctrine_Manager::connection();
		
		/*AND UPPER(country) = '".strtoupper($country)."'*/
		$query = "SELECT * from useraccount as u where ((u.phone LIKE '%".$phone."' OR u.refno = '".$phone."' OR u.username = '".$phone."') AND u.password = '".sha1($password)."') group by u.id ";
		// debugMessage($query);
		$result = $conn->fetchAll($query);
		// debugMessage($result); // exit();
		
		return $result;
	}
	# check for user using password and phone number
	function validateExistingPhone($phone){
		$formattedphone = getFullPhone($phone);
		$conn = Doctrine_Manager::connection();
		$query = " ";
		// debugMessage($query);
		$result = $conn->fetchRow($query);
		// debugMessage($result);
		return $result;
	}
	# determine the default farm for farmer
	function getLatestSubscription() {
		// debugMessage($relativeid);
		$q = Doctrine_Query::create()->from('Subscription s')->where("s.userid = '".$this->getID()."' AND s.isactive = 1 ");
		$result = $q->fetchOne();
		// debugMessage($result->toArray());
		if(!$result){
			$result = $subscrip = new Subscription();
		}
		return $result;
	}
	# determine the payments made
	function getAllPayments() {
		$q = Doctrine_Query::create()->from('Payment p')->where("p.userid = '".$this->getID()."'")->orderby("p.trxdate desc");
		$result = $q->execute();
		// debugMessage($result->toArray());
		if(!$result){
			$result = $payment = new Payment();
		}
		return $result;
	}
	# determine the subcription history
	function getAllSubscription() {
		$q = Doctrine_Query::create()->from('Subscription s')->where("s.userid = '".$this->getID()."'")->orderby("s.enddate desc");
		$result = $q->execute();
		// debugMessage($result->toArray());
		if(!$result){
			$result = $subscrip = new Subscription();
		}
		return $result;
	}
	# check for all phones
	function populateAllPhones(){
		$q = Doctrine_Query::create()->from('UserPhone')->where("id <> '' ");
		$result = $q->execute();
		/*$conn = Doctrine_Manager::connection();
		$query = "SELECT * from userphone where id <> '' ";
		// debugMessage($query);
		$result = $conn->fetchAll($query);*/
		return $result;
	}
	# determine wether to show the welcome for user's dashboard
	function showWelcome() {
		return $this->getDashWelcome() == 1 ? true : false;
	}
	# determine wether to show the wizard for user's dashboard
	function showWizard() {
		return $this->getDashWizard() == 1 ? true : false;
	}
	# get user's address
	function getFarmerAddress(){
		if(!isEmptyString($this->getAddressID())){
			$result = $this->getAddress();
		} else {
			$q = Doctrine_Query::create()->from('Address a')->where("a.userid = '".$this->getID()."' AND a.type = 1 ");
			$result = $q->fetchOne();
			if(!$result){
				$result = new Address();
			}
		}
		return $result;
	}
	# farmer's other enterprises
	function getTheEnterprises() {
		$q = Doctrine_Query::create()->from('FarmCrop fc')->innerJoin('fc.crop c')->where("fc.userid = '".$this->getID()."' AND c.categoryid = '27' ");
		$result = $q->execute();
		return $result;
	}
	# farmer's crops
	function getTheCrops() {
		$q = Doctrine_Query::create()->from('FarmCrop fc')->innerJoin('fc.crop c')->where("fc.userid = '".$this->getID()."' AND c.categoryid <> '27' ");
		$result = $q->execute();
		return $result;
	}
	# determine current enterprises
    function getEnterpriseIDs() {
        $ids = array();
        $crops = $this->getCrops();
        $q = Doctrine_Query::create()->from('FarmCrop fc')->innerJoin('fc.crop c')->where("fc.userid = '".$this->getID()."' AND c.categoryid = '27' ");
		$result = $q->execute();
        if($result){
	        //debugMessage($groups->toArray());
	        foreach($result as $crop) {
	        	if($crop->getCrop()->getCategoryID() == 27){
	            	$ids[] = $crop->getCropID();
	        	}
	        }
        }
        return $ids;
    }
	# determine the cropids
	function getCropIDs($enterprise = false) {
        $ids = array();
        $crops = $this->getCrops();
        if($crops){
	        //debugMessage($groups->toArray());
	        foreach($crops as $crop) {
	        	if($crop->getCrop()->getCategoryID() != 27){
	            	$ids[] = $crop->getCropID();
	        	}
	        }
        }
        return $ids;
    }
	function getCropsArray() {
		$names = array();
        $crops = $this->getTheCrops();
        if($crops){
	        //debugMessage($groups->toArray());
	        foreach($crops as $crop) {
	        	if($crop->getCrop()->getCategoryID() != 27){
	            	$names[] = $crop->getCrop()->getName();
	        	}
	        }
        }
        return $names;
	}
	# return the formatted phone number of the form 07X
	function getFormattedPhone($country = 'UG'){
		if(isEmptyString($this->getPhone())){
			return '';
		}
		$phone = str_pad(ltrim($this->getPhone(), '256'), 10, '0', STR_PAD_LEFT);
		if($this->isKenyan() || strtolower($country) == 'ke'){
			$phone = str_pad(ltrim($this->getPhone(), '254'), 10, '0', STR_PAD_LEFT);
		}
		return $phone; 
	}
	function getFormattedPhone2($country = 'UG'){
		if(isEmptyString($this->getPhone2())){
			return '';
		}
		$phone = str_pad(ltrim($this->getPhone2(), '256'), 10, '0', STR_PAD_LEFT);
		if($this->isKenyan() || strtolower($country) == 'ke'){
			$phone = str_pad(ltrim($this->getPhone2(), '254'), 10, '0', STR_PAD_LEFT);
		}
		return $phone; 
	}
	function getStatusLabel($type = 1){
		$label = '&nbsp; <span class="pagedescription" style="color:#ca464c;">(Unconfirmed)</span';
		$validated = false;
		if($type == 1){
			if($this->isPhoneValidated()){
	            $validated = true;                            
	            $label = '&nbsp; <span class="pagedescription" style="color:#55A411;">(Confirmed)</span';
	        }
		}
		if($type == 2){
			if($this->isPhone2Validated()){
	            $validated = true;                            
	            $label = '&nbsp; <span class="pagedescription" style="color:#55A411;">(Confirmed)</span';
	        }
		}
		
        return $label;
	} 
	# determine if phone is validated
	function isPhoneValidated(){
		return $this->getPhone_IsActivated() == 1 ? true : false;
	}
	function isPhone2Validated(){
		return $this->getPhone2_IsActivated() == 1 ? true : false;
	}
	# determine if phone is validated
	function hasPendingActivation($type = 1){
		if($type == 1){
			return !isEmptyString($this->getPhone_ActivationKey()) && $this->isValidKey() && !$this->isPhoneValidated() ? true : false;
		}
		if($type == 2){
			return !isEmptyString($this->getPhone2_ActivationKey()) && $this->isValidKey(2) && !$this->isPhone2Validated() ? true : false;
		}
	}
	function isValidKey($type = 1){
		if($type == 1){
			return strlen($this->getPhone_ActivationKey()) == 6 ? true : false; 
		}
		if($type == 2){
			return strlen($this->getPhone2_ActivationKey()) == 6 ? true : false; 
		}
	}
	# Generate a 6 digit activation key  
    function generatePhoneActivationKey() {
		return substr(md5(uniqid(mt_rand(), 1)), 0, 6);
    }
	# generate activation code
	function generateActivationCode($type = 2){
		if($type == 1){
			$this->setPhone_ActivationKey($this->generateActivationKey());
		}
		if($type == 2){
			$this->setPhone2_ActivationKey($this->generateActivationKey());
		}
		$this->save();
		
		return true;
	}
	# send activation code to the user's mobile phone
	function sendActivationCodeToMobile() {
		$message = $this->getActivationCodeContent();
		// debugMessage($message);
		$sendresult = sendSMSMessage($this->getPhone(), $message);
		// debugMessage($sendresult);
		# saving of message to application inbox is not valid here
		return true;
	}
	# content for requesting activation code via  phone
	function getActivationCodeContent(){
		return "Dear ".$this->getFirstName().", \nThank you for your interest in the FARMIS Program. Your mobile phone activation code is: ".$this->getPhone_ActivationKey();
	}
	# send activation code to the user's mobile phone
	function sendSignupCodeToMobile() {
		$message = $this->getSignupCodeContent();
		// debugMessage($this->getPhone().' >> '.$message);
		$sendresult = sendSMSMessage($this->getPhone(), $message);
		// debugMessage($sendresult);
		# saving of message to application inbox is not valid here
		return true;
	}
	# content for requesting activation code via  phone
	function getSignupCodeContent(){
		return "Dear ".$this->getFirstName().", \nThank you for your interest in the FARMIS Program. Your registration activation code is: ".$this->getActivationKey();
	}
	# verify that a code specified is valid for activation
	function verifyPhone($code){
		return $this->getPhone_ActivationKey() == $code ? true : false;
	}
	
	# activate account by clearing the activation code, setting flag to true and setting activation date
	function activate(){
		$this->setPhone_ActivationKey('');
		$this->setPhone_IsActivated(1);
		$this->setPhone_ActivationDate(date("Y-m-d H:i:s"));
		$this->save();
		
		return true;
	}
	# send validation activation confirmation to the user's mobile phone
	function sendActivationConfirmationToMobile() {
		$message = $this->getActivationConfirmationContent();
		// debugMessage($message);
		$sendresult = sendSMSMessage($this->getPhone(), $message);
		// debugMessage($sendresult);
		
		# save copy of message to user's application inbox
		$subject = "Phone Number Successfully Activated";
		$message_dataarray = array(
			"senderid" => 1,
			"subject" => $subject,
			"contents" => $this->getSignupAccountConfirmationContent(),
			"recipients" => array(
								md5(1) => array("recipientid" => $this->getID())
							)
		);
		// process message data
		$message = new Message();
		$message->processPost($message_dataarray);
		$message->save();
		
		return true;
	}
	# content of confirmation message upon confirmation
	function getActivationConfirmationContent(){
		return "Dear ".$this->getFirstName().", \nYour mobile phone ".$this->getFormattedPhone()." has been successfully validated. Thank you for being apart of the FARMIS Program.";
	}
	# content of confirmation message upon confirmation
	function getSignupAccountConfirmationContentMobile(){
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$contactus_url = $baseUrl.'/contactus';
		$password_url = $baseUrl.'/profile/view/id/'.encode($this->getID()).'/tab/account';
		return "Dear ".$this->getFirstName().", <br /><br />Your mobile phone ".$this->getFormattedPhone()." has been successfully validated. You can now login anytime using either Email, Phone or Username with the password you provided during registration. <br /><br /> You can also change your password anytime by <a href='".$password_url."' title='Change Password'>clicking here</a>.  <br /><br />For any help or assistance, <a href='".$contactus_url."'>Contact us</a> ";
	}
	# content of confirmation message upon confirmation
	function getSignupAccountConfirmationContent(){
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$contactus_url = $baseUrl.'/contactus';
		$password_url = $baseUrl.'/profile/view/id/'.encode($this->getID().'/tab/account');
		return "Dear ".$this->getFirstName().", <br /><br />Your FARMIS Account has been successfully activated. You can now login anytime using either Email, Phone or Username with the password you provided during registration. <br /><br /> You can also change your password anytime by <a href='".$password_url."' title='Change Password'>clicking here</a>.  <br /><br />For any help or assistance, <a href='".$contactus_url."'>Contact us</a> ";
	}
	# send signup activation confirmation to the user's mobile phone
	function sendSignupConfirmationToMobile() {
		$message = $this->getSignupPhoneConfirmationContent();
		// debugMessage($message);
		$sendresult = sendSMSMessage($this->getPhone(), $message);
		// debugMessage($sendresult);
		
		# save copy of message to user's application inbox
		$subject = "Account Successfully Activated";
		$message_dataarray = array(
			"senderid" => 1,
			"subject" => $subject,
			"contents" => $this->getSignupInboxConfirmationContent(),
			"recipients" => array(
								md5(1) => array("recipientid" => $this->getID())
							)
		);
		// process message data
		$message = new Message();
		$message->processPost($message_dataarray);
		$message->save();
		
		return true;
	}
	# content of confirmation message upon confirmation
	function getSignupPhoneConfirmationContent(){
		return "Dear ".$this->getFirstName().", \nYour FARMIS Account and Phone have been successfully activated. You can now login anytime using either Email, Phone or Username";
	}
	function getSignupInboxConfirmationContent(){
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$contactus_url = $baseUrl.'/contactus';
		$password_url = $baseUrl.'/profile/view/id/'.encode($this->getID()).'/tab/account';
		return "Dear ".$this->getFirstName().", <br /><br />Your FARMIS Account and Phone have been successfully activated. You can now login anytime using either Email, Phone or Username with the password you provided during registration. <br /><br /> You can also change your password anytime by <a href='".$password_url."' title='Change Password'>clicking here</a>.  <br /><br />For any help or assistance, <a href='".$contactus_url."'>Contact us</a> ";
	}
	# set activation code to change user's email
	function triggerPhoneChange($newphone) {
		$this->setPhone2_ActivationKey($this->generateActivationKey());
		$this->setPhone2($newphone);
		$this->save();
		$this->sendNewPhoneActivation();
		return true;
	}
	
	# send new phone activation code to mobile
	function sendNewPhoneActivation() {
		$message = $this->translate->_('appname')." New Phone Activation Code: ".$this->getPhone2_ActivationKey();
		// debugMessage($message);
		$sendresult = sendSMSMessage($this->getPhone2(), $message);
		// debugMessage($sendresult);
		// exit();
		return true;
	}
	# determine the network provider for phone number
	function getProvider(){
		return getPhoneProvider($this->getFormattedPhone());
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
    	return $this->isUserActive() ? true : false;
    }
	# determine if farmer has gps location so as to plot out their data
    function hasGPSCoordinates() {
    	return !isEmptyString($this->getLat()) && !isEmptyString($this->getLng()) ? true : false;
    	// return true;
    }
    function getLatGPSFormatted(){
    	return /*"0° 19' 35.3172"*/$this->getLat_Gps();
    }
	function getLngGPSFormatted(){
    	return /*"32° 34' 0.9474"*/$this->getLng_Gps();
    }
	function getLatGPSFormatted2(){
    	return "0° 19 35.3172";
    }
	function getLngGPSFormatted2(){
    	return "32° 34 0.9474";
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
			$this->setCreatedBy($this->getID());
			if(isUganda()){
				if(isEmptyString($this->getRegNo())){
					$this->setRegNo($this->getCurrentRegNo());
		    	}
		    	if(isEmptyString($this->getRefNo())){
		    		$this->setRefNo($this->generateRefNo());
		    	}
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
		$plan->populate($this->getMembershipPlanID());
		# new subscription
		$subscription = new Subscription();
		$subscription->setUserID($this->getID());
		$subscription->setPlanID($this->getMembershipPlanID());
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
		$real_path = $real_path.$this->getID().DIRECTORY_SEPARATOR."sign".DIRECTORY_SEPARATOR."large_".$this->getSignature();
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
			$path = $baseUrl.'/uploads/user_'.$this->getID().'/sign/thumbnail_'.$this->getSignature();
		}
		return $path;
	}
	# determine path to large signature image
	function getLargeSignPath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/images/defaultupload_small.png';
		if($this->hasSignature()){
			$path = $baseUrl.'/uploads/user_'.$this->getID().'/sign/large_'.$this->getSignature();
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
			$regno = $prefix.'/'.$yeardigits.$currentmonth.'/'.$this->getRefNo();
		}
		return $regno;
	}
	# fetch next id
	function getNextInsertID(){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT max(u.refno) FROM useraccount u where u.farmgroupid is not null AND u.farmgroupid = '".$this->getFarmGroupID()."' ";
		$result = $conn->fetchOne($query);
		return $result+1;
	}
	# fetch max refno for subscribers 
	function getNextPublicInsertID(){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT max(u.id) FROM useraccount u  where u.farmgroupid is null ";
		$result = $conn->fetchOne($query);
		return $result;
	}
	function getNextRefNo(){
		$ref = number_pad($this->getNextInsertID(),4);
		if(!$this->hasFarmGroup()){
			$ref = $this->getNextPublicInsertID();
		}
		return $ref;
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
		$template->assign('type', $this->getType());
		
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
								md5(1) => array("recipientid" => $this->getID())
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
		$session = SessionWrapper::getInstance();
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View(); 
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		$supportemail = $this->config->notification->supportemailaddress;
		$supportid = 1;
		if(isKenya() || getCountry()=='ke'){
			$supportemail = 'farmis@sokopepe.co.ke';
			$supportid = 3131;
			if(APPLICATION_ENV == development){
				$supportemail = 'farmissokopepe@devmail.infomacorp.com';
			}
		}
		
		// debugMessage($first);
		// assign values
		$subjects = getContactUsCategories();
		$template->assign('name', $dataarray['name']);
		$template->assign('email', $dataarray['email']);
		$template->assign('subject', $subjects[$dataarray['subject']]);
		$template->assign('message', nl2br($dataarray['message']));
		
		$mail->setSubject("New FARMIS Contact Us Message: ".$dataarray['subject']);
		// set the send of the email address
		$mail->setFrom($dataarray['email'], $dataarray['name']);
		
		// configure base stuff
		$mail->addTo($supportemail);
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('contactconfirmation.phtml'));
		// debugMessage($template->render('contactconfirmation.phtml')); exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		# save copy of welcome message to user's inbox
		$subject = $subjects[$dataarray['subject']];
		$senderid = $session->getVar('userid');
		if(isEmptyString($session->getVar('userid'))){
			$senderid = 0;
		}
		$message_contents = $template->render('contactconfirmation.phtml');
		$message_dataarray = array(
			"senderid" => $senderid,
			"sendername" => $dataarray['name'],
			"senderemail" => $dataarray['email'],
			"senderid" => $senderid,
			"subject" => $subject,
			"contents" => $message_contents,
			"country" => $dataarray['country'],
			"recipients" => array(
								md5(1) => array("recipientid" => $supportid)
							)
		);
		
		// if kenya contact us message, copy to uganda admin inbox
		if(strtolower($dataarray['country']) == 'ke'){
			$message_dataarray['recipients'][md5(2)] = array("recipientid" => 1);
		}
		// process message data
		$message = new Message();
		$message->processPost($message_dataarray);
		$message->save();
				
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
	
	# find duplicate farmgroups after save
	function getDuplicates(){
		$q = Doctrine_Query::create()->from('UserAccount u')->where("u.firstname = '".$this->getFirstName()."' AND u.lastname = '".$this->getLastName()."' AND u.createdby = '".$this->getCreatedBy()."' AND u.id <> '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	} 
	# invite one user to join. already existing persons
	function inviteOne() {
		$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
    	
		$this->setDateInvited(date('Y-m-d'));
		$this->setIsInvited('1');
		$this->setHasAcceptedInvite('0');
		if(isEmptyString($this->getInvitedByID())){
			$this->setInvitedByID($userid);
		}
		if(isEmptyString($this->getActivationKey())){
    		$this->setActivationKey($this->generateActivationKey());
    	}
		
		#  inviting farm group admin
		if($this->isFarmGroupManager()){
			$this->setType(3);
			$this->setFirstName($this->getFirstName());
			$this->setLastName($this->getLastName());
			$this->setCreatedBy($this->getInvitedByID());
			$this->getFarmGroup()->setEmail($this->getEmail());
			if(!isEmptyString($this->getFarmGroup()->getPhone())){
				$this->setPhone($this->getFarmGroup()->getPhone());
			}
			$this->getUserGroups()->get(0)->setGroupID(2);
			if(!isEmptyString($this->getFarmGroup()->getAddress()->getCountry())){
				$this->setCountry($this->getFarmGroup()->getCountry());
			}
			if(!isEmptyString($this->getFarmGroup()->getDistrictID())){
				$this->setLocationID($this->getFarmGroup()->getDistrictID());
			}
			if(!isEmptyString($this->getFarmGroup()->getCountyID())){
				$this->setCountyID($this->getFarmGroup()->getCountyID());	
			}
			if(!isEmptyString($this->getFarmGroup()->getSubCountyID())){
				$this->setSubCountyID($this->getFarmGroup()->getSubCountyID());	
			}
			if(!isEmptyString($this->getFarmGroup()->getVillageID())){
				$this->setVillageID($this->getFarmGroup()->getVillageID());	
			}
			$this->setCreatedBy($this->getInvitedByID());
		}
		// debugMessage($this->toArray()); exit();
		$this->save();
		
		// send email
		$this->sendProfileInvitationNotification();
		
		return true;
	}
	
	function sendCredentialsByEmail($password) {
		$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
    	
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View(); 

		// assign values
		$template->assign('firstname', $this->getFirstName());
		$template->assign('username', $this->getUserName());
		$template->assign('email', $this->getEmail());
		$template->assign('phone', $this->getFormattedPhone());
		$template->assign('password', $password);
		
		// the actual url will be built in the view
		$viewurl = $template->serverUrl($template->baseUrl('mobile')); 
		$template->assign('loginlink', $viewurl);
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getEmail(), $this->getName());
		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$mail->setSubject("FARMIS Account Activation");
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('loginnotification.phtml'));
		// debugMessage($template->render('loginnotification.phtml')); // exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	# invite user by phone to join
	function inviteOneByPhone() {
		$this->setDateInvited(date('Y-m-d'));
		$this->setIsPhoneInvited('1');
		$this->setIsInvited('0');
		if(isEmptyString($this->getActivationKey())){
			$this->setActivationKey($this->generateActivationKey());
		}
		$this->setHasAcceptedInvite('0');
		$this->save();
		// send email
		$this->sendMobilePhoneInvitation();
	
		return true;
	}
	# invite user by phone to login
	function sendCredentialsByPhone($password) {
		$template = new Zend_View();
		$url = $template->serverUrl($template->baseUrl('mobile'));
		$message =  "Dear ".$this->getFirstName().", \nYour FARMIS account has been activated with details: \nUsername: ".$this->getUsername()." , \nPassword: ".$password." \nGo to ".$url." to login.";
		// debugMessage($message);
		$sendresult = sendSMSMessage($this->getPhone(), $message);
		// debugMessage($sendresult);
		# saving of message to application inbox is not valid here
		return true;
	}
	# send invitition message to user inbox
	function sendMobilePhoneInvitation() {
		$message = $this->getSignupInviteContent();
		// debugMessage($message);
		$sendresult = sendSMSMessage($this->getPhone(), $message);
		// debugMessage($sendresult);
		# saving of message to application inbox is not valid here
		return true;
	}
	# send invitition message to user inbox
	
	# content for requesting activation code via  phone
	function getSignupInviteContent(){
		$template = new Zend_View();
		$signup_url = $template->serverUrl($template->baseUrl('signup/activate'));
		return "Dear ".$this->getFirstName().", \nYour FARMIS activation code is: ".$this->getActivationKey()." \nGo to ".$signup_url." and enter this code to complete.";
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
		if(!isEmptyString($this->getGender())){
			$total += 10;
		} 
		$count += 10;
		
		if(!isEmptyString($this->getDateOfBirth())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getLocationID())){
			$total += 10;
		} 
		$count += 10;
		//debugMessage($count);
		//debugMessage($total);
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
	# determine level of completion for primary profile
	function getStep1_3_Status(){
		$total = 0;
		$count = 0;
		if(!isEmptyString($this->getEmail())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getPhone())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->isPhoneValidated())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getCountry())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getLocationID())){
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
		$q = Doctrine_Query::create()->from('UserAccount u')->where("u.farmgroupid <> '' ")->limit('10');
		$result = $q->execute();
		return $result;
	}
	# determine if farm has atleast one season 
	function hasSeason() {
		$seasons = $this->getSeasons();
		$scount = $seasons->count();
		if($scount == 0) {
			return false;
		} else {
			return true;
		}
	}
	function generateNewFarm() {
		$session = SessionWrapper::getInstance();
		if(isEmptyString($this->getBusinessName())){
			$this->setBusinessName($this->getFirstName()." ".$this->getLastName()."'s Farm");
			$this->save();
		}
		return true;
	}
	/**
     * Determine the type of person
     * @return bool
     */
    function getLandUnitsLabel(){
    	$label = '';
    	$allmeasures = getAreaUnits();
    	if(!isEmptyString($this->getLandUnits())){
    		$label = $allmeasures[$this->getLandUnits()];
    	}
    	return $label;
    }
    # determine text string for available land size
    function displayActiveLandSize(){
    	if(isEmptyString($this->getLandActiveSize()) || $this->getLandActiveSize() == 0 || $this->getLandActiveSize() == 0.00) {
    		return '--';
    	} else {
    		$ret = '--';
    		if(!isEmptyString($this->getLandUnitsLabel())){
    			$ret = clean_num($this->getLandActiveSize()).'&nbsp; <span class="pagedescription">('.$this->getLandUnitsLabel().')</span>';
    		}
    		return $ret;
    	}
    }
	# determine text string for active land size
    function displayLandSize(){
    	if(isEmptyString($this->getLandSize()) || $this->getLandSize() == 0 || $this->getLandSize() == 0.00) {
    		return '--';
    	} else {
    		$ret = '--';
    		if(!isEmptyString($this->getLandUnitsLabel())){
    			$ret = clean_num($this->getLandSize()).'&nbsp; <span class="pagedescription">('.$this->getLandUnitsLabel().')</span>';
    		}
    		return $ret;
    	}
    }
	/**
     * Determine the type of person
     * @return bool
     */
    function getLandAcquireMethodLabel(){
    	$label = '--';
    	$allmethods = getLandAcquireMethods();
    	if(!isEmptyString($this->getLandAcquireMethod()) || $this->getLandAcquireMethod() != 0){
    		$label = $allmethods[$this->getLandAcquireMethod()];
    	}
    	return $label;
    }
	# format the farming types from the comma list
	function getFarmingToolsLabel(){
		$label = '--';
		if(!isEmptyString($this->getFarmingTools())){
			$lookup_array = getFarmingTools();
			$list_array = explode(',', $this->getFarmingTools());
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
	function getFarmingToolsIDs(){
		$dataarray = array();
		if(!isEmptyString($this->getFarmingTools())){
			$list_array = explode(',', $this->getFarmingTools());
			if(is_array($list_array)){
				$dataarray = $list_array;
			}
		}
		return $dataarray;
	}
	# function determine if history of estimates is available
	function getHistoryStatusText(){
		return $this->getHasHistory() == '1' ? 'Yes' : 'No' ;
	}
	function hasPreviousSeason(){
		return $this->getHasHistory() == '1' ? true : false ;
	}
	# the start date
	function getFullStartDate() {
		$date = "--";
		if(!isEmptyString($this->getBizStartYear()) && $this->getBizStartYear() != 0){
			$date = $this->getBizStartYear();
		}
		if(!isEmptyString($this->getBizStartMonth()) && !isEmptyString($this->getBizStartYear())){
			$months = getAllMonthsAsShortNames();
			$date = $months[$this->getBizStartMonth()].", ".$this->getBizStartYear();
		}
		return $date;
	}
	# count number of seasons
	function getCountSeasons(){
		$seasons = $this->getSeasons();
		$scount = $seasons->count();
		return $scount;
	}
	# the total revenue to date on farm
	function getTotalSalesToDate(){
		$seasons = $this->getSeasons();
		$total = 0;
		if($seasons->count()>0){
			foreach ($seasons as $aseason){
				$total += $aseason->getTotalRevenue();
			}
		}
		return $total = 0;
	}
	# the total expenses to date on farm
	function getTotalExpensesToDate(){
		$seasons = $this->getSeasons();
		$total = 0;
		if($seasons->count()>0){
			foreach ($seasons as $aseason){
				$total += $aseason->getTotalExpenses();
			}
		}
		return $total = 0;
	}
	# fetch order farm seasons 
	function getOrderedSeasons() {
		$q = Doctrine_Query::create()->from('Season s')->where("s.userid = '".$this->getID()."' ")->orderby('s.datecreated desc');
		$result = $q->execute();
		return $result;
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
	# determine the inventory history for inventory item
    function getInventoryDetails(){
    	$q = Doctrine_Query::create()->from('Inventory i')->where("i.userid = '".$this->getID()."'")->orderby('i.datecreated DESC');
		$result = $q->execute();
		return $result;
    }
	# determine the credit history for inventory item
    function getCreditDetails(){
    	$q = Doctrine_Query::create()->from('Loan l')->where("l.userid = '".$this->getID()."' AND l.principal > 0 ")->orderby('l.creditdate DESC');
		$result = $q->execute();
		return $result;
    }
	# determine level of completion for primary profile
	function getStep2_1_Status(){
		$total = 0;
		$count = 0;
		if(!isEmptyString($this->getBusinessName())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getDescription())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getNumberofEmployees())){
			$total += 10;
		} 
		$count += 10;
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
	// determine status of land usage profiling
	function getStep2_2_Status(){
		$total = 0;
		$count = 0;
		if(!isEmptyString($this->getlandsize())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getlandactivesize())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getlandunits())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getlandacquiremethod())){
			$total += 10;
		} 
		$count += 10;
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
	# Return farmer crop entry  combination
	function getCropsForUser($userid, $crop) {
		$conn = Doctrine_Manager::connection();
		$existing_query = "SELECT * from farmcrop as f where f.userid = '".$userid."' AND f.cropid = '".$crop."' ";
		// debugMessage($existing_query);
		$result = $conn->fetchRow($existing_query);
		return $result;
	}
}
?>
