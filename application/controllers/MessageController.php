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
		// debugMessage($formvalues); // exit();
		
		$messages = array();
		$message_collection = new Doctrine_Collection(Doctrine_Core::getTable("Message"));
		// user group collection object
		if($formvalues['type'] == 1){
			if(!isArrayKeyAnEmptyString('groupid', $formvalues)){
				$users = getFarmers($formvalues['groupid'], false, false, true, '', $formvalues['country']);
			} else {
				$users = getFarmers('', false, false, true, '', $formvalues['country']);
			}
			if(count($users) > 0){
				foreach ($users as $id => $line){
					$user = new UserAccount();
					$user->populate($id); 
					$messages[0]['senderid'] = $session->getVar('userid');
					$messages[0]['subject'] = $formvalues['subject'];
					$messages[0]['contents'] = $formvalues['contents'];
					$messages[0]['recipients'][md5($user->getID())]['recipientid'] = $user->getID();
				}
			}
		} else {
			if(!isArrayKeyAnEmptyString('farmerids', $formvalues)){
				foreach ($formvalues['farmerids'] as $id){
					$user = new UserAccount();
					$user->populate($id); 
					$messages[$user->getID()]['senderid'] = $session->getVar('userid');
					$messages[$user->getID()]['subject'] = $formvalues['subject'];
					$messages[$user->getID()]['contents'] = $formvalues['contents'];
					$messages[$user->getID()]['recipients'][md5($user->getID())]['recipientid'] = $user->getID();
				}
			}
		}
		
		// debugMessage($messages); exit;
		foreach ($messages as $data) {
			$message = new Message();
			$message->processPost($data);
			// debugMessage('error is '.$message->getErrorStackAsString());
			if($message->isValid()) {
				$message_collection->add($message);
			}			
		}
		
		// debugMessage($message_collection->toArray()); exit;
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
		$this->_helper->redirector->gotoUrl($this->view->baseUrl('resource/massmail'));
		// exit();
	}
}