<?php

class NewsletterController extends IndexController   {
	
	function processaddAction() {
		// disable rendering of the view and layout 
	    $session = SessionWrapper::getInstance(); 
		$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    $formvalues = $this->_getAllParams();
	    
	    // $formvalues = array('name'=>'hman jojo', 'email'=>'hman@test.com');
		$newsletter = new Newsletter();
		$newsletter->processPost($formvalues);
		// debugMessage($newsletter->toArray());
    	// debugMessage('errors are '.$newsletter->getErrorStackAsString());
		if(!$newsletter->hasError()){
			$newsletter->save();
			$session->setVar('newsletter_success', 'Successfully subscribed for our Updates. We shall notify you accordingly. Thank you for your interest in FARMIS!'); 
		} else {
			$session->setVar('newsletter_error', $newsletter->getErrorStackAsString()); 
		}
		
		// $this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
		$this->_helper->redirector->gotoUrl($this->view->baseUrl('index'));
	}
	
	function addsuccessAction(){
		
	}
}