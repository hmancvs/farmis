<?php

class MessageController extends SecureController  {
	
	function getResourceForACL() {
		// return "Message";
		return "Farmer"; 
	}
	/**
	 * Get the name of the resource being accessed 
	 *
	 * @return String 
	 */
	function getActionforACL() {
		$action = strtolower($this->getRequest()->getActionName()); 
		
		if ($action == "markasread" || $action == "reply" || $action == "processmassmail") {
			return ACTION_EDIT; 
		}
		if ($action == "sent" || $action == "sentsearch" ||  $action == "massmail" || $action == "delete") {
			return ACTION_LIST; 
		}
		return parent::getActionforACL(); 
	}
	
	function createAction(){
		// disable rendering of the layout
		$this->_helper->layout->disableLayout();	  
		// array to store all recipient data 	
		$recipient_records = array();
		// the recipientids in the post
		$recipient_array = $this->_getParam('recipientids');
		$counter = 1;
		foreach($recipient_array as $recipientid){
			// store each recipientid in the corresponding messagerecipient object
			$recipient_records[md5($counter)]['recipientid'] = $recipientid;
			$counter++;
		}
			
		$this->_setParam('recipients', $recipient_records); 
		// debugMessage($this->_getAllParams());
		
		parent::createAction();
	}
	function viewAction(){
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();	  
	}
	function replyAction(){
			
	}
    public function markasreadAction(){
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$session = SessionWrapper::getInstance(); 
		// debugMessage($this->_getAllParams());
		// user is deleting more than one message
		$idsarray = array();
		
		$idsarray = $this->_getParam("messagesformarking");
		// remove all empty keys in the array of ids to be deleted
		foreach ($idsarray as $key => $value){
			if(isEmptyString($value)){
				unset($idsarray[$key]);
			}
		}
		// debugMessage($idsarray);
		$messagerecipient = new MessageRecipient();
		// mark selected message details using selected mark action
   		$messagerecipient->markAsRead($idsarray, $this->_getParam("markaction"));
		// debugMessage("Message(s) were successfully marked");
		// fetch number of remaining unread messages for the user 
		$remaining = $messagerecipient->countUnReadMessages($session->getVar('userid'));		
		$session->setVar('unread', $remaining);
		// if no unread messages hide unread label else show unread in brackets
		if($remaining == '0'){
			$newmsghtml = '<a title="Messages" href="'.$this->_helper->url('list', 'message').'"><img src="'.$this->_helper->url('email.png', 'images').'">Messages</a>';		
		} else {
			$newmsghtml = '<a title="Messages" href="'.$this->_helper->url('list', 'message').'"><img src="'.$this->_helper->url('email.png', 'images').'">Messages (<label class="unread">'.$session->getVar('unread').' Unread</label>)</a>';	
		}
		
		$session->setVar('newmsghtml', $newmsghtml);
		echo $session->getVar('newmsghtml');
		
		return false;
	}
	function deleteAction(){		
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		if($this->_getParam("deletemultiple") == '1'){
			// debugMessage($this->_getAllParams());
			// user is deleting more than one message
			$idsarray = $this->_getParam("messagesfordelete");
			// remove all empty keys in the array of ids to be deleted
			foreach ($idsarray as $key => $value){
				if(isEmptyString($value)){
					unset($idsarray[$key]);
				}
			}
			// debugMessage($idsarray);
			$message = new Message();
			if($message->deleteMultiple($idsarray)){
				debugMessage("Message(s) were successfully deleted");
			} else {
				debugMessage("An error occured in deleting your message(s)");
			}
			
		} else {
			// user is deleting only one message from reply page
			// the messageid being deleted
			$msgid = $this->_getParam("idfordelete");
			// debugMessage($this->_getAllParams());
			
			// populate message to be deleted
			$message = new Message();
			$message->populate($msgid);
			
			if($message->delete()){
				debugMessage("Message was successfully deleted");
			} else {
				debugMessage("An error occured in deleting your message");
			}
		}
		return false;
	}
	
	function massmailAction(){
		
	}
	function processmassmailAction() {
		$session = SessionWrapper::getInstance();
		$formvalues = $this->_getAllParams();
		// debugMessage($formvalues);
		// user group collection object
		$query = Doctrine_Query::create()->from('UserAccount u')->innerJoin('u.usergroups g')->where("g.groupid = '".$formvalues['groupid']."'");
		$users = $query->execute();
		// debugMessage($groups->toArray());
		
		$messages = array();
		// collection to be used to save messages to inbox
		$message_collection = new Doctrine_Collection(Doctrine_Core::getTable("Message"));
		foreach ($users as $member){
			$messages[$member->getID()]['senderid'] = $session->getVar('userid');
			$messages[$member->getID()]['subject'] = $formvalues['subject'];
			$messages[$member->getID()]['contents'] = $formvalues['contents'];
			$messages[$member->getID()]['recipients'][md5($member->getID())]['recipientid'] = $member->getID();
		}
		
		// debugMessage($messages);
		foreach ($messages as $data) {
			$message = new Message();
			$message->processPost($data);
			//debugMessage('error is '.$message->getErrorStackAsString());
			if($message->isValid()) {
				$message_collection->add($message);
			}			
		}
		
		// debugMessage($message_collection->toArray());
		// save messages to each members's application inbox
		if($message_collection->count() > 0){
			$message_collection->save();
		}
		
		// send email to member's email address
		foreach ($message_collection as $amessage) {
			$amessage->sendInboxEmailNotification($formvalues['from'], $formvalues['sendername']);
		}
		
		// return to mass mail page
		$session->setVar(SUCCESS_MESSAGE, 'Mass email has been successfully sent'); 
		$this->_helper->redirector->gotoUrl($this->view->baseUrl('message/massmail'));
	}
}