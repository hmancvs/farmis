<?php

class TestController extends IndexController  {
	
    function smsAction(){
    	// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    
	    $session = SessionWrapper::getInstance(); 
	    $formvalues = $this->_getAllParams();
	    // debugMessage($formvalues);
	    $phone = $this->_getParam('phone');
	    if(!isEmptyString($this->_getParam('msisdn'))){
	    	$phone = $this->_getParam('msisdn');
	    }
	    $message = $this->_getParam('msg');
	    if(isEmptyString($message)){
	    	$message = "Dear User, This is an automated test message from FARMIS system. confirm route - ".mktime();
	    }
	    if(isEmptyString($phone)){
	    	$phone = SMS_TEST_NUMBER;
	    	if(isKenya()){
	    		$phone = SMS_TEST_NUMBER_KENYA;
	    	}
	    }
	    sendSMSMessage($phone, $message, $this->_getParam('source'));
    }
    
	function sendsmsAction(){
    	// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    
	    $session = SessionWrapper::getInstance(); 
	    $formvalues = $this->_getAllParams();
	    // debugMessage($formvalues);
	   	
		$phone = $this->_getParam('phone');
	    if(!isEmptyString($this->_getParam('msisdn'))){
	    	$phone = $this->_getParam('msisdn');
	    }
	    $message = $this->_getParam('msg');
	    if(isEmptyString($message)){
	    	$message = "Dear User, This is an automated test message from FARMIS system. confirm route - ".mktime();
	    }
	    if(isEmptyString($phone)){
	    	$phone = SMS_TEST_NUMBER;
	    	if($this->_getParam('warid') == 1){
	    		$phone = 256701595279;
	    	}
	    	if(isKenya()){
	    		$phone = SMS_TEST_NUMBER_KENYA;
	    	}
	    }
	    
	    sendSMS($phone, $message, $this->_getParam('source'));
    }
    
    function testmailAction(){
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    
    	sendTestMessage('hman test','farmis email testing');
    }
    
    
	function emailAction(){
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    
	    sendTestMessage('test farmis email','this is a test message for farmis please ignore - '.APPLICATION_ENV);
    }
    
    function duplicatesAction() {
		$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
    	$user = new UserAccount();
    	$user->populate($this->_getParam('id'));
    	debugMessage($user->toArray());
    	$duplicates = $user->getDuplicates();
    	debugMessage($duplicates->toArray());
    	$countdup = $duplicates->count();
		if($countdup > 0){
			$duplicates->delete();
		}
    }
}

