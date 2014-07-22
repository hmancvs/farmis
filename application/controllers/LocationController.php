<?php

class LocationController extends SecureController {
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
    
	public function processgpsAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$session = SessionWrapper::getInstance(); 	
	    $config = Zend_Registry::get("config");
	    $this->_translate = Zend_Registry::get("translate");
	    $formvalues = $this->_getAllParams();
	    $formvalues['id'] =  decode($formvalues['id']);
	    
	    // debugMessage($formvalues);
	    $location = new Location();
	    $location->populate($formvalues['id']);
	    
	    $location->setGpsLat($formvalues['lat']);
	    $location->setGpsLng($formvalues['lng']);
	    // debugMessage($location->toArray());
	    
	    exit();
	    try {
	    	$location->save();
	    	$session->setVar(SUCCESS_MESSAGE, "Location successfully saved");
	    	$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
	    } catch (Exception $e) {
	    	$session->setVar(ERROR_MESSAGE, $e->getMessage()); 
	    	$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
	    }
	}
	
	public function indexpopupAction() {
		$this->_helper->layout->disableLayout();
	}
	
	public function viewpopupAction() {
		$this->_helper->layout->disableLayout();
	}
	
	public function createAction() {
		$session = SessionWrapper::getInstance();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_translate = Zend_Registry::get("translate"); 
		
		$this->_setParam('action', 'create');
		if(!isEmptyString($this->_getParam('id'))){
			$this->_setParam('action', 'edit');
		}
		
		$formvalues = $this->_getAllParams();
		$formvalues['createdby'] = $session->getVar('userid');
		
		$location_collection = new Doctrine_Collection(Doctrine_Core::getTable("Location"));
		$location = new Location();
			
		if(isEmptyString($this->_getParam('id'))){
			// $location->processPost($formvalues);
			$name = str_replace(' ', '', trim($formvalues['name']));
			$issingle = true;
			$ismultiple = false;
			$name_array = array();
			$name_array = explode(',', $name);
			
			// debugMessage($name_array);
			if(count($name_array) > 0){
				foreach($name_array as $item){
					$formvalues['name'] = $item;
					$loc = new Location();
					$loc->processPost($formvalues);
					// debugMessage('error is '.$loc->getErrorStackAsString());
					if($loc->isValid()) {
						$location_collection->add($loc);
					}
				}
			}
			// debugMessage($location_collection->toArray());
			if($location_collection->count() > 0){
				$location_collection->save();
				$session->setVar(SUCCESS_MESSAGE, 'Successfully saved');
			}
			
		} else {
			$id = $formvalues['id'] = decode($formvalues['id']);
			$location->populate($id);
			$location->processPost($formvalues);
			
			if($location->hasError()){
				$session->setVar(ERROR_MESSAGE, $location->getErrorStackAsString());
				return false;
			}
			
			try {
				$location->save();
				$location->afterUpdate();
				$session->setVar(SUCCESS_MESSAGE, 'Successfully updated');
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
				return false;
			}
		}
		// exit();
	}
	
	public function editAction() {
		
		
	}
}