<?php

class ProfileController extends SecureController  {
	
	public function addAction(){
    	$this->_helper->layout->disableLayout();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
    }
    
    public function getActionforACL() {
        $action = strtolower($this->getRequest()->getActionName()); 
		if($action == "add" || $action == "other" || $action == "processother" || $action == "processadd" 
			 || $action == "resetpassword"
		) {
			return ACTION_CREATE; 
		}
    	if($action == "changepassword" || $action == "processchangepassword" || $action == "changeusername" || 
			$action == "processchangeusername" || $action == "changeemail" || $action == "processchangeemail" ||
			$action == "changephone" || $action == "processchangephone" || $action == "addcrop" || 
			$action == "processadd" || $action == "processaddcrop" || $action == "processother" || 
			$action == "processvalidatephone" || $action == 'validatephone' || $action == 'changesettings' || 
			$action == 'processgps'
		){
			return ACTION_EDIT; 
		}
    	if($action == "username" || $action == "gps" || $action == "test" || $action == "search" || 
	    	$action == "addsuccess"  || $action == "adderror" ||
	    	$action == "invite" || $action == "inviteone" || $action == "inviteonebyphone" || $action == "invitemany" || 
	    	$action == "invitemanyconfirm" || $action == "invitefriends" || $action == "invitefriendsconfirm" || 
	    	$action == "picture" || $action == "processpicture" || $action == "croppicture" ||
	    	$action == "autosearch" || $action == "delete" || 
	    	$action == "delete" || $action == "privacy" || $action == "resetprivacy" || $action == "processadd" || 
	    	$action == "report" || $action == 'validatephonesuccess' || $action == 'verifyphone' || 
	    	$action == 'dashupdate' || $action == 'events'
	    	
    	) {
			return ACTION_VIEW; 
		}
		if($action == "users" || $action == "userssearch"){
			return ACTION_LIST;
		}
		return parent::getActionforACL(); 
    }
    
    public function getResourceForACL(){
        return "User Account"; 
    }
    
	public function editAction() {
    	$this->_setParam("action", ACTION_EDIT);
		// debugMessage($this->_getAllParams());
    	// exit();
    	$this->createAction();
    }
    
