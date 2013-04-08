<?php
class SeasonController extends SecureController   {

    public function getActionforACL() {
        $action = strtolower($this->getRequest()->getActionName()); 
		if($action == "input" || $action == "inputcreate" || 
			$action == "tillage" || $action == "tillagecreate" || 
			$action == "plant" || $action == "plantcreate" || 
			$action == "treat" || $action == "treatcreate" || 
			$action == "activity" || $action == "activitycreate" ||
			$action == "harvest" || $action == "harvestcreate" || 
			$action == "expense" || $action == "expensecreate" || 
			$action == "notes" || $action == "notescreate" || 
			$action == "sale" || $action == "salecreate" 
		) {
			return ACTION_CREATE; 
		}
    	if($action == "inputview" || $action == "tillageview" || $action == "plantview" || $action == "treatview" ||
    		$action == "harvestview" || $action == "expenseview" || $action == "notesview" || $action == "saleview" || $action == "activityview" || 
    		$action == "calendar" || $action == "delete" || $action == "addexpsuccess" ||
    		$action == "addnotessuccess"
    	) {
			return ACTION_VIEW; 
		}
		return parent::getActionforACL(); 
    }
    
    public function getResourceForACL(){
        return "Farmer"; 
    }
    
	function inputAction(){}
	function inputviewAction(){}
	function inputcreateAction(){
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		// exit();
		parent::createAction();	
	}
	function inputeditAction(){
		
	}
	
	function tillageAction(){}
	function tillageviewAction(){}
	function tillagecreateAction(){
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		// exit();
		parent::createAction();	
	}
	function tillageeditAction(){
		
	}
	
	function plantAction(){}
	function plantviewAction(){}
	function plantcreateAction(){
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		// exit();
		parent::createAction();	
	}
	function planteditAction(){
		
	}
	
	function treatAction(){}
	function treatviewAction(){}
	function treatcreateAction(){
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		// exit();
		parent::createAction();	
	}
	function treateditAction(){
		
	}
	
	function activityAction(){}
	function activityviewAction(){}
	function activitycreateAction(){
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		// exit();
		parent::createAction();	
	}
	function activityeditAction(){
		
	}
	
	function harvestAction(){}
	function harvestviewAction(){}
	function harvestcreateAction(){
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		// exit();
		parent::createAction();	
	}
	function harvesteditAction(){
		
	}
	
	function saleAction(){}
	function saleviewAction(){}
	function salecreateAction(){
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		// exit();
		parent::createAction();	
	}
	function saleeditAction(){
		
	}
	function calendarAction(){
		
	}
	
	function expenseAction(){}
	function expenseviewAction(){}
	function expensecreateAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		//exit();
		parent::createAction();	
	}
	function addexpsuccessAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance(); 
		$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate($this->_getParam(SUCCESS_MESSAGE)));
	}
	
	function notesAction(){}
	function notesviewAction(){}
	function notescreateAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		//exit();
		parent::createAction();	
	}
	function addnotessuccessAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance(); 
		$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate($this->_getParam(SUCCESS_MESSAGE)));
	}
	
	function deleteAction() {
    	$session = SessionWrapper::getInstance(); 
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$successurl = decode($formvalues['successurl']);
		$classname = $formvalues['entityname'];
		// debugMessage($successurl);
		
    	$obj = new $classname;
    	$obj->populate($formvalues['id']);
    	// debugMessage($obj->toArray());
    	// exit();
    	if($obj->delete()) {
    		$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("global_delete_success"));
    		$this->_helper->redirector->gotoUrl($successurl);
    	}
    	
    	return false;
    }
}