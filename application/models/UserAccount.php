<?php

class UserAccount extends BaseEntity {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('useraccount');
		$this->hasColumn('type', 'integer', null, array( 'notnull' => true, 'notblank' => true, 'default' => '1'));
		$this->hasColumn('farmerid', 'integer', null);
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
		$this->hasColumn('addressid', 'integer', null);
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
		
		# override the not null and not blank properties for the createdby column in the BaseEntity
		$this->hasColumn('createdby', 'integer', 11);
	}
	
	# Contructor method for custom initialization
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("expirydate", "activationdate"));
		
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
		$this->hasOne('Farmer as farmer', 
								array(
									'local' => 'farmerid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('District as location',
						 array(
								'local' => 'locationid',
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
								'foreign' => 'userid'
							)
					);
		$this->hasMany('UserPhone as phones',
						 array(
								'local' => 'id',
								'foreign' => 'userid'
							)
					);
		$this->hasOne('MembershipPlan as plan', 
								array(
									'local' => 'membershipplanid',
									'foreign' => 'id'
								)
						);
		$this->hasMany('FarmCrop as farmcrops',
						 array(
								'local' => 'id',
								'foreign' => 'userid'
							)
					);
	}
	/**
	 * Custom model validation
	 */
	function validate() {
		# execute the column validation 
		parent::validate();
		// debugMessage($this->toArray(true));
		if($this->usernameExists()){
			$this->getErrorStack()->add("username.unique", sprintf($this->translate->_("useraccount_username_unique_error"), $this->getUsername()));
		}
		if($this->emailExists()){
			$this->getErrorStack()->add("email.unique", sprintf($this->translate->_("useraccount_email_unique_error"), $this->getEmail()));
		}
		$phone1 = $this->getPhones()->get(0)->getPhone();
		$phone2 = $this->getPhones()->get(1)->getPhone();
		if($this->phoneExists($phone1)){
			$this->getErrorStack()->add("phone.unique", sprintf($this->translate->_("useraccount_phone_unique_error"), getShortPhone($phone1)));
		}
		if(!isEmptyString($phone2) && $this->phoneExists($phone2)){
			$this->getErrorStack()->add("phone.unique", sprintf($this->translate->_("useraccount_phone_unique_error"), getShortPhone($phone2)));
		}
		if(!isEmptyString($phone2) && $phone2 == $phone1){
			$this->getErrorStack()->add("phone.unique", 'Phone Numbers cannot be the same');
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
		// debugMessage($ref_query);
		$result = $conn->fetchOne($query);
		// debugMessage($ref_result);
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
	# determine if the refno has already been assigned to another organisation
	function phoneExists($phone =''){
		$conn = Doctrine_Manager::connection();
		$id_check = "";
		if(!isEmptyString($this->getID())){
			$id_check = " AND up.userid <> '".$this->getID()."' ";
		}
		
		if(isEmptyString($phone)){
			$phone = $this->getPhones()->get(0)->getPhone();
		}
		# unique phone
		$phone_query = "SELECT ua.*, up.* from useraccount as ua inner join userphone as up where ua.id = up.userid AND up.phone = '".$phone."' ".$id_check."";
		$phone_result = $conn->fetchRow($phone_query);
		// debugMessage($phone_query);
		if(isEmptyString($phone_result['userid'])){
			return false;
		}
		
		return true;
	}
	/**
	 * Preprocess model data
	 */
	function processPost($formvalues){
		# if the passwords are not changed , set value to null
		if(isArrayKeyAnEmptyString('password', $formvalues)){
			unset($formvalues['password']); 
		} else {
			$formvalues['password'] = sha1($formvalues['password']); 
		}
		if(!isArrayKeyAnEmptyString('phone', $formvalues)){
			$formvalues['phone'] = str_pad(ltrim($formvalues['phone'], '0'), 12, COUNTRY_CODE_UG, STR_PAD_LEFT); 
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
		if(isArrayKeyAnEmptyString('farmerid', $formvalues)){
			unset($formvalues['farmerid']); 
		}
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		}
		if(isArrayKeyAnEmptyString('locationid', $formvalues)){
			unset($formvalues['locationid']); 
		}
		if(isArrayKeyAnEmptyString('addressid', $formvalues)){
			unset($formvalues['addressid']); 
		}
		if(isArrayKeyAnEmptyString('emailmeoncomment', $formvalues)){
			$formvalues['emailmeoncomment'] = 1; 
		}
		if(isArrayKeyAnEmptyString('emailmeonmessage', $formvalues)){
			$formvalues['emailmeonmessage'] = 1; 
		}
		# move the data from $formvalues['usergroups_groupid'] into $formvalues['usergroups'] array
		# the key for each group has to be the groupid
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
		
		# process address information
		$address = array(); 
		$theaddress = $this->getAddress();
		$address[0]['id'] = $this->getAddress()->getID();
		$address[0]['type'] = 1;
		if(!isArrayKeyAnEmptyString('createdby', $formvalues)){
			$address[0]['createdby'] = $formvalues['createdby'];
		}
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$address[0]['userid'] = $formvalues['id'];
		}
		if(!isArrayKeyAnEmptyString('farmerid', $formvalues)){
			$address[0]['farmerid'] = $formvalues['farmerid'];
		} else {
			$address[0]['farmerid'] = NULL;
		}
		$address[0]['country'] = !isArrayKeyAnEmptyString('country', $formvalues) ? $formvalues['country'] : NULL;
		if(!isArrayKeyAnEmptyString('districtid', $formvalues)){
			$address[0]['districtid'] = $formvalues['districtid'];
		}
		if(!isArrayKeyAnEmptyString('locationid', $formvalues)){
			$address[0]['districtid'] = $formvalues['locationid'];
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
		
		$phones = array();
		if(isArrayKeyAnEmptyString('id', $formvalues)){
			# saving new useraccount
			# add user phone entry
			if(!isArrayKeyAnEmptyString('phone', $formvalues)){
				$phones[0]['phone'] = $formvalues['phone'];
				$phones[0]['isprimary'] = 1;
			}
			if(!isArrayKeyAnEmptyString('id', $formvalues)){
				$phones[0]['userid'] = $formvalues['id'];
			}
		}
		
		if(count($phones) > 0){
			$formvalues['phones'] = $phones;
		}
		
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	/*
	 * Custom save logic
	 */
	function transactionSave(){
		$conn = Doctrine_Manager::connection();
		
		# begin transaction to save
		try {
			$conn->beginTransaction();
			# initial save
			$this->save();
			
			# update the ids on the profiles
			if(!isEmptyString($this->getFarmerID())){
				$this->setCreatedBy($this->getID());
				$this->getFarmer()->setUserID($this->getID());
				$this->getFarmer()->setCreatedBy($this->getID());
				
				# set activation key
				$this->setActivationKey($this->generateActivationKey());
				
				# generate registration number for farmer
				$this->getFarmer()->setRefNo($this->getFarmer()->getCurrentRefNo());
				$this->getFarmer()->setRegNo($this->getFarmer()->getCurrentRegNo());
				$this->getPhones()->get(0)->setActivationKey($this->getActivationKey());
			}
			
			# save current profile changes
			$this->save();
			
		 	# commit changes
			$conn->commit();
		} catch(Exception $e){
			$conn->rollback();
			// debugMessage('Error is '.$e->getMessage());
			throw new Exception($e->getMessage());
		}
		
		# send signup notification to email
		$this->sendSignupNotification();
		# send signup activation to phone
		if(!isEmptyString($this->getPhone())){
			$this->getPrimaryPhone()->sendSignupCodeToMobile();
		}
		
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
     * @param boolean $verify Verify whether the provided password is the same as the user's current password
	 *
	 * @return TRUE if the password is changed, FAlSE if it fails to change the user's password.
	 */
	function changePassword($providedpassword, $newpassword, $verify = true){
		// check if the provided password is the same as that for the user
      	if ($verify) {
          /*if ($this->getPassword() != sha1($providedpassword)) {
              $this->getErrorStack()->add("oldpassword.invalid", $this->translate->_("useraccount_oldpassword_invalid_error"));
              return false;
          }*/
          }
		// now change the password
		$this->setPassword(sha1($newpassword));
      	$this->setActivationKey('');
      	
      	try {
      	$this->save();
      	# Log to audit trail that a password has been changed.
			$audit_values = array("transactiontype" => USER_CHANGE_PASSWORD, "userid" => $this->getID(), "executedby" => $this->getID(), "success" => 'Y');
			$audit_values['transactiondetails'] = $this->getName()." changed account password";
			$this->notify(new sfEvent($this, USER_CHANGE_PASSWORD, $audit_values));
      	
      	} catch (Exception $e){
      		# Log to audit trail that user has failed to change password
			$audit_values = array("transactiontype" => USER_CHANGE_PASSWORD, "userid" => $this->getID(), "executedby" => $this->getID(), "success" => 'N');
			$audit_values['transactiondetails'] = $this->getName()." failed to change account password". $e->getMessage();
			$this->notify(new sfEvent($this, USER_CHANGE_PASSWORD, $audit_values));
      	}
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
		if(!$this->findByEmail($this->getEmail())){
			$audit_values['transactiondetails'] = "Recovery of password for '".$this->getEmail()."' failed - user not found";
			$this->notify(new sfEvent($this, USER_RECOVER_PASSWORD, $audit_values));
			return false;
		}
			
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
		$this->notify(new sfEvent($this, USER_RECOVER_PASSWORD, $audit_values));
		
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
		$template->assign('resetpasswordurl', array("controller"=> "user","action"=> "resetpassword", "actkey" => $this->getActivationKey(), "id" => encode($this->getID())));
		
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
   function activateAccount($actkey, $acttype = false) {
   		# save to the audit trail
		$isphoneactivation = $acttype;
		# validate the activation key 
		if($this->getActivationKey() != $actkey){
			// debugMessage('failed');
			# Log to audit trail when an invalid activation key is used to activate account
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "N");
			$audit_values["transactiondetails"] = "Invalid Activation Code specified for User(".$this->getID().") (".$this->getEmail()."). "; 
			$this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
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
				$this->getPrimaryPhone()->activate();
				# send confirmation to mobile
				$this->getPrimaryPhone()->sendSignupConfirmationToMobile();
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
			# current plan
			$plan = new MembershipPlan();
			$plan->populate($this->getMembershipPlanID());
			# new subscription
			$subscription = new Subscription();
			$subscription->setUserID($this->getID());
			$subscription->setMembershipPlanID($this->getMembershipPlanID());
			$startdate = date("Y-m-d");	
			$expirydate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($startdate)) . " +".$plan->getTrialDays()." days "));
			$subscription->setStartDate($startdate);
			$subscription->setEndDate($expirydate);
			$subscription->setIsTrial(1);
			$subscription->setIsActive(1);
			$subscription->save();
			// debugMessage($subscription->toArray());
			
			# Add to audittrail that a new user has been activated.
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "Y");
			$audit_values["transactiondetails"] = $this->getID()." (".$this->getEmail().") has completed the sign up process"; 
			$this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
		
			return true;
			
		} catch (Exception $e){
			$this->getErrorStack()->add("user.activation", $this->translate->_("useraccount_activation_error"));
			$this->logger->err("Error activating useraccount ".$this->getEmail()." ".$e->getMessage());
			# log to audit trail when an error occurs in updating payee details on user account
			$audit_values = array("executedby" => $this->getID(), "transactiontype" => USER_SIGNUP, "success" => "N");
			$audit_values["transactiondetails"] = "An error occured in activating account for User(".$this->getID().") (".$this->getEmail()."): ".$e->getMessage(); 
			$this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
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
			$this->notify(new sfEvent($this, USER_SIGNUP, $audit_values));
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
		$template->assign('activationurl', $viewurl);
		
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
	# content of confirmation message upon confirmation
	function getSignupAccountConfirmationContent(){
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$contactus_url = $baseUrl.'/contactus';
		$password_url = $baseUrl.'/farmer/view/id/'.encode($this->getPersonID().'/tab/account');
		return "Dear ".$this->getFirstName().", <br /><br />Your FARMIS Account has been successfully activated. You can now login anytime using either Email, Phone or Username with the password you provided during registration. <br /><br /> You can also change your password anytime by <a href='".$password_url."' title='Change Password'>clicking here</a>.  <br /><br />For any help or assistance, <a href='".$contactus_url."'>Contact us</a> ";
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
	function sendNewEmailNotification($newemail, $contactid) {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance(); 
		
		// assign values
		$template->assign('firstname', $this->getFirstName());
		$template->assign('fromemail', $this->getEmail());
		$template->assign('toemail', $newemail);
		$viewurl = $template->serverUrl($template->baseUrl('user/changeemail/id/'.encode($this->getID())."/actkey/".$this->getActivationKey()."/cid/".$contactid."/ref/".encode($newemail)."/"));
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
		// debugMessage($template->render('changeemail_newnotification.phtml')); // exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	
	# change email notification to old address
	function sendOldEmailNotification($newemail, $contactid) {
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
		return substr(md5(uniqid(mt_rand(), 1)), 0, 10);
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
	# get user's primary phone
	function getPrimaryPhone() {
		$q = Doctrine_Query::create()->from('UserPhone us')->where("us.userid = '".$this->getID()."' AND us.isprimary = 1 ");
		$result = $q->fetchOne();
		if(!$result){
			return $phone = new UserPhone();
		}
		return $result;
	}
	# get user's primary phone
	function getPhone() {
		$q = Doctrine_Query::create()->from('UserPhone us')->where("us.userid = '".$this->getID()."' AND us.isprimary = 1 ");
		$result = $q->fetchOne();
		$phone = '';
		if($result){
			$phone = $result->getFormattedPhone();
		}
		return $phone;
	}
	# get user's secondary phone
	function getSecondaryPhone() {
		$q = Doctrine_Query::create()->from('UserPhone us')->where("us.userid = '".$this->getID()."' AND us.isprimary = 0 ");
		$result = $q->execute();
		if(!$result){
			return $phone = new UserPhone();
		}
		return $result->get(0);
	}
	# get user's primary phone
	function getAltPhone() {
		$pri_phone = getFullPhone($this->getPhone());
		$q = Doctrine_Query::create()->from('UserPhone us')->where("us.userid = '".$this->getID()."' AND us.phone <> '".$pri_phone."' ");
		$result = $q->fetchOne();
		$phone = '';
		if($result){
			$phone = $result->getFormattedPhone();
		}
		return $phone;
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
	# cleanup by creating address entry if does not exit
	function cleanUpAddress() {
		if(!isEmptyString($this->getID()) && isEmptyString($this->getAddress()->getID())){
			$address = $this->getAddress();
			$address->setFarmerID($this->getID());
			$address->setCreatedBy(1);
			if(!isEmptyString($this->getUserID())){
				$address->setUserID($this->getUserID());
				$address->setCreatedBy($this->getUserID());
			}
			
			$address->save();
			if(!isEmptyString($address->getID())){
				$this->setAddressID($address->getID());
				$this->clearRelated(); 
				$this->save();
			}
			# debugMessage($address->toArray());
		}
		return true;
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
	function validateUserUsingPhone($password, $phone){
		$formattedphone = getFullPhone($phone);
		$conn = Doctrine_Manager::connection();
		$query = "SELECT * from useraccount as ua inner join userphone as up where ua.id = up.userid AND up.phone = '".$formattedphone."' AND ua.password = '".sha1($password)."' ";
		// debugMessage($query);
		$result = $conn->fetchRow($query);
		// debugMessage($result);
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
}
?>
