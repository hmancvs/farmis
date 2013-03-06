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
		$action = strtolower($this->getRequest()->getActionName()); 
		if ($action == "changepassword" || $action == "resetpassword") {
			return ACTION_EDIT; 
		}
		return parent::getActionforACL(); 
	}	
	
    function changepasswordAction()  {
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate"); 
    	if(!isEmptyString($this->_getParam('password'))){
	        $user = new UserAccount(); 
	    	$user->populate(decode($this->_getParam('id')));
	    	
	    	# Change password
	    	if ($user->changePassword($this->_getParam('oldpassword'), $this->_getParam('password') )) {
	    		// clear the session
       			$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate($this->_getParam(SUCCESS_MESSAGE)));
	   			// send a link to enable the user to recover their password 
	   			$this->_helper->redirector("view", "profile");
	   		} else {
	   			// send an error message that no user with that email was found 
	   			$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString());
	   			$session->setVar(FORM_VALUES, $this->_getAllParams());
	   			$this->_helper->redirector("changepassword", "profile");
	   		}
    	}
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
}

