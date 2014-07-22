<?php 

class Comment extends BaseEntity {
	
	public function setTableDefinition(){
		parent::setTableDefinition();
		
		$this->setTableName('comment');
		$this->hasColumn('userid', 'integer', null, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('communityforumid', 'integer', null);
		$this->hasColumn('content', 'string', 1000, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('type', 'tinyint');
		
		$this->setSubclasses(array(
				'CommunityForumComment' => array('type' => 1)
			)
		);
	}
	/**
	 * Contructor method for custom functionality - add error messages and any fields to be marked as dates
	*/
	public function construct() {
		parent::construct();
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"content.notblank" => $this->translate->_("comment_contents_error"),
       									"userid.notblank" => $this->translate->_("comment_userid_error")
       								)); 
	}
	
	function setUp() {
    	parent::setUp();
    	// foreign key for the group
    	$this->hasOne('UserAccount as user', array(
							'local' => 'userid',
							'foreign' => 'id')
					);
		$this->hasOne('Message as message',
					array('local' => 'id',
						  'foreign' => 'commentid'
					)
			);
		$this->hasOne('CommunityForum as communityforum',
					array('local' => 'communityforumid',
						  'foreign' => 'id'
					)
			);
    }
	/*
	 * Pre process model data 
	 */
	function processPost($formvalues){
		# force setting of default none string column values. enum, int and date 	
		if(isArrayKeyAnEmptyString('parentid', $formvalues)){
			$formvalues['parentid'] = NULL; 
		}
		if(isArrayKeyAnEmptyString('communityforumid', $formvalues)){
			$formvalues['communityforumid'] = NULL; 
		}
		parent::processPost($formvalues);
	}
	/**
	 * After comment is saved successfully
	 */
	function afterSave() {
		// send notifications in inbox and email
		switch ($this->getType()) {
			case 1:
				// get all communityforum recipients 
				$users = $this->getCommunityForumMembersToBeNotified();
				// debugMessage($users);
				// set and save owner's application inbox message
				if($this->getUserID() == $this->getCommunityForum()->getCreatedBy() && count($users) > 0){
					// owner has commented. all other users are just participants 
					$subject = sprintf($this->translate->_('message_communityforum_comment_ownertomember_email_subject'), $this->getUser()->getName(), $this->getUser()->getGenderString());
					$recipients = array();
					foreach ($users as $key => $value){
						$recipients[md5($key)]['recipientid'] = $value['userid'];
					}
					$message_dataarray = array(
						"senderid" => $this->getUserID(),
						"subject" => '',
						"contents" => $subject,
						"commentid" => $this->getID(),
						"recipients" => $recipients
					);
					// process message data
					$message = new Message();
					$message->processPost($message_dataarray);
					
					$this->setMessage($message);
					
					// save message to application inbox 
					$this->save();
					
				} else {
					// other participants have commented. 				
					// set and save message for owner
					$subject = sprintf($this->translate->_('message_communityforum_comment_owner_email_subject'), $this->getUser()->getName());
					$message_dataarray = array(
						"senderid" => $this->getUserID(),
						"subject" => '',
						"contents" => $subject,
						"commentid" => $this->getID(),
						"recipients" => array(
											md5(1) => array("recipientid" => $this->getCommunityForum()->getCreatedBy())
										)
					);
					// process message data
					$message = new Message();
					$message->processPost($message_dataarray);
					
					$this->setMessage($message);
					// debugMessage($this->toArray());
					
					// save message to application inbox 
					$this->save();
					
					// set and save message for recipients. 
					// check if there are any other users and save their application inbox messages
					if(count($users) > 0){
						$message = new Message();
						// reset message data array
						$message_dataarray = array();
						$this->setMessage($message);
						
						$subject = sprintf($this->translate->_('message_communityforum_comment_membertomember_email_subject'), $this->getUser()->getName(), $this->getCommunityForum()->getCreator()->getName());
						$recipients = array();
						foreach ($users as $key => $value){
							$recipients[md5($key)]['recipientid'] = $value['userid'];
						}
					
						$message_dataarray = array(
							"senderid" => $this->getUserID(),
							"subject" => '',
							"contents" => $subject,
							"commentid" => $this->getID(),
							"recipients" => $recipients
						);
						
						$message->processPost($message_dataarray);
						$this->setMessage($message);
						
						// save message to application inbox 
						$this->save();
					}
				}
			// send comment email notification if comment recipient has allowed this under account settings
			$this->sendCommunityForumCommentEmailNotification();
			
			break;
		}
		
		return true;
	}
	/**
	 * Send a notification to a user that a comment has been made on their workarea
	 * 
	 * @return Boolean whether the email notification has been sent
	 *
	 */
	function sendCommunityForumCommentEmailNotification() {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance(); 
		
		// the message sender's name
		$template->assign('emailsender', $this->getUser()->getName());
		// message introduction depending on the comment type. See sub class for implementation
		$template->assign('commentemailintro', $this->getUser()->getFirstName().' wrote');
		// set email content as the actual Comment 
		$template->assign('emailcontent', $this->getContent());
		// path to omment thread depending on the comment type. See sub class for implementation	
		$template->assign('emaillink', array("controller"=> "communityforum", "action"=> "view", "id"=> encode($this->getCommunityForumID())));

		// set the send of the email address
		$mail->setFrom($this->config->notification->emailmessagesender, $this->translate->_('appname'));
		
		$users = $this->getCommunityForumMembersToBeNotified();
		if($this->getUserID() == $this->getCommunityForum()->getCreatedBy() && count($users) > 0){
			$subject = sprintf($this->translate->_('message_communityforum_comment_ownertomember_email_subject'), $this->getUser()->getName(), $this->getUser()->getGenderString());
			$mail->setSubject($subject);
			// set the subject for the different participants and check that user can receive email
			foreach($users as $participant) {
				if($participant['emailmeoncomment'] == 1){
					$template->assign('firstname', $participant['firstname']);
					$mail->setBodyHtml($template->render('commentnotification.phtml'));
					// debugMessage($template->render('commentnotification.phtml'));
					$mail->addTo($participant['email'], $participant['fullname']);
					$mail->send();
					// clear body and recipient in each email
					$mail->clearRecipients();
					$mail->setBodyHtml('');
				}
			}
		} else {
			$subject = sprintf($this->translate->_('message_communityforum_comment_owner_email_subject'), $this->getUser()->getName());
			$mail->setSubject($subject);
			$template->assign('firstname', $this->getCommunityForum()->getCreator()->getFirstName());
			$mail->setBodyHtml($template->render('commentnotification.phtml'));
			// debugMessage($template->render('commentnotification.phtml'));
			$mail->addTo($this->getCommunityForum()->getCreator()->getEmail(), $this->getCommunityForum()->getCreator()->getName());
			if($this->getCommunityForum()->getCreatedBy() != $this->getUserID()){
				$mail->send();
			}
			// debugMessage($users);
			// check if there are any participants 
			if(count($users) > 0){
				// first clear the headers for subject, email and body
				$mail->clearRecipients();
				$mail->clearSubject();
				$mail->setBodyHtml('');
			
				$subject = sprintf($this->translate->_('message_communityforum_comment_membertomember_email_subject'), $this->getUser()->getName(), $this->getCommunityForum()->getCreator()->getName());
				$mail->setSubject($subject);
				// set the subject for the different participants  and check that user can receive email
				foreach($users as $participant) {
					if($participant['emailmeoncomment'] == 1){
						$template->assign('firstname', $participant['firstname']);
						$mail->setBodyHtml($template->render('commentnotification.phtml'));
						// debugMessage($template->render('commentnotification.phtml'));
						$mail->addTo($participant['email'], $participant['fullname']);
						$mail->send();
						// clear body and recipient in each email
						$mail->clearRecipients();
						$mail->setBodyHtml('');
					}
				}
			}
		}
		
		return true;
	}
	/**
	 * Return collection of users to be notified on this comment
	 */
	function getCommunityForumMembersToBeNotified() {
		$session = SessionWrapper::getInstance(); 
		$conn = Doctrine_Manager::connection(); 
		//query users participating in the communityforum other than the logged in user 
		$disc_members = $conn->fetchAll("SELECT c.userid as userid, u.email as email, u.firstname as firstname, concat(u.firstname,' ',u.lastname) as fullname, u.emailmeoncomment as emailmeoncomment FROM comment as c inner join useraccount as u on (c.userid = u.id) WHERE communityforumid = '".$this->getCommunityForumID()."' AND (userid <> '".$this->getUserID()."' AND userid <> '".$this->getCommunityForum()->getCreatedBy()."') GROUP BY userid");
		return $disc_members;
	}	
}
?>