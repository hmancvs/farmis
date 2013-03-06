<?php

class CommunityforumcommentController extends SecureController {
	function getResourceForACL() {
		// return "Forum Comment";
		return "Farmer"; 
	}
	
	public function getActionforACL() {
        $action = strtolower($this->getRequest()->getActionName()); 
		if($action == "add") {
			return ACTION_CREATE; 
		}
    	if($action == "delete" || $action == "create") {
			return ACTION_VIEW; 
		}
		return parent::getActionforACL(); 
    }
    
	function createAction(){
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
		
		parent::createAction();
	}
	
	function viewAction(){
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
	    $formvalues = $this->_getAllParams();
	   
	    $id = decode($formvalues['id']);
		$communityforumcomment = new CommunityForumComment();
		$communityforumcomment->populate($id);	
		// debugMessage($communityforumcomment->toArray());
		// create an array of the content details
		$dcomment_array = array(
							'id' => $communityforumcomment->getID(),
							'userid' => $communityforumcomment->getUserID(),
							'content' => str_replace("\n", "<br>", $communityforumcomment->getContent()),						
							'datecreated' => date('m/d/Y - g:i A', strtotime($communityforumcomment->getDateCreated()))						
						); 
		// debugMessage($dcomment_array);
		
		echo json_encode($dcomment_array); exit();
	}
	
	function deleteAction(){		
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		// the commentid and visionstatent being deleted
		$commentid = $this->_getParam("idfordelete");
		
		// populate comment to be deleted
		$communityforumcomment = new CommunityForumComment();
		$communityforumcomment->populate($commentid);
		// debugMessage($communityforumcomment->toArray());
		
		if($communityforumcomment->delete()){
			debugMessage("Comment was successfully deleted");
		} else {
			debugMessage("An error occured in deleting your comment");
		}
		return false;
	}
}

