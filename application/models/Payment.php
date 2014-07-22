<?php

/**
 * Model for payments
 */
class Payment extends BaseRecord  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		$this->setTableName('payment');
		
		$this->hasColumn('userid', 'integer', null);
		$this->hasColumn('farmgroupid', 'integer', null);
		$this->hasColumn('subscriptionid', 'integer', null);
		$this->hasColumn('stem', 'integer', null, array('default' => 1));
		$this->hasColumn('item', 'string', 255, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('description', 'string', 255);
		$this->hasColumn('trxcode', 'string', 15);
		$this->hasColumn('trxdate', 'date', array('notnull' => true, 'notblank' => true));
		$this->hasColumn('phone', 'string', 15);	
		$this->hasColumn('amount', 'decimal', 10, array('notnull' => true, 'notblank' => true, 'default' => 0));
		$this->hasColumn('status',  'integer', null, array('default' => 3)); // 3 - Completed, 2 - Cancelled, 1 - Pending
		$this->hasColumn('paymenttype',  'integer', null, array('default' => 2)); // 1 - Mobile Money, 2 - Cash, 3 - Payment System
		$this->hasColumn('verifier', 'string', 255);
		$this->hasColumn('verifiedbyid', 'integer', null);
		$this->hasColumn('datecreated', 'date');
	}
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array('trxdate'));
		// set the custom error messages
		$this->addCustomErrorMessages(array(
										"item.notblank" => $this->translate->_("payment_item_error"),
										"trxdate.notblank" => $this->translate->_("payment_trxdate_error"),
										"amount.notblank" => $this->translate->_("payment_amount_error"),
       	       						));     
	}
	/*
	 * Relationships for the model
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
		$this->hasOne('Subscription as subscription', 
								array(
									'local' => 'subscriptionid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('UserAccount as verifiedby', 
								array(
									'local' => 'verifiedbyid',
									'foreign' => 'id'
								)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']); 
		}
		if(isArrayKeyAnEmptyString('farmgroupid', $formvalues)){
			unset($formvalues['farmgroupid']); 
		}
		if(isArrayKeyAnEmptyString('subscriptionid', $formvalues)){
			unset($formvalues['subscriptionid']); 
		}
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']); 
		}
		if(isArrayKeyAnEmptyString('paymenttype', $formvalues)){
			unset($formvalues['paymenttype']); 
		}
		if(isArrayKeyAnEmptyString('verifiedbyid', $formvalues)){
			unset($formvalues['verifiedbyid']); 
		}
		if(isArrayKeyAnEmptyString('trxdate', $formvalues)){
			$formvalues['trxdate'] = date('Y-m-d'); 
		}
		if(isArrayKeyAnEmptyString('datecreated', $formvalues)){
			$formvalues['datecreated'] = date('Y-m-d H:i:s'); 
		}
		if(!isArrayKeyAnEmptyString('phone', $formvalues)){
			// $formvalues['phone'] = getFullPhone($formvalues['phone']);
			if(strtoupper($formvalues['country']) == 'KE'){
				$formvalues['phone'] = str_pad(ltrim($formvalues['phone'], '0'), 12, COUNTRY_CODE_KE, STR_PAD_LEFT);
			} else {
				$formvalues['phone'] = str_pad(ltrim($formvalues['phone'], '0'), 12, COUNTRY_CODE_UG, STR_PAD_LEFT);
			}
		}
		
		$subscription = array();
		if(!isArrayKeyAnEmptyString('hassubscription', $formvalues)){
			$formvalues['subscription']['userid'] = $formvalues['userid'];
			$formvalues['subscription']['startdate'] = changeDateFromPageToMySQLFormat($formvalues['startdate']);
			$formvalues['subscription']['enddate'] = changeDateFromPageToMySQLFormat($formvalues['enddate']);
			$formvalues['subscription']['isactive'] = 1;
			$formvalues['subscription']['istrial'] = 0;
			$formvalues['subscription']['planid'] = 2;
			$formvalues['subscription']['verifiedbyid'] = $formvalues['verifiedbyid'];
			if(!isArrayKeyAnEmptyString('subscriptionid', $formvalues)){
				$formvalues['subscription']['id'] = $formvalues['subscriptionid'];
			}
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
	/**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
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
	# find duplicates after save
	function getDuplicates(){
		$isfarmer = false;
		$isfarmgrp = false;
		if(!isEmptyString($this->getFarmGroupID())){
			$isfarmgrp = true;
		} else {
			$isfarmer = true;
		}
		if($isfarmgrp){
			$q = Doctrine_Query::create()->from('Payment p')->where("p.farmgroupid = '".$this->getFarmGroupID()."' AND p.trxdate = '".$this->getTrxDate()."' AND p.amount = '".$this->getAmount()."' AND p.id <> '".$this->getID()."' ");
		}
		if($isfarmer){
			$q = Doctrine_Query::create()->from('Payment p')->where("p.userid = '".$this->getUserID()."' AND p.trxdate = '".$this->getTrxDate()."' AND p.amount = '".$this->getAmount()."' AND p.id <> '".$this->getID()."' ");
		}
		
		$result = $q->execute();
		return $result;
	}
	# the status of a payment
	function getPaymentStatus(){
		$value = '--';
		$values = getPaymentStatuses();
		if(!isEmptyString($this->getStatus()) && $this->getStatus() != 0){
			$value = $values[$this->getStatus()];
		}
		return $value;;
	}
	# the method used for the payment
	function getMethod(){
		$value = '--';
		$values = getPaymentMethods();
		if(!isEmptyString($this->getPaymentType()) && $this->getPaymentType() != 0){
			$value = $values[$this->getPaymentType()];
		}
		return $value;;
	}
	# determine the payment subject
	function getSubject(){
		$subject = '--';
		if(!isEmptyString($this->getItem())){
			switch ($this->getItem()) {
				case 1:
					$subject = "Basic Farmer Subscription";
					break;
				case 2:
					$subject = "Premium Farmer Subscription";
					break;
				case 3:
					$subject = "DNA Basic";
					break;
				case 4:
					$subject = "DNA Premium";
					break;
				
				default:
					break;
			}
		}
		return $subject;
	}
	# determine the default subcription amount
	function getDefaultDNAAmount(){
		$plan = new MembershipPlan();
		$plan->populate(4);
		return $plan->getAmount();
	}
	# determine the default subcription amount
	function getDefaultFarmerAmount(){
		$plan = new MembershipPlan();
		$plan->populate(2);
		return $plan->getAmount();
	}
	# determine the default subcription amount
	function getDefaultFarmerAmountKe(){
		$plan = new MembershipPlan();
		$plan->populate(2);
		return $plan->getAmountKe();
	}
	function sendSubscriptionConfirmationByEmail() {
		$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
    	
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View(); 

		// assign values
		$template->assign('firstname', $this->getUser()->getFirstName());
		$template->assign('email', $this->getUser()->getEmail());
		$template->assign('phone', $this->getUser()->getPhone());
		$template->assign('paymentdate', changeMySQLDateToPageFormat($this->gettrxdate()));
		$template->assign('startdate', changeMySQLDateToPageFormat($this->getSubscription()->getStartDate()));
		$template->assign('enddate', changeMySQLDateToPageFormat($this->getSubscription()->getEndDate()));
		$template->assign('paymentref', $this->getTrxCode());
		$template->assign('status', $this->getPaymentStatus());
		$template->assign('amount', formatMoney($this->getAmount()));
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// configure base stuff
		$mail->addTo($this->getUser()->getEmail(), $this->getUser()->getName());
		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('useraccount_email_notificationsender'));
		
		$mail->setSubject("FARMIS Payment Confirmation");
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('paymentnotification.phtml'));
		// debugMessage($template->render('paymentnotification.phtml')); // exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	# invite user by phone to login
	function sendSubscriptionConfirmationByPhone() {
		$message =  "Dear ".$this->getUser()->getFirstName().", \nYour Payment of ".formatMoney($this->getAmount())." for FARMIS membership has been successfully received.";
		// debugMessage($message);
		$sendresult = sendSMSMessage($this->getUser()->getPhone(), $message);
		// debugMessage($sendresult);
		# saving of message to application inbox is not valid here
		return true;
	}
}

?>