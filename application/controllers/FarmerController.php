<?php
class FarmerController extends SecureController   {

    public function addAction(){}
    
    public function getActionforACL() {
        $action = strtolower($this->getRequest()->getActionName()); 
		if($action == "add" || $action == "other" || $action == "processother" || $action == "processadd" || 
			$action == "processvalidatephone" || $action == 'validatephone' || $action == 'changesettings') {
			return ACTION_CREATE; 
		}
    	if(
	    	$action == "username" || $action == "gps" || $action == "test" || $action == "search" || 
	    	$action == "addsuccess"  || $action == "adderror" ||
	    	$action == "invite" || $action == "inviteone" || $action == "inviteonebyphone" || $action == "invitemany" || 
	    	$action == "invitemanyconfirm" || $action == "invitefriends" || $action == "invitefriendsconfirm" || 
	    	$action == "picture" || $action == "processpicture" || $action == "croppicture" ||
	    	$action == "autosearch" || $action == "delete" || 
	    	$action == "delete" || $action == "privacy" || $action == "resetprivacy" || $action == "processadd" || 
	    	$action == "report" || $action == 'validatephonesuccess' || $action == 'verifyphone' || $action == 'dashupdate'
	    	 
    	) {
			return ACTION_VIEW; 
		}
		return parent::getActionforACL(); 
    }
    
    public function getResourceForACL(){
        return "Farmer"; 
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
    		$farmer = new Farmer();
    		$farmer->populate($session->getVar('farmerid'));
    		$this->_helper->redirector->gotoUrl($this->view->baseUrl("farmer/list/farmgroupid/".$farmer->getFarmGroupID()));	
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
		
		$userphone = new UserPhone();
		$userphone->populate($formvalues['userphoneid']);
		
		// debugMessage($userphone->toArray());
		try {
			$userphone->generateActivationCode();
			$userphone->sendActivationCodeToMobile();
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
		
		$userphone = new UserPhone();
		$userphone->populate($formvalues['userphoneid']);
		if($userphone->verifyPhone($formvalues['code'])){
			$userphone->activate();
			$userphone->sendActivationConfirmationToMobile();
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
		$farmer = new Farmer();
		$farmer->populate(decode($this->_getParam('id')));
		
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
		if(!is_dir($destination_path.$farmer->getUserID())){
			// no folder exits. Create the folder
			mkdir($destination_path.$farmer->getUserID(), 0755);
		} 
		
		// set the destination path for the image
		$profilefolder = $farmer->getUserID();
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
			$oldfilename = $farmer->getUser()->getProfilePhoto();
		}
		if($type == 'sign'){
			$oldfilename = $farmer->getSignature();
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
					$farmer->getUser()->setProfilePhoto($currenttime.'.jpg');
				}
				if($type == 'sign'){
					$farmer->setSignature($currenttime.'.jpg');
				}
				$farmer->save();
				
				// check if user already has profile picture and archive it
				if($type == 'photo'){
					$ftimestamp = current(explode('.', $farmer->getUser()->getProfilePhoto()));
				}
				if($type == 'sign'){
					$ftimestamp = current(explode('.', $farmer->getSignature()));
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
				$this->_helper->redirector->gotoUrl($this->view->baseUrl("farmer/picture/id/".encode($farmer->getID()).'/crop/1/type/'.$type));
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
				$session->setVar(FORM_VALUES, $this->_getAllParams());
				$this->_helper->redirector->gotoUrl($this->view->baseUrl('farmer/picture/id/'.encode($farmer->getID()).'/type/'.$type));
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
			
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('farmer/picture/id/'.encode($farmer->getID()).'/type/'.$type));
		}
		// exit();
	}
	
	function croppictureAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$type = $formvalues['type'];
		
		$farmer = new Farmer();
		$farmer->populate(decode($formvalues['id']));
		$userfolder = $farmer->getUserID();
		// debugMessage($formvalues);
		//debugMessage($farmer->toArray());
		
		if($type == 'photo'){
			$oldfile = "large_".$farmer->getUser()->getProfilePhoto();
			$base = APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.PUBLICFOLDER.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'user_'.$userfolder.''.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR;
		}
		if($type == 'sign'){
			$oldfile = "large_".$farmer->getSignature();
			$base = APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.PUBLICFOLDER.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'user_'.$userfolder.''.DIRECTORY_SEPARATOR.'sign'.DIRECTORY_SEPARATOR;
		}
		// debugMessage($farmer->toArray()); 
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
			
