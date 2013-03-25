<?php

class ResourceController extends SecureController   {

	/**
	 * Get the name of the resource being accessed 
	 *
	 * @return String 
	 */
	function getActionforACL() {
		return ACTION_VIEW;
	}
    
    public function getResourceForACL(){
        return "Farmer"; 
    }
    
    function allpricesAction() {
    	
    }
    
    function variablesAction(){
    	// parent::listAction();
    }
    
	function variablessearchAction(){
		$this->_helper->redirector->gotoSimple("variables", "resource", 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function processvariableAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		debugMessage($formvalues);
		
		$haserror = false;
		if(isArrayKeyAnEmptyString('value', $formvalues)){
			$haserror = true;
			$session->setVar(ERROR_MESSAGE, 'Error: No value specified for addition');
			$session->setVar(FORM_VALUES, $formvalues);
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('resource/variables/type/'.$formvalues['lookupid']));
		}
		
		$lookupvalue = new LookupTypeValue();
		$dataarray = array('id' => $formvalues['id'],
							'lookuptypeid' => $formvalues['lookupid'], 
							'lookuptypevalue' => $formvalues['index'], 
							'lookupvaluedescription' => trim($formvalues['value']),
							'createdby' => $session->getVar('userid')
					);
		
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$lookupvalue->populate($formvalues['id']);
		}
		// unset($dataarray['id']);
		$lookupvalue->processPost($dataarray);
		
		if($lookupvalue->hasError()){
			$haserror = true;
			$session->setVar(ERROR_MESSAGE, $lookupvalue->getErrorStackAsString());
			$session->setVar(FORM_VALUES, $formvalues);
			/*debugMessage($lookupvalue->toArray());
    		debugMessage('errors are '.$lookupvalue->getErrorStackAsString());*/
		} else {
			try {
				$lookupvalue->save();
				$session->setVar(SUCCESS_MESSAGE, "Successfully Added");
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage()."<br />".$lookupvalue->getErrorStackAsString());
				$session->setVar(FORM_VALUES, $formvalues);
			}
		}
		// exit();
		$this->_helper->redirector->gotoUrl($this->view->baseUrl('resource/variables/type/'.$formvalues['lookupid']));		
		
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
    
	function massmailAction(){
    	
    }
    
	function processmassmailAction(){
		$session = SessionWrapper::getInstance(); 
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
	}
	
	function bulksmsAction(){
    	
    }
    
	function processbulksmsAction(){
		$session = SessionWrapper::getInstance(); 
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
	}
}