    public function listAction(){
    	$session = SessionWrapper::getInstance(); 
    	
    	if(isFarmGroupAdmin() && isEmptyString($this->_getParam('farmgroupid'))){
    		$user = new UserAccount();
    		$user->populate($session->getVar('userid'));
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl("profile/list/farmgroupid/".$user->getFarmGroupID()));	
    	}
    	// $this->listAction();
    }
    
	public function processaddAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$session = SessionWrapper::getInstance(); 
		// debugMessage($this->_getAllParams());
	}

	public function usernameAction() {
    	
    }
    
	public function addsuccessAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("farmer_add_success"));
    }
    
	public function adderrorAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    }
    
    public function validatephoneAction(){
    	
    }
    public function processvalidatephoneAction(){
    	$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		
		// debugMessage($formvalues);
		$successurl = decode($formvalues['successurl']);
		
		$user = new UserAccount();
		$user->populate($formvalues['userid']);
		
		// debugMessage($user->toArray()); exit();
		try {
			$user->generateActivationCode();
			$user->sendActivationCodeToMobile();
			$session->setVar(SUCCESS_MESSAGE, 'Validation code has been sent to the mobile phone. Please check Inbox and enter the code sent below to confirm.');
		} catch (Exception $e) {
			$session->setVar(ERROR_MESSAGE, 'An error occured in requesting activation for your Phone. Please contact support for resolution.');
		}
		
    	$this->_helper->redirector->gotoUrl($successurl);
    }
	public function validatephonesuccessAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$session->setVar(SUCCESS_MESSAGE, 'Validation code has been sent to the mobile phone. Please check Inbox and enter the code sent below to confirm.');
    }
	public function verifyphoneAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$successurl = decode($formvalues['successurl']);
		// debugMessage($formvalues);
		// debugMessage($successurl);
		
		$user = new UserAccount();
		$user->populate($formvalues['userid']);
		// debugMessage($user->toArray()); exit();
		if($user->verifyPhone($formvalues['code'])){
			$user->activate();
			$user->sendActivationConfirmationToMobile();
			$session->setVar(SUCCESS_MESSAGE, 'Phone Number Successfully Verified and Confirmed');
			$session->setVar(ERROR_MESSAGE, '');
		} else {
			$session->setVar(SUCCESS_MESSAGE, '');
			$session->setVar(ERROR_MESSAGE, 'Invalid activation code specified. Please try again. ');
		}
		
		// exit();
		// return to successpage
		$this->_helper->redirector->gotoUrl($successurl);
    }
    
	public function pictureAction() {}
	
	public function processpictureAction() {
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		
	    $session = SessionWrapper::getInstance(); 	
	    $config = Zend_Registry::get("config");
	    $this->_translate = Zend_Registry::get("translate"); 
		
	    $formvalues = $this->_getAllParams();
	    $type = $formvalues['type'];
	    
		// debugMessage($this->_getAllParams()); exit();
		$user = new UserAccount();
		$user->populate(decode($this->_getParam('id')));
		
		// only upload a file if the attachment field is specified		
		$upload = new Zend_File_Transfer();
		// set the file size in bytes
		$upload->setOptions(array('useByteString' => false));
		
		// Limit the extensions to the specified file extensions
		$upload->addValidator('Extension', false, $config->profilephoto->allowedformats);
	 	$upload->addValidator('Size', false, $config->profilephoto->maximumfilesize);
		
		// base path for profile pictures
 		$destination_path = APPLICATION_PATH.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user_";
	
		// determine if user has destination avatar folder. Else user is editing there picture
		if(!is_dir($destination_path.$user->getID())){
			// no folder exits. Create the folder
			mkdir($destination_path.$user->getID(), 0755);
		} 
		
		// set the destination path for the image
		$profilefolder = $user->getID();
		if($type == 'photo'){
			$destination_path = $destination_path.$profilefolder.DIRECTORY_SEPARATOR."avatar";
		}
		if($type == 'sign'){
			$destination_path = $destination_path.$profilefolder.DIRECTORY_SEPARATOR."sign";
		}
		if(!is_dir($destination_path)){
			mkdir($destination_path, 0755);
		}
		// create archive folder for each user
		$archivefolder = $destination_path.DIRECTORY_SEPARATOR."archive";
		if(!is_dir($archivefolder)){
			mkdir($archivefolder, 0755);
		}
		
		if($type == 'photo'){
			$oldfilename = $user->getProfilePhoto();
		}
		if($type == 'sign'){
			$oldfilename = $user->getSignature();
		}
		//debugMessage($destination_path); 
		$upload->setDestination($destination_path);
		
		// the profile image info before upload
		$file = $upload->getFileInfo('profileimage');
		$uploadedext = findExtension($file['profileimage']['name']);
		$currenttime = mktime();
		$currenttime_file = $currenttime.'.'.$uploadedext;
		// debugMessage($file);
		
		$thefilename = $destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime_file;
		$thelargefilename = $destination_path.DIRECTORY_SEPARATOR.'large_'.$currenttime_file;
		$updateablefile = $destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime;
		$updateablelarge = $destination_path.DIRECTORY_SEPARATOR.'large_'.$currenttime;
		
		// rename the base image file 
		$upload->addFilter('Rename',  array('target' => $thefilename, 'overwrite' => true));		
		// exit();
		// process the file upload
		if($upload->receive()){
			// debugMessage('Completed');
			$file = $upload->getFileInfo('profileimage');
			// debugMessage($file);
			
			$basefile = $thefilename;
			// convert png to jpg
			if(in_array(strtolower($uploadedext), array('png','PNG','gif','GIF'))){
				ak_img_convert_to_jpg($thefilename, $updateablefile.'.jpg', $uploadedext);
				unlink($thefilename);
			}
			$basefile = $updateablefile.'.jpg';
			
			// new profilenames
			$newlargefilename = "large_".$currenttime_file;
			// generate and save thumbnails for sizes 250, 125 and 50 pixels
			resizeImage($basefile, $destination_path.DIRECTORY_SEPARATOR.'large_'.$currenttime.'.jpg', 400);
			if($type == 'photo'){
				resizeImage($basefile, $destination_path.DIRECTORY_SEPARATOR.'medium_'.$currenttime.'.jpg', 165);
			}
			// unlink($thefilename);
			unlink($destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime.'.jpg');
			
			// exit();
			// update the useraccount with the new profile images
			try {
				if($type == 'photo'){
					$user->setProfilePhoto($currenttime.'.jpg');
				}
				if($type == 'sign'){
					$user->setSignature($currenttime.'.jpg');
				}
				$user->save();
				
				// check if user already has profile picture and archive it
				if($type == 'photo'){
					$ftimestamp = current(explode('.', $user->getProfilePhoto()));
				}
				if($type == 'sign'){
					$ftimestamp = current(explode('.', $user->getSignature()));
				}
				
				$allfiles = glob($destination_path.DIRECTORY_SEPARATOR.'*.*');
				$currentfiles = glob($destination_path.DIRECTORY_SEPARATOR.'*'.$ftimestamp.'*.*');
				// debugMessage($currentfiles);
				$deletearray = array();
				foreach ($allfiles as $value) {
					if(!in_array($value, $currentfiles)){
						$deletearray[] = $value;
					}
				}
				// debugMessage($deletearray);
				if(count($deletearray) > 0){
					foreach ($deletearray as $afile){
						$afile_filename = basename($afile);
						rename($afile, $archivefolder.DIRECTORY_SEPARATOR.$afile_filename);
					}
				}
				
				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("farmer_update_success"));
				$this->_helper->redirector->gotoUrl($this->view->baseUrl("profile/picture/id/".encode($user->getID()).'/crop/1/type/'.$type));
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
				$session->setVar(FORM_VALUES, $this->_getAllParams());
				$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/picture/id/'.encode($user->getID()).'/type/'.$type));
			}
		} else {
			// debugMessage($upload->getMessages());
			$uploaderrors = $upload->getMessages();
			$customerrors = array();
			if(!isArrayKeyAnEmptyString('fileUploadErrorNoFile', $uploaderrors)){
				$customerrors['fileUploadErrorNoFile'] = "Please browse for image on computer";
			}
			if(!isArrayKeyAnEmptyString('fileExtensionFalse', $uploaderrors)){
				$custom_exterr = sprintf($this->_translate->translate('upload_invalid_ext_error'), $config->profilephoto->allowedformats);
				$customerrors['fileExtensionFalse'] = $custom_exterr;
			}
			if(!isArrayKeyAnEmptyString('fileUploadErrorIniSize', $uploaderrors)){
				$custom_exterr = sprintf($this->_translate->translate('upload_invalid_size_error'), formatBytes($config->profilephoto->maximumfilesize,0));
				$customerrors['fileUploadErrorIniSize'] = $custom_exterr;
			}
			if(!isArrayKeyAnEmptyString('fileSizeTooBig', $uploaderrors)){
				$custom_exterr = sprintf($this->_translate->translate('upload_invalid_size_error'), formatBytes($config->profilephoto->maximumfilesize,0));
				$customerrors['fileSizeTooBig'] = $custom_exterr;
			}
			$session->setVar(ERROR_MESSAGE, 'The following errors occured <ul><li>'.implode('</li><li>', $customerrors).'</li></ul>');
			$session->setVar(FORM_VALUES, $this->_getAllParams());
			
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/picture/id/'.encode($user->getID()).'/type/'.$type));
		}
		// exit();
	}
	
	function croppictureAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$type = $formvalues['type'];
		
		$user = new UserAccount();
		$user->populate(decode($formvalues['id']));
		$userfolder = $user->getID();
		// debugMessage($formvalues);
		//debugMessage($user->toArray());
		
		if($type == 'photo'){
			$oldfile = "large_".$user->getProfilePhoto();
			$base = APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.PUBLICFOLDER.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'user_'.$userfolder.''.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR;
		}
		if($type == 'sign'){
			$oldfile = "large_".$user->getSignature();
			$base = APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.PUBLICFOLDER.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'user_'.$userfolder.''.DIRECTORY_SEPARATOR.'sign'.DIRECTORY_SEPARATOR;
		}
		// debugMessage($user->toArray()); 
		$src = $base.$oldfile;
		
		$currenttime = mktime();
		$currenttime_file = $currenttime.'.jpg';
		$newlargefilename = $base."large_".$currenttime_file;
		$newmediumfilename = $base."medium_".$currenttime_file;
		$newthumbnailfilename = $base."thumbnail_".$currenttime_file;
		$newsmallfilename = $base."small_".$currenttime_file;
		
		// exit();
		$image = WideImage::load($src);
		if($type == 'photo'){
			$cropped1 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
			$resized_1 = $cropped1->resize(300, 300, 'fill');
			$resized_1->saveToFile($newlargefilename);
			
			//$image2 = WideImage::load($src);
			$cropped2 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
			$resized_2 = $cropped2->resize(165, 165, 'fill');
			$resized_2->saveToFile($newmediumfilename);
			
			//$image3 = WideImage::load($src);
			$cropped3 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
			$resized_3 = $cropped3->resize(65, 65, 'fill');
			$resized_3->saveToFile($newthumbnailfilename);
			
			//$image4 = WideImage::load($src);
			$cropped4 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
			$resized_4 = $cropped4->resize(45, 45, 'fill');
			$resized_4->saveToFile($newsmallfilename);
			
			$user->setProfilePhoto($currenttime_file);
		}
		if($type == 'sign'){
			$cropped1 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
			$resized_1 = $cropped1->resize(180, 90, 'fill');
			$resized_1->saveToFile($newthumbnailfilename);
			
			//$image2 = WideImage::load($src);
			$cropped2 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
			$resized_2 = $cropped2->resize(300, 150, 'fill');
			$resized_2->saveToFile($newlargefilename);
			
			$user->setSignature($currenttime_file);
		}
		
		$user->save();
			
		// check if user already has profile picture and archive it
		if($type == 'photo'){
			$ftimestamp = current(explode('.', $user->getProfilePhoto()));
		}
		if($type == 'sign'){
			$ftimestamp = current(explode('.', $user->getSignature()));
		}
		$allfiles = glob($base.DIRECTORY_SEPARATOR.'*.*');
		$currentfiles = glob($base.DIRECTORY_SEPARATOR.'*'.$ftimestamp.'*.*');
		// debugMessage($currentfiles);
		$deletearray = array();
		foreach ($allfiles as $value) {
			if(!in_array($value, $currentfiles)){
				$deletearray[] = $value;
			}
		}
		// debugMessage($deletearray);
		if(count($deletearray) > 0){
			foreach ($deletearray as $afile){
				$afile_filename = basename($afile);
				rename($afile, $base.DIRECTORY_SEPARATOR.'archive'.DIRECTORY_SEPARATOR.$afile_filename);
			}
		}
		if($type == 'photo'){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID())));
		}
		if($type == 'sign'){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID()).'/tab/personal'));
		}	
		// exit();
    }
    
	function gpsAction(){
    	$this->_helper->layout->disableLayout();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		
		// $formvalues = $this->_getAllParams();
		// debugMessage($formvalues);
		$user = new UserAccount();
		$user->populate(44);
		
		// debugMessage($user->toArray()); 	
		// $user->afterSave();
    }
    
	# Send notification to invite a friend
	function tellFriendsAboutFARMIS($dataarray) {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View(); 
		
		$first = $dataarray[0];
		
		// assign values
		$template->assign('sendername', $first['sendername']);
		$mail->setSubject($first['subject']);
		// set the send of the email address
		$mail->setFrom($first['senderemail'], $first['sendername']);
		
		// set the subject for the different participants and check that user can receive email
		foreach($dataarray as $key => $line) {
			$template->assign('themessage', $line['message']);
			
			// the actual url will be built in the view
			// $viewurl = $template->serverUrl($template->baseUrl('annnouncement')); 
			// $template->assign('detailslink', $viewurl);
			$mail->addTo($line['email']);
			$mail->setBodyHtml($template->render('emailfriendsnotification.phtml'));
			// debugMessage($template->render('emailfriendsnotification.phtml'));
			
			$mail->send();
			// clear body and recipient in each email
			$mail->clearRecipients();
			$mail->setBodyHtml('');
		}
		
		return true;
	}
	# Send contact us notification
	function sendContactNotification($dataarray) {
		$template = new EmailTemplate(); 
		# create mail object
		$mail = getMailInstance();
		$view = new Zend_View(); 
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		
		// debugMessage($first);
		// assign values
		$template->assign('name', $dataarray['name']);
		$template->assign('email', $dataarray['email']);
		$template->assign('subject', $dataarray['subject']);
		$template->assign('message', nl2br($dataarray['message']));
		
		$mail->setSubject("FARMIS: ".$dataarray['subject']);
		// set the send of the email address
		$mail->setFrom($dataarray['email'], $dataarray['name']);
		
		// configure base stuff
		$mail->addTo($this->config->notification->supportemailaddress);
		// render the view as the body of the email
		$mail->setBodyHtml($template->render('contactconfirmation.phtml'));
		// debugMessage($template->render('contactconfirmation.phtml')); //exit();
		$mail->send();
		
		$mail->clearRecipients();
		$mail->clearSubject();
		$mail->setBodyHtml('');
		$mail->clearFrom();
		
		return true;
	}
	
	public function inviteAction(){
    	
    }
    
    public function inviteoneAction(){
    	$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$id = $this->_getParam('id');
		$mail = $this->_getParam('email');
		$user = new UserAccount();
		$user->populate($id);
		// set the new email
		$user->setEmail($mail);
		$user->setInvitedByID($session->getVar('userid'));
		// debugMessage($user->toArray()); exit();
		
		# validate the email provided
		if($user->emailExists($mail)){
			echo '<div class="alert alert-error"><a class="close" data-dismiss="alert"></a>'.sprintf($this->_translate->translate("useraccount_email_unique_error"), $mail).'</div>';
		} else {
			try {
				$user->inviteOne();
				echo '<div class="alert alert-success"><a class="close" data-dismiss="alert"></a>'.$this->_translate->translate("farmer_invite_success").'</div>';
			} catch (Exception $e) {
				echo '<div class="alert alert-error"><a class="close" data-dismiss="alert"></a>'.$e->getMessage().'</div>';
			}
		}
    }
    
	public function inviteonebyphoneAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$id = $this->_getParam('id');
		$phone = $this->_getParam('phone');
		$user = new UserAccount();
		$user->populate($id);
		//debugMessage($phone);
		//debugMessage($user->toArray());
		# validate the email provided
		if($user->phoneExists(getFullPhone($phone))) {
			//debugMessage('exists');
			echo '<div class="alert alert-error"><a class="close" data-dismiss="alert"></a>'.sprintf($this->_translate->translate("useraccount_phone_unique_error"), $phone).'</div>';
		} else {
			try {
				$user->setPhone(getFullPhone($phone));
				$user->setInvitedByID($session->getVar('userid'));
				//debugMessage('no error');
				$user->inviteOneByPhone();
				echo '<div class="alert alert-success"><a class="close" data-dismiss="alert"></a>'.$this->_translate->translate("farmer_invite_success").'</div>';
			} catch (Exception $e) {
				echo '<div class="alert alert-error"><a class="close" data-dismiss="alert"></a>'.$e->getMessage().'</div>';
			}
		}
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
    
    function reportAction(){
    	
    }
    
	public function changesettingsAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$session = SessionWrapper::getInstance(); 
		// debugMessage($formvalues);
		
		$user = new UserAccount();
		$user->populate($formvalues['userid']);
		// debugMessage($user->toArray());
		switch ($formvalues['field']) {
			case 'emailmeonmessage':
				$user->setemailmeonmessage($formvalues['value']);
				$user->save();
				break;
			case 'emailmeoncomment':
				$user->setemailmeoncomment($formvalues['value']);
				$user->save();
				break;
			default:
				break;
		}
	}
	
    function changepasswordAction()  {
    	
    }
    
    function processchangepasswordAction(){
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate"); 
    	if(!isEmptyString($this->_getParam('password'))){
	        $user = new UserAccount(); 
	    	$user->populate(decode($this->_getParam('id')));
	    	// debugMessage($user->toArray());
	    	# Change password
	    	$user->changePassword($this->_getParam('oldpassword'), $this->_getParam('password'));
	    		// clear the session
	   			// send a link to enable the user to recover their password 
	   		$this->_redirect($this->view->baseUrl('index/updatesuccess'));
		}
    }
    function changeusernameAction()  {
    	
    }
	function processchangeusernameAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate");
        $formvalues = $this->_getAllParams();
        
    	if(!isArrayKeyAnEmptyString('username', $formvalues)){
	        $user = new UserAccount(); 
	    	$user->populate(decode($formvalues['id']));
	    	// debugMessage($user->toArray());
	    	
	    	if($user->usernameExists($formvalues['username'])){
	    		$session->setVar(ERROR_MESSAGE, sprintf($this->_translate->translate("useraccount_username_unique_error"), $formvalues['username']));
	    		return false;
	    	}
	    	# save new username
	    	$user->setUsername($formvalues['username']);
	    	$user->save();
	   		$this->_redirect($this->view->baseUrl('index/updatesuccess'));
		}
    }
    
	function changeemailAction()  {
		$session = SessionWrapper::getInstance(); 
		
		$formvalues = $this->_getAllParams();
		if(!isArrayKeyAnEmptyString('actkey', $formvalues) && !isArrayKeyAnEmptyString('ref', $formvalues)){
        	$newemail = decode($formvalues['ref']);
		
			$user = new UserAccount();
			$user->populate(decode($formvalues['id']));
			$oldemail = $user->getEmail();
			
			# validate the activation code
			if($formvalues['actkey'] != $user->getActivationKey()){
				$session->setVar(ERROR_MESSAGE, "Invalid code specified for email activation");
				$failureurl = $this->view->baseUrl('profile/view/id/'.encode($user->getID()).'/tab/account');
				$this->_helper->redirector->gotoUrl($failureurl);
			}
			
			$user->setActivationKey('');
			$user->setEmail($newemail);
			$user->setEmail2(''); 
			$user->save();

			$successmessage = "Successfully updated. Please note that you can no longer login using your previous Email Address";
	    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
	   		$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID()).'/tab/account'));
        }
    }
	function processchangeemailAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate");
        $formvalues = $this->_getAllParams();
         
        if(!isArrayKeyAnEmptyString('email', $formvalues)){
	        $user = new UserAccount(); 
	    	$user->populate(decode($formvalues['id']));
	    	if($user->emailExists($formvalues['email'])){
	    		$session->setVar(ERROR_MESSAGE, sprintf($this->_translate->translate("useraccount_email_unique_error"), $formvalues['email']));
	    		return false;
	    	}
	    	# save new username
	    	$user->setEmail2($formvalues['email']);
	    	$user->setActivationKey($user->generateActivationKey());
	    	$user->save();
	    	
	    	$user->sendNewEmailNotification($formvalues['email']);
    		$user->sendOldEmailNotification($formvalues['email']);
	    	$successmessage = "A request to change your login email has been recieved. <br />To complete this process check your Inbox to confirm this request.";
	   		$this->_redirect($this->view->baseUrl('index/updatesuccess/successmessage/'.encode($successmessage)));
		}
    }
    
	function changephoneAction()  {
		$session = SessionWrapper::getInstance(); 
		
		$formvalues = $this->_getAllParams();
		if(!isArrayKeyAnEmptyString('actkey', $formvalues) && !isArrayKeyAnEmptyString('ref', $formvalues)){
        	$newphone = decode($formvalues['ref']);
		
			$user = new UserAccount();
			$user->populate(decode($formvalues['id']));
			$oldphone = $user->getPhone();
			$newprimary = $user->getPhone2();
			
			# validate the activation code
			if($formvalues['actkey'] != $user->getPhone2_ActKey()){
				$session->setVar(ERROR_MESSAGE, "Invalid code specified for phone activation");
				$failureurl = $this->view->baseUrl('profile/view/id/'.encode($user->getID()).'/tab/account');
				$this->_helper->redirector->gotoUrl($failureurl);
			}
			
			$user->setPhone($newprimary);
			$user->setPhone2($oldphone);
			$user->setPhone2_ActKey('');
			$user->setPhone2_IsActivated(1);
			$user->save();
			
	    	$successmessage = "Successfully updated. Please note that you can no longer login using your previous primary phone";
	    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
	   		$this->_helper->redirector->gotoUrl($this->view->baseUrl('profile/view/id/'.encode($user->getID()).'/tab/account'));
        }
    }
	function processchangephoneAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $this->_translate = Zend_Registry::get("translate");
        $formvalues = $this->_getAllParams();
         
        if(!isArrayKeyAnEmptyString('phone', $formvalues)){
	        $user = new UserAccount(); 
	    	$user->populate(decode($formvalues['id']));
	    	
			// debugMessage($formvalues);
	    	
	    	if($formvalues['phone'] == getShortPhone($user->getPhone2()) && $user->isValidated(2)){
		    	try {
		    		$user->setPhone(getFullPhone($formvalues['phone']));
		    		$user->setPhone2(getFullPhone($formvalues['oldphone']));
		    		$user->save();
		    	} catch (Exception $e) {
		    		debugMessage($e->getMessage());
		    	}
	    		
				$successmessage = "Successfully updated. Please note that you can no longer login using your previous primary phone";
		    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
	    	} else {
	    		if($user->phoneExists($formvalues['phone'])){
		    		$session->setVar(ERROR_MESSAGE, sprintf($this->_translate->translate("useraccount_phone_unique_error"), $formvalues['phone']));
		    		return false;
		    	}
		    	# save new phone
		    	$user->setPhone2(getFullPhone($formvalues['phone']));
		    	$user->setPhone2_isActivated(0);
		    	$user->generatePhoneActivationCode(2);
		    	// $user->save(); 
		    	
		    	// $user->sendNewEmailNotification($formvalues['email']);
	    		// $user->sendOldEmailNotification($formvalues['email']);
		    	$successmessage = "A request to change your primary phone has been recieved. <br />To complete this process check your phone inbox for your confirmation code.";
		   		$this->_redirect($this->view->baseUrl('index/updatesuccess/successmessage/'.encode($successmessage)));
	    	}
		}
    }
    
	function resendemailcodeAction()  {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
    	$session = SessionWrapper::getInstance(); 
        $formvalues = $this->_getAllParams();
         
        $user = new UserAccount(); 
    	$user->populate(decode($formvalues['id']));
    	// debugMessage($user->toArray());
    	
    	$session->setVar('contactuslink', "<a href='".$this->view->baseUrl('contactus')."' title='Contact Farmis Support'>Contact us</a>");
    	$user->sendNewEmailNotification($user->getEmail2());
    	$successmessage = "A new activation code has been sent to your new email address. If you are still having any problems please do contact us";
    	$session->setVar(SUCCESS_MESSAGE, $successmessage);
   		$this->_redirect($this->view->baseUrl('profile/view/id/'.encode($user->getID()).'/tab/account'));
    }
    
    function resetpasswordAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
	   	$session = SessionWrapper::getInstance(); 
       	$this->_translate = Zend_Registry::get("translate"); 
       		
		$user = new UserAccount(); 
		$user->populate(decode($this->_getParam('id')));
    	$user->setEmail($user->getEmail());
    	
    	// debugMessage($user->toArray()); exit();
    	if ($user->recoverPassword()) {
       		$session->setVar(SUCCESS_MESSAGE, sprintf($this->_translate->translate('useraccount_change_password_admin_confirmation'), $user->getName()));
   			// send a link to enable the user to recover their password 
    	} else {
   			$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString());
   			$session->setVar(FORM_VALUES, $this->_getAllParams());
    	}
    	$this->_helper->redirector->gotoUrl($this->view->baseUrl("profile/view/id/".encode($user->getID())."/tab/account"));
   	}
   	
	public function dashupdateAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$session = SessionWrapper::getInstance(); 
		// debugMessage($formvalues);
		
		$user = new UserAccount();
		$user->populate($formvalues['id']);
		switch ($formvalues['area']) {
			case 'welcome':
				$user->setDashWelcome(0);
				break;
			case 'wizard':
				$user->setDashWizard(0);
				break;
			default:
				break;
		}
		
		$user->save();
		
		// debugMessage($user->toArray());
		$this->_helper->redirector->gotoUrl($this->view->baseUrl("dashboard"));
		// exit();
	}
    public function addcropAction(){
		/*$farmcrop = new FarmCrop();
		debugMessage($farmcrop->toArray());
		exit();*/
    }
    
	public function processaddcropAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance(); 
		$formvalues = $this->_getAllParams();
		
		// debugMessage($formvalues);
		$post_data = array();
		foreach ($formvalues['cropids'] as $key => $value){
			$post_data[$key]['cropid'] = $value;
			$post_data[$key]['userid'] = $formvalues['userid'];
		}
		// debugMessage($post_data); 
		$crop_collection = new Doctrine_Collection(Doctrine_Core::getTable("FarmCrop"));
		foreach ($post_data as $thedata){
			$farmcrop = new FarmCrop();
			$farmcrop->processPost($thedata);
			if($farmcrop->isValid()) {
				$crop_collection->add($farmcrop);
			}
		}
		// debugMessage($crop_collection->toArray()); exit();
		# save the crops
		if($crop_collection->count() > 0){
			$crop_collection->save();
			foreach ($crop_collection as $crop){
				$crop->afterSave();
			}
		}
		
		$session->setVar(SUCCESS_MESSAGE, "Crop(s) Successfully added");
		$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS))); 
    }
    
	public function addcropsuccessAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$session->setVar(SUCCESS_MESSAGE, "Crop(s) Successfully added");
    	// echo '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.$this->_translate->translate("farmer_invite_success").'</div>';
    }
    
	public function processgpsAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$session = SessionWrapper::getInstance(); 	
	    $config = Zend_Registry::get("config");
	    $this->_translate = Zend_Registry::get("translate");
	    $formvalues = $this->_getAllParams();
	    $formvalues['id'] =  decode($formvalues['id']);
	    
	    debugMessage($formvalues);
	    $user = new UserAccount();
	    $user->populate($formvalues['id']);
	    
	    $user->setLat($formvalues['lat']);
	    $user->setLng($formvalues['lng']);
	    // debugMessage($user->toArray());
	    // $user->processPost($formvalues);
	    debugMessage($user->toArray());
	    debugMessage('error is '.$user->getErrorStackAsString());
	    
	    // exit();
	    try {
	    	$user->save();
	    	$session->setVar(SUCCESS_MESSAGE, "Location successfully saved");
	    	$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
	    } catch (Exception $e) {
	    	$session->setVar(ERROR_MESSAGE, $e->getMessage()); 
	    	$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
	    }
	}
	
	function usersAction(){
		$session = SessionWrapper::getInstance();
		
		parent::listAction();
	}
	function userssearchAction(){
		$formvalues = $this->_getAllParams();
    	// debugMessage($formvalues); exit();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_helper->redirector->gotoSimple('users', 'profile', 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function eventsAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		
		$user = new UserAccount();
		$user->populate($formvalues['id']);
		$seasons = $user->getOrderedSeasons();
		$jsondata = array();
		$i = 0;
			
		foreach ($seasons as $season){
			$timeline = sort_multi_array($season->getTimeLineDetails(), 'order');
			$acount = count($timeline);
			
			// debugMessage($timeline);
			foreach($timeline as $key => $activity){
				$jsondata[$i]['id'] = $i;
				$jsondata[$i]['seasonref'] = $season->getRef();
				$jsondata[$i]['title'] = $activity['title'];
				$jsondata[$i]['start'] = $activity['startdate'];
				$jsondata[$i]['formatedstart'] = changeMySQLDateToPageFormat($activity['startdate']);
				if(!isEmptyString($activity['enddate'])){
					$jsondata[$i]['end'] = $activity['enddate'];
					$jsondata[$i]['formatedend'] = changeMySQLDateToPageFormat($activity['enddate']);	
				}
				$jsondata[$i]['url'] = $activity['url'];
				$jsondata[$i]['className'] = $activity['uniqueid'];
				$jsondata[$i]['description'] = $activity['description'];
				$jsondata[$i]['type'] = $activity['type'];
				$jsondata[$i]['url'] = $activity['url'];
				$jsondata[$i]['editurl'] = $activity['editurl'];
				$jsondata[$i]['status'] = $activity['status'];
				$jsondata[$i]['expenses'] = $activity['expenses'];
				$i++;
			}
		}
		
		// debugMessage($jsondata);
		echo json_encode($jsondata); 
	}
}
