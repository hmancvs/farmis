<?php

class ProfileController extends SecureController  {
	
	/**
	 * @see SecureController::getResourceForACL()
	 *
	 * @return String
	 */
	function getResourceForACL() {
		return "User Account";
	}
	
	/**
	 * Override unknown actions to enable ACL checking 
	 * 
	 * @see SecureController::getActionforACL()
	 *
	 * @return String
	 */
	function getActionforACL() {
		return ACTION_EDIT;
	}	
	
    function changepasswordAction()  {
    	
    }
    
    function processchangepasswordAction(){
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate"); 
    	if(!isEmptyString($this->_getParam('password'))){
	        $user = new UserAccount(); 
	    	$user->populate(decode($this->_getParam('id')));
	    	// debugMessage($user->toArray());
	    	# Change password
	    	$user->changePassword($this->_getParam('oldpassword'), $this->_getParam('password'));
	    		// clear the session
	   			// send a link to enable the user to recover their password 
	   		$this->_redirect($this->view->baseUrl('profile/updatesuccess'));
		}
    }
    function changeusernameAction()  {
    	
    }
	function processchangeusernameAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate");
        $formvalues = $this->_getAllParams();
        
    	if(!isArrayKeyAnEmptyString('username', $formvalues)){
	        $user = new UserAccount(); 
	    	$user->populate(decode($formvalues['id']));
	    	// debugMessage($user->toArray());
	    	
	    	if($user->usernameExists($formvalues['username'])){
	    		$session->setVar(ERROR_MESSAGE, sprintf($this->_translate->translate("useraccount_username_unique_error"), $formvalues['username']));
	    		return false;
	    	}
	    	# save new username
	    	$user->setUsername($formvalues['username']);
	    	$user->save();
	   		$this->_redirect($this->view->baseUrl('index/updatesuccess'));
		}
    }
    
	function changeemailAction()  {
		$session = SessionWrapper::getInstance(); 
		
		$formvalues = $this->_getAllParams();
		if(!isArrayKeyAnEmptyString('actkey', $formvalues) && !isArrayKeyAnEmptyString('ref', $formvalues)){
        	$newemail = decode($formvalues['ref']);
		
			$user = new UserAccount();
			$user->populate(decode($formvalues['id']));
			$oldemail = $user->getEmail();
			
			# validate the activation code
			if($formvalues['actkey'] != $user->getActivationKey()){
				$session->setVar(ERROR_MESSAGE, "Invalid code specified for email activation");
				$failureurl = $this->view->baseUrl('farmer/view/id/'.encode($user->getFarmerID()).'/tab/account');
				$this->_helper->redirector->gotoUrl($failureurl);
			}
			
			$user->setActivationKey('');
			$user->setEmail($newemail);
			$user->setEmail2($oldemail);
			$user->save();
			// debugMessage($user->toArray());
			
	    	$successmessage = "Successfully updated. Please note that you can no longer login using your previous Email Address";
	    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
	   		$this->_helper->redirector->gotoUrl($this->view->baseUrl('farmer/view/id/'.encode($user->getFarmerID()).'/tab/account'));
        }
    }
	function processchangeemailAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate");
        $formvalues = $this->_getAllParams();
         
        if(!isArrayKeyAnEmptyString('email', $formvalues)){
	        $user = new UserAccount(); 
	    	$user->populate(decode($formvalues['id']));
	    	// debugMessage($user->toArray());
	    	
	    	if($user->emailExists($formvalues['email'])){
	    		$session->setVar(ERROR_MESSAGE, sprintf($this->_translate->translate("useraccount_email_unique_error"), $formvalues['email']));
	    		return false;
	    	}
	    	# save new username
	    	$user->setEmail2($formvalues['email']);
	    	$user->setActivationKey($user->generateActivationKey());
	    	$user->save();
	    	
	    	//$user->sendNewEmailNotification($formvalues['email']);
    		//$user->sendOldEmailNotification($formvalues['email']);
	    	$successmessage = "A request to change your login email has been recieved. <br />To complete this process check your Inbox for a confirmation code and enter it below. Alternatively, click the activation link sent in the same email.";
	   		$this->_redirect($this->view->baseUrl('index/updatesuccess/successmessage/'.encode($successmessage)));
		}
    }
    
	function changephoneAction()  {
		$session = SessionWrapper::getInstance(); 
		
		$formvalues = $this->_getAllParams();
		if(!isArrayKeyAnEmptyString('actkey', $formvalues) && !isArrayKeyAnEmptyString('ref', $formvalues)){
        	$newphone = decode($formvalues['ref']);
		
			$user = new UserAccount();
			$user->populate(decode($formvalues['id']));
			$oldphone = $user->getPhone();
			$secondaryphone = $user->getSecondaryPhone();
			$primaryphone = $user->getPrimaryPhone();
			
			# validate the activation code
			if($formvalues['actkey'] != $secondaryphone->getActivationKey()){
				$session->setVar(ERROR_MESSAGE, "Invalid code specified for phone activation");
				$failureurl = $this->view->baseUrl('farmer/view/id/'.encode($user->getFarmerID()).'/tab/account');
				$this->_helper->redirector->gotoUrl($failureurl);
			}
			
			$secondaryphone->setIsPrimary(1);
			$secondaryphone->activate();
			$primaryphone->setIsPrimary(0);
			$primaryphone->save();
			
	    	$successmessage = "Successfully updated. Please note that you can no longer login using your previous primary phone";
	    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
	   		$this->_helper->redirector->gotoUrl($this->view->baseUrl('farmer/view/id/'.encode($user->getFarmerID()).'/tab/account'));
        }
    }
	function processchangephoneAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate");
        $formvalues = $this->_getAllParams();
         
        if(!isArrayKeyAnEmptyString('phone', $formvalues)){
	        $user = new UserAccount(); 
	    	$user->populate(decode($formvalues['id']));
	    	$secondaryphone = $user->getSecondaryPhone();
			$primaryphone = $user->getPrimaryPhone();
	    	/*debugMessage($primaryphone->toArray());
	    	debugMessage($secondaryphone->toArray());*/
			// debugMessage($formvalues);
	    	
	    	if($formvalues['phone'] == getShortPhone($secondaryphone->getPhone()) && $secondaryphone->isValidated()){
		    	try {
		    		$secondaryphone->setIsPrimary(1);
					$secondaryphone->activate();
					$primaryphone->setIsPrimary(0);
					$primaryphone->save();
		    	} catch (Exception $e) {
		    		debugMessage($e->getMessage());
		    	}
	    		
				$successmessage = "Successfully updated. Please note that you can no longer login using your previous primary phone";
		    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
		   		// $this->_helper->redirector->gotoUrl($this->view->baseUrl('farmer/view/id/'.encode($user->getFarmerID()).'/tab/account'));
	    	} else {
	    		if($user->phoneExists($formvalues['phone'])){
		    		$session->setVar(ERROR_MESSAGE, sprintf($this->_translate->translate("useraccount_phone_unique_error"), $formvalues['phone']));
		    		return false;
		    	}
		    	# save new username
		    	$dataarray = array('id' => $secondaryphone->getID(),
		    						'userid'=>$user->getID(), 
		    						'phone'=>getFullPhone($formvalues['phone']),
		    						'activationkey' => $secondaryphone->generateActivationKey(),
		    						'isprimary' => 0,
		    						'isactivated' => 0
		    					);
		    	if(isArrayKeyAnEmptyString('id', $dataarray)){
		    		unset($dataarray['id']);
		    	} else {
		    		$secondaryphone->populate($dataarray['id']);
		    	}
		    	// debugMessage($dataarray);
		    	$secondaryphone->processPost($dataarray);
		    	/*debugMessage($secondaryphone->toArray());
		    	debugMessage('error== '.$secondaryphone->getErrorStackAsString());*/
		    	$secondaryphone->save();
		    	
		    	// $user->sendNewEmailNotification($formvalues['email']);
	    		// $user->sendOldEmailNotification($formvalues['email']);
		    	$successmessage = "A request to change your primary phone has been recieved. <br />To complete this process check your phone inbox for a confirmation code and enter it below.";
		   		$this->_redirect($this->view->baseUrl('index/updatesuccess/successmessage/'.encode($successmessage)));
	    	}
		}
    }
    
	function resendemailcodeAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $formvalues = $this->_getAllParams();
         
        $user = new UserAccount(); 
    	$user->populate(decode($formvalues['id']));
    	// debugMessage($user->toArray());
    	
    	$session->setVar('contactuslink', "<a href='".$this->view->baseUrl('contactus')."' title='Contact Farmis Support'>Contact us</a>");
    	$user->sendNewEmailNotification($user->getEmail2());
    	$successmessage = "A new activation code has been sent to your new email address. If you are still having any problems please do contact us";
    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
   		$this->_redirect($this->view->baseUrl('farmer/view/id/'.encode($user->getFarmerID()).'/tab/account'));
    }
    
    function resetpasswordAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
	   			$session = SessionWrapper::getInstance(); 
       	$this->_translate = Zend_Registry::get("translate"); 
       		
		$user = new UserAccount(); 
		$user->populate(decode($this->_getParam('id')));
    	$user->setEmail($user->getEmail());
    	
    	if ($user->recoverPassword()) {
       		$session->setVar(SUCCESS_MESSAGE, sprintf($this->_translate->translate('useraccount_change_password_admin_confirmation'), $user->getName()));
   			// send a link to enable the user to recover their password 
   			$this->_helper->redirector->gotoUrl($this->view->baseUrl("profile/view/id/".encode($user->getID())));
    	} else {
   			$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString());
   			$session->setVar(FORM_VALUES, $this->_getAllParams());
	   		$this->_helper->redirector("view", "profile");
	   		$this->_helper->redirector->gotoUrl($this->view->baseUrl("profile/view/id/".encode($user->getID())));
    	}
   	}
   	
	public function dashupdateAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$session = SessionWrapper::getInstance(); 
		// debugMessage($formvalues);
		
		$user = new UserAccount();
		$user->populate($formvalues['id']);
		switch ($formvalues['area']) {
			case 'welcome':
				$user->setDashWelcome(0);
				break;
			case 'wizard':
				$user->setDashWizard(0);
				break;
			default:
				break;
		}
		
		$user->save();
		
		// debugMessage($user->toArray());
		$this->_helper->redirector->gotoUrl($this->view->baseUrl("dashboard"));
		// exit();
	}
}

