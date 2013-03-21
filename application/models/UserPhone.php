<?php

class UserPhone extends BaseRecord {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('userphone');
		$this->hasColumn('userid', 'integer', null, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('phone', 'string', 15/*, array('notnull' => true, 'notblank' => true)*/);	
		$this->hasColumn('isprimary', 'integer', null, array('default' => '0'));
		$this->hasColumn('isactivated', 'integer', null, array('default' => '0'));
		$this->hasColumn('activationkey', 'string', 15);
		$this->hasColumn('activationdate', 'date');
	}
	
	# Contructor method for custom initialization
	public function construct() {
		parent::construct();
		
		# set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"userid.notblank" => "Please select a user",
       									// "phone.notblank" => $this->translate->_("useraccount_phonenumber_error")
       	       						));
	}
	
	# Model relationships
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('UserAccount as user', 
								array(
									'local' => 'userid',
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
		
		$conn = Doctrine_Manager::connection();
	
	}
	/**
	 * Preprocess model data
	 */
	function processPost($formvalues){
		# if the passwords are not changed , set value to null
		if(isArrayKeyAnEmptyString('isprimary', $formvalues)){
			unset($formvalues['isprimary']); 
		}
		if(isArrayKeyAnEmptyString('isactivated', $formvalues)){
			unset($formvalues['isactivated']); 
		}
		parent::processPost($formvalues);
	}
	# return the formatted phone number of the form 07X
	function getFormattedPhone(){
		$phone = str_pad(ltrim($this->getPhone(), '256'), 10, '0', STR_PAD_LEFT);
		return $phone; 
	}
	function getStatusLabel(){
		$label = '&nbsp; <span class="pagedescription" style="color:#ca464c;">(Unconfirmed)</span';
		$validated = false;
		if($this->isValidated()){
            $validated = true;                            
            $label = '&nbsp; <span class="pagedescription" style="color:#55A411;">(Confirmed)</span';
        }
        return $label;
	} 
	# determine if phone is validated
	function isValidated(){
		return $this->getIsActivated() == 1 ? true : false;
	}
	# determine if phone is validated
	function hasPendingActivation(){
		return !isEmptyString($this->getActivationKey()) && $this->isValidKey() && !$this->isValidated() ? true : false;
	}
	function isValidKey(){
		return strlen($this->getActivationKey()) == 6 ? true : false; 
	}
	# Generate a 6 digit activation key  
    function generateActivationKey() {
		return substr(md5(uniqid(mt_rand(), 1)), 0, 6);
    }
	# generate activation code
	function generateActivationCode(){
		$this->setActivationKey($this->generateActivationKey());
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
		return "Dear ".$this->getUser()->getFirstName().", \nThank you for your interest in the FARMREC Program. Your mobile phone activation code is: ".$this->getActivationKey();
	}
	# send activation code to the user's mobile phone
	function sendSignupCodeToMobile() {
		$message = $this->getSignupCodeContent();
		// debugMessage($message);
		$sendresult = sendSMSMessage($this->getPhone(), $message);
		// debugMessage($sendresult);
		# saving of message to application inbox is not valid here
		return true;
	}
	# content for requesting activation code via  phone
	function getSignupCodeContent(){
		return "Dear ".$this->getUser()->getFirstName().", \nThank you for your interest in the FARMREC Program. Your registration activation code is: ".$this->getUser()->getActivationKey();
	}
	# verify that a code specified is valid for activation
	function verifyPhone($code){
		return $this->getActivationKey() == $code ? true : false;
	}
	
	# activate account by clearing the activation code, setting flag to true and setting activation date
	function activate(){
		$this->setActivationKey('');
		$this->setIsActivated(1);
		$this->setActivationDate(date("Y-m-d H:i:s"));
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
								md5(1) => array("recipientid" => $this->getUserID())
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
		return "Dear ".$this->getUser()->getFirstName().", \nYour mobile phone ".$this->getFormattedPhone()." has been successfully validated. Thank you for being apart of the FARMREC Program.";
	}
	# content of confirmation message upon confirmation
	function getSignupAccountConfirmationContent(){
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$contactus_url = $baseUrl.'/contactus';
		$password_url = $baseUrl.'/farmer/view/id/'.encode($this->getUser()->getFarmerID()).'/tab/account';
		return "Dear ".$this->getUser()->getFirstName().", <br /><br />Your mobile phone ".$this->getFormattedPhone()." has been successfully validated. You can now login anytime using either Email, Phone or Username with the password you provided during registration. <br /><br /> You can also change your password anytime by <a href='".$password_url."' title='Change Password'>clicking here</a>.  <br /><br />For any help or assistance, <a href='".$contactus_url."'>Contact us</a> ";
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
								md5(1) => array("recipientid" => $this->getUserID())
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
		return "Dear ".$this->getUser()->getFirstName().", \nYour FARMREC Account and Phone have been successfully activated. You can now login anytime using either Email, Phone or Username";
	}
	function getSignupInboxConfirmationContent(){
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$contactus_url = $baseUrl.'/contactus';
		$password_url = $baseUrl.'/farmer/view/id/'.encode($this->getUser()->getFarmerID()).'/tab/account';
		return "Dear ".$this->getUser()->getFirstName().", <br /><br />Your FARMREC Account and Phone have been successfully activated. You can now login anytime using either Email, Phone or Username with the password you provided during registration. <br /><br /> You can also change your password anytime by <a href='".$password_url."' title='Change Password'>clicking here</a>.  <br /><br />For any help or assistance, <a href='".$contactus_url."'>Contact us</a> ";
	}
	# set activation code to change user's email
	function triggerPhoneChange($newphone) {
		$this->setActivationKey($this->generateActivationKey());
		$this->setTempPhone($newphone);
		$this->save();
		$this->sendNewPhoneActivation();
		return true;
	}
	
	# send new phone activation code to mobile
	function sendNewPhoneActivation() {
		$message = $this->translate->_('appname')." New Phone Activation Code: ".$this->getActivationKey();
		// debugMessage($message);
		// $sendresult = sendSMSMessage($this->getPhone(), $message);
		// debugMessage($sendresult);
		// exit();
		return true;
	}
	# determine the network provider for phone number
	function getProvider(){
		return getPhoneProvider($this->getFormattedPhone());
	}
}
?>
