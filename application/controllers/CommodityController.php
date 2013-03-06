<?php

class CommodityController extends SecureController {
	
	function getResourceForACL() {
		// return "Commodity";
		return "Farmer";  
	}
 	public function getActionforACL() {
        $action = strtolower($this->getRequest()->getActionName()); 
		if($action == "add" || $action == "processadd") {
			return ACTION_CREATE; 
		}
    	if($action == "search" || $action == "addsuccess" || $action == "delete" ||  $action == "temp"
    		
    	) {
			return ACTION_VIEW; 
		}
		return parent::getActionforACL(); 
    }
	public function addAction(){}

	public function addsuccessAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("global_save_success"));
    }
    function tempAction(){
    	$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		debugMessage($formvalues);
		
		$commodity = new Commodity();
		//$contact->populate(1);
		// debugMessage($commodity->toArray());
		$data = array(
			"id" => "",
			"name" => "test",
			"unitid" => "5",
			"categoryid" => "3",
			"createdby" => "1"
		);
		
		$formvalues = array_merge_maintain_keys($formvalues, $data);
		$commodity->processPost($formvalues);
		//debugMessage($commodity->toArray());
		//debugMessage($commodity->getErrorStackAsString());
		// $commodity->save();
    }
}