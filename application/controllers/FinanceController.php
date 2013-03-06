<?php

class FinanceController extends SecureController   {

    public function getActionforACL() {
        $action = strtolower($this->getRequest()->getActionName()); 
		if($action == "recordcredit" || $action == "processrecordcredit" || $action == "paycredit" || $action == "processpaycredit"
		) {
			return ACTION_CREATE; 
		}
    	if($action == "credithistory" || $action == "creditview" || $action == "recordcreditsuccess" || $action == "paycreditsuccess" 
    		|| $action == "delete" || $action == "statement" || $action == "statementsearch" || $action == "creditreport"
    	) {
			return ACTION_VIEW; 
		}
		return parent::getActionforACL(); 
    }
    
    public function getResourceForACL(){
        return "Farmer"; 
    }
    
	public function paycreditAction() {}
	
	public function paycreditviewAction() {}

	public function credithistoryAction() {}

	public function processpaycreditAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		// exit();
		parent::createAction();	
	}
	
	function paycreditsuccessAction() {
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
    
	public function statementAction() {}
	
	public function statementsearchAction() {
		$this->_helper->redirector->gotoSimple('statement', 'finance', 
    	$this->getRequest()->getModuleName(),
    	array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	public function creditreportAction() {}
}