			$farmer->getUser()->setProfilePhoto($currenttime_file);
		}
		if($type == 'sign'){
			$cropped1 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
			$resized_1 = $cropped1->resize(180, 90, 'fill');
			$resized_1->saveToFile($newthumbnailfilename);
			
			//$image2 = WideImage::load($src);
			$cropped2 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
			$resized_2 = $cropped2->resize(300, 150, 'fill');
			$resized_2->saveToFile($newlargefilename);
			
			$farmer->setSignature($currenttime_file);
		}
		
		$farmer->save();
			
		// check if user already has profile picture and archive it
		if($type == 'photo'){
			$ftimestamp = current(explode('.', $farmer->getUser()->getProfilePhoto()));
		}
		if($type == 'sign'){
			$ftimestamp = current(explode('.', $farmer->getSignature()));
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
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('farmer/view/id/'.encode($farmer->getID())));
		}
		if($type == 'sign'){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('farmer/view/id/'.encode($farmer->getID()).'/tab/personal'));
		}	
		// exit();
    }
    
	function gpsAction(){
    	$this->_helper->layout->disableLayout();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		
		// $formvalues = $this->_getAllParams();
		// debugMessage($formvalues);
		$farmer = new Farmer();
		$farmer->populate(44);
		
		// debugMessage($farmer->toArray()); 	
		// $farmer->afterSave();
    }
    
	public function tempAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		
     	$formvalues = array(
     		"entityname" => "Farmer",
     	 	"controller" => 'farmer',
    		"action" => 'create',
     	 	"firstname" => "Jakas",
		    "failureurl" => "L2Zhcm1pcy9wdWJsaWMvZmFybWVyL2FkZC9mb2N1c2lkLw==",
		    "successurl" => "L2Zhcm1pcy9wdWJsaWMvZmFybWVyL2FkZHN1Y2Nlc3M=",
		    "lastname" => "Upaslas",
		    "gender" => 1,
		    "districtid" => 117,
		    "farmgroupid" => 48,
		    "email" => "test1@devmail.infomacorp.com",
		    "isinvited" => "0",
     		"id" => ""
     	);
     			
     	// debugMessage($formvalues);
     	$this->_setParam("entityname", $formvalues['entityname']);
     	$this->_setParam("controller", $formvalues['controller']);
     	$this->_setParam("action", $formvalues['action']);
     	$this->_setParam("firstname", $formvalues['firstname']);
     	$this->_setParam("failureurl", $formvalues['failureurl']);
     	$this->_setParam("successurl", $formvalues['successurl']);
     	$this->_setParam("lastname", $formvalues['lastname']);
     	$this->_setParam("gender", $formvalues['gender']);
     	$this->_setParam("districtid", $formvalues['districtid']);
     	$this->_setParam("email", $formvalues['email']);
     	$this->_setParam("isinvited", $formvalues['isinvited']);
     	$this->_setParam("id", $formvalues['isinvited']);
     	$this->_setParam("createdby", $session->getVar('userid'));
     	
     	//$farmer = new Farmer();
		//$farmer->populate(46);
		
		//debugMessage($farmer->toArray());
		parent::createAction();
		
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
		$farmer = new Farmer();
		$farmer->populate($id);
		// set the new email
		$farmer->setEmail($mail);
		$farmer->setInvitedByID($session->getVar('userid'));
		// debugMessage($farmer->toArray()); exit();
		
		# validate the email provided
		if($farmer->getUser()->emailExists($mail)){
			echo '<div class="alert alert-error"><a class="close" data-dismiss="alert"></a>'.sprintf($this->_translate->translate("useraccount_email_unique_error"), $mail).'</div>';
		} else {
			try {
				$farmer->inviteOne();
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
		$farmer = new Farmer();
		$farmer->populate($id);
		//debugMessage($phone);
		//debugMessage($farmer->toArray());
		# validate the email provided
		if($farmer->getUser()->phoneExists(getFullPhone($phone))) {
			//debugMessage('exists');
			echo '<div class="alert alert-error"><a class="close" data-dismiss="alert"></a>'.sprintf($this->_translate->translate("useraccount_phone_unique_error"), $phone).'</div>';
		} else {
			try {
				$farmer->getUser()->getPhones()->get(0)->setPhone(getFullPhone($phone));
				$farmer->setInvitedByID($session->getVar('userid'));
				//debugMessage('no error');
				$farmer->inviteOneByPhone();
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
		
		$farmer = new Farmer();
		$farmer->populate($formvalues['farmerid']);
		// debugMessage($farmer->toArray());
		switch ($formvalues['field']) {
			case 'emailmeonmessage':
				$farmer->getUser()->setemailmeonmessage($formvalues['value']);
				$farmer->getUser()->save();
				break;
			case 'emailmeoncomment':
				$farmer->getUser()->setemailmeoncomment($formvalues['value']);
				$farmer->getUser()->save();
				break;
			default:
				break;
		}
	}
	
}