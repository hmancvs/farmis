<?php

class ContactusController extends IndexController  {
	
	/**
	 * Sends the details of the support form by email 
	 */
	public function processcontactusAction() {
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues); // exit();
		$fail = false; $error = '';
		if(isEmptyString($this->_getParam('name'))){
			$fail = true;
			$error .= 'Error: Please enter Name<br>';
		}
		if(isEmptyString($this->_getParam('email'))){
			$fail = true;
			$error .= 'Error: Please enter Email<br>';
		}
		if(isEmptyString($this->_getParam('subject'))){
			$fail = true;
			$error .= 'Error: Please enter Subject<br>';
		}
		if(isEmptyString($this->_getParam('message'))){
			$fail = true;
			$error .= 'Error: Please enter Message<br>';
		}
		if(stringContains('jackkr', strtolower($this->_getParam('email'))) || 
		   stringContains('brightwah', strtolower($this->_getParam('email'))) || 
		   !isEmptyString($this->_getParam('spamcheck')) ||
		   isEmptyString($this->_getParam('code'))  
		){
			$fail = true;
			$error .= 'Error: Spam detected. Please try again<br>';
		}
		if((isUganda() && !stringContains('farmis.ug', strtolower($_SERVER['HTTP_REFERER']))) || 
			(isKenya() && !stringContains('farmis.co.ke', strtolower($_SERVER['HTTP_REFERER'])))
		){
			$fail = true;
			$error .= 'Error: Spam detected. Domain "'.strtolower($_SERVER['HTTP_REFERER']).'" error!!!<br>';
		}
		
		if($fail){
			$session->setVar(ERROR_MESSAGE, $error);
			$this->_redirect($this->view->baseUrl('contactus/index/result/error'));
		}
		
		$user = new UserAccount();
		if($user->sendContactNotification($formvalues)){
			$session->setVar(SUCCESS_MESSAGE, "Thank you for your interest in the FARMIS program. We shall be getting back to you shortly.");
			$this->_redirect($this->view->baseUrl('contactus/index/result/success'));
		} else {
			$session->setVar(ERROR_MESSAGE, 'Sorry! An error occured in sending the message. Please try again later ');
			$this->_redirect($this->view->baseUrl('contactus/index/result/error'));	
		}
	}
}

