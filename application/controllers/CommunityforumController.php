<?php

class CommunityforumController extends SecureController  {
	
	function getResourceForACL() {
		//return "Community Forum";
		 return "Farmer"; 
	}
	/**
	 * Get the name of the resource being accessed 
	 *
	 * @return String 
	 */
	function getActionforACL() {
		$action = strtolower($this->getRequest()->getActionName()); 
    	if($action == "delete") {
			return ACTION_VIEW; 
		}
		return parent::getActionforACL(); 
	}
	function deleteAction(){		
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		// populate comment to be deleted
		$communityforum = new CommunityForum();
		$communityforum->populate($this->_getParam("id"));
		// debugMessage($communityforumcomment->toArray());
		
		if($communityforum->delete()){
			debugMessage("Topic was successfully deleted");
			$session = SessionWrapper::getInstance(); 
			$session->setVar(SUCCESS_MESSAGE, 'Topic successfully deleted'); 	
		} else {
			debugMessage("An error occured in deleting the topic");
		}
		return false;
	}
}