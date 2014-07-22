<?php

class UserController extends IndexController  {

    function checkloginAction() {
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
    	# check that an email has been provided
		if (isEmptyString($this->_getParam("email"))) {
			$session->setVar(ERROR_MESSAGE, $this->_translate->translate("useraccount_email_error")); 
			$session->setVar(FORM_VALUES, $this->_getAllParams());
			// return to the home page
			if(!isEmptyString($this->_getParam(URL_FAILURE))){
				$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
			}
    		$this->_helper->redirector->gotoSimpleAndExit('login', "user");
		}
		if (isEmptyString($this->_getParam("password"))) {
			$session->setVar(ERROR_MESSAGE, $this->_translate->translate("useraccount_password_error")); 
			$session->setVar(FORM_VALUES, $this->_getAllParams());
			// return to the home page
			if(!isEmptyString($this->_getParam(URL_FAILURE))){
				$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
			}
    		$this->_helper->redirector->gotoSimpleAndExit('login', "user");
		}
			
		# check which field user is using to login. default is username
		$credcolumn = "username";
    	$login = (string)$this->_getParam("email");
    	debugMessage($this->_getAllParams());
    	
    	# check if credcolumn is phone 
    	if(is_numeric(substr($login, -6, 6)) || is_numeric($login)){
    		$credcolumn = 'phone';
    	}
    	$country = $this->_getParam('country'); // $country = 'ug';
    	# check if credcolumn is emai
    	$validator = new Zend_Validate_EmailAddress();
		if ($validator->isValid($login)) {
        	$usertable = new UserAccount();
     		if($usertable->findByEmail($login)){
           		$credcolumn = 'email';
            }
        }
        debugMessage($credcolumn); // exit();
        
        if($credcolumn == 'email' || $credcolumn == 'username'){
	        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Registry::get("dbAdapter"));
			// define the table, fields and additional rules to use for authentication 
			$authAdapter->setTableName('useraccount');
			$authAdapter->setIdentityColumn($credcolumn);
			$authAdapter->setCredentialColumn('password');
			// AND country = '".$country."'
			/*AND UPPER(country) = '".strtoupper($country)."'*/
			$authAdapter->setCredentialTreatment("sha1(?) AND isactive = '1' "); 
			// set the credentials from the login form
			$authAdapter->setIdentity($login);
			$authAdapter->setCredential($this->_getParam("password")); 
	
			// new class to audit the type of Browser and OS that the visitor is using
			$browser = new Browser();
			$audit_values = array("browserdetails" => $browser->getBrowserDetailsForAudit());
			
			if(!$authAdapter->authenticate()->isValid()) {
				// add failed login to audit trail
	    		$audit_values['transactiontype'] = USER_LOGIN;
	    		$audit_values['success'] = "N";
	    		$audit_values['transactiondetails'] = "Login for user with Identity '".$this->_getParam("email")."' failed. Invalid Identity or Password";
				$this->notify(new sfEvent($this, USER_LOGIN, $audit_values));
				
				$session->setVar(ERROR_MESSAGE, "Invalid Identity or Password. <br />Please Try Again."); 
				$session->setVar(FORM_VALUES, $this->_getAllParams());
				// return to the home page
				if(!isEmptyString($this->_getParam(URL_FAILURE))){
					$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
				}
	    		$this->_helper->redirector->gotoSimple('login', "user");
	    		return false; 
			}
			
			// user is logged in sucessfully so add information to the session 
			$user = $authAdapter->getResultRowObject();
			$useraccount = new UserAccount(); 
			$useraccount->populate($user->id);
        }
		
        # if user is loggin with phone
        if($credcolumn == 'phone'){
        	$useracc = new UserAccount();
        	$phone = substr($this->_getParam("email"), '-9');
        	// debugMessage($phone); exit();
        	$result = $useracc->validateUserUsingPhone($this->_getParam("password"), $phone, $country);
        	// debugMessage($result); exit();
        	
        	// user does not exit
        	if(count($result) == 0){
        		$browser = new Browser();
				$audit_values = array("browserdetails" => $browser->getBrowserDetailsForAudit());
        		$audit_values['transactiontype'] = USER_LOGIN;
	    		$audit_values['success'] = "N";
	    		$audit_values['transactiondetails'] = "Login for user with identity '".$this->_getParam("email")."' failed. Invalid username or password";
				$this->notify(new sfEvent($this, USER_LOGIN, $audit_values));
				
				$session->setVar(ERROR_MESSAGE, "Invalid Email Address, Phone or Password. <br />Please Try Again."); 
				$session->setVar(FORM_VALUES, $this->_getAllParams());
				// return to the home page
	        	if(!isEmptyString($this->_getParam(URL_FAILURE))){
					$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
				}
	    		$this->_helper->redirector->gotoSimple('login', "user");
	    		return false; 
        	}
        	
        	// user password successfully validated
        	$useraccount = new UserAccount(); 
			$useraccount->populate($result[0]['id']);
        }
        
        // kick out any kenyan logging into uganda OR kick out any ugandan (not admin) logging into kenya
        if(!isEmptyString($useraccount->getID())){
        	if((strtolower($country) == 'ug' && $useraccount->isKenyan()) || (strtolower($country) == 'ke' && $useraccount->isUgandan() && !$useraccount->isAdmin())){
        		$this->clearSession();
	        	// debugMessage('kenyan accessing uganda invalidly');
	        	$browser = new Browser();
				$audit_values = array("browserdetails" => $browser->getBrowserDetailsForAudit());
	        	$audit_values['transactiontype'] = USER_LOGIN;
		    	$audit_values['success'] = "N";
		    	$audit_values['transactiondetails'] = "Login for user with identity '".$this->_getParam("email")."' denied. Invalid domain access (".$useraccount->getCountry().") into ".$country;
				$this->notify(new sfEvent($this, USER_LOGIN, $audit_values));
					
				$session->setVar(ERROR_MESSAGE, "Invalid Email Address, Phone or Password. <br />Please Try Again."); 
				$session->setVar(FORM_VALUES, $this->_getAllParams());
					
				// return to the home page
		        if(!isEmptyString($this->_getParam(URL_FAILURE))){
					$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
				}
		    	$this->_helper->redirector->gotoSimple('login', "user");
		    	return false;
        	}
        }
		// debugMessage($useraccount->toArray()); exit();
		
		$session->setVar("userid", $useraccount->getID());
		$session->setVar("type", $useraccount->getType());
		$session->setVar("farmergroupid", $useraccount->getFarmGroupID());
		$session->setVar('country', $useraccount->getCountry());

		// clear user specific cache, before it is used again
    	$this->clearUserCache();
    
		// Add successful login event to the audit trail
		$browser = new Browser();
		$audit_values = array("browserdetails" => $browser->getBrowserDetailsForAudit());
		$audit_values['transactiontype'] = USER_LOGIN;
    	$audit_values['success'] = "Y";
		$audit_values['userid'] = $useraccount->getID();
		$audit_values['executedby'] = $useraccount->getID();
   		$audit_values['transactiondetails'] = "Login for user with Identity '".$this->_getParam("email")."' successful";
		$this->notify(new sfEvent($this, USER_LOGIN, $audit_values));
		
		if (isEmptyString($this->_getParam("redirecturl"))) {
			# forward to the dashboard
			if($this->_getParam('mobilelogin') == 1){
				$this->_helper->redirector->gotoSimple("home", "mobile");
			}
			$this->_helper->redirector->gotoSimple("index", "dashboard");
		} else {
			# redirect to the page the user was coming from 
			$this->_helper->redirector->gotoUrl(decode($this->_getParam("redirecturl")));
		}
    }
    
	/**
     * Action to display the Login page 
     */
    public function loginAction()  {
        // do nothing 
        $session = SessionWrapper::getInstance(); 
   		if(!isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("dashboard"));	
		} 
    }
    public function recoverpasswordAction() {
    	
    }
    public function processrecoverpasswordAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		$session = SessionWrapper::getInstance();
		
		// debugMessage($this->_getAllParams());
    	if (!isEmptyString($formvalues['email'])) {
    		// process the password recovery 
    		$user = new UserAccount(); 
    		$useraccount = new UserAccount(); 
    		// $user->setEmail($this->_getParam('email')); 
	    	# check which field user is using to login. default is username
			$credcolumn = "username";
	    	$login = (string)$formvalues['email'];
	    	
	    	# check if credcolumn is phone 
	    	if((strlen($login) >= 9 || strlen($login) <= 12) && is_numeric(substr($login, -6, 6))){
	    		$credcolumn = 'phone';
	    	}
	    	
	    	# check if credcolumn is emai
	    	$validator = new Zend_Validate_EmailAddress();
			if ($validator->isValid($login)) {
	        	$credcolumn = 'email';
	        }
        	// debugMessage($credcolumn); // exit();
        	$userfond = false;
	        switch ($credcolumn) {
	        	case 'email':
	        		$useraccount->findByEmail($formvalues['email']);
	        		break;
	        	case 'phone':
	        		$useraccount = $user->fetchByPhone(getFullPhone($formvalues['email']));
	        		if(!isEmptyString($useraccount->getID())){
	        			$userfond = true;
	        		}
	        		break;
	        	case 'username':
	       			if($useraccount->findByUsername($formvalues['email'])){
	        			$userfond = true;
	        		}
	        		break;
	        	default:
	        		break;
	        }
    		// debugMessage($useraccount->toArray()); exit();
	        if(!isEmptyString($useraccount->getID()) && (!isEmptyString($useraccount->getEmail()) || !isEmptyString($useraccount->getPhone()))){
    			$useraccount->recoverPassword();
    			// send a link to enable the user to recover their password 
    			$this->_helper->redirector->gotoUrl($this->view->baseUrl("user/recoverpasswordconfirmation"));	
    		} else {
    			// send an error message that no user with that email was found 
    			$session = SessionWrapper::getInstance(); 
    			$session->setVar(FORM_VALUES, $this->_getAllParams()); 
    			$session->setVar(ERROR_MESSAGE, $this->_translate->translate("useraccount_user_invalid_error"));
    			$this->_helper->redirector->gotoUrl($this->view->baseUrl("user/recoverpassword"));
    		}
    	}
    	// exit();
    }
    
    public function resetpasswordAction() {
    	$user = new UserAccount(); 
    	$user->populate(decode($this->_getParam('id')));

    	// verify that the activation key in the url matches the one in the database
	    if ($user->getActivationKey() != $this->_getParam('actkey')) {
    		// send a link to enable the user to recover their password 
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl("user/activationerror"));
    	} 
    	
    }
    
    public function processresetpasswordAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance(); 
		// debugMessage($this->_getAllParams());
		$user = new UserAccount(); 
    	$user->populate(decode($this->_getParam('id')));
    	// debugMessage($user->toArray());
    	
   		if ($user->resetPassword($this->_getParam('password'))) {
    		// send a link to enable the user to recover their password 
    		$session->setVar(SUCCESS_MESSAGE, "Sucessfully saved. You can now log in using your new Password");
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl("user/login"));
    	} else {
    		// echo "cannot reset password"; 
    		// send an error message that no user with that email was found 
    		$session = SessionWrapper::getInstance(); 
    		$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString());
    		$session->setVar(FORM_VALUES, $this->_getAllParams());
    		$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
    	}
    }
    public function resetpasswordconfirmationAction() {}
    
    public function activationerrorAction() {}
    	
    public function recoverpasswordconfirmationAction() {}
	
	public function changepasswordconfirmationAction() {}
    
	/**
     * Action to display the Login page 
     */
    public function logoutAction()  {
    	$this->clearSession();
        // redirect to the login page 
        $this->_helper->redirector("login", "user");
    }
    
	public function changeemailAction(){
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
    }
}

