<?php

class MobileController extends IndexController  {
	
	function indexAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/home"));
	}
	
	function farmerAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	
	function createAction(){
		$session = SessionWrapper::getInstance();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_translate = Zend_Registry::get("translate"); 
		
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		$this->_setParam('action', 'create');
		if(!isEmptyString($this->_getParam('id'))){
			$this->_setParam('action', 'edit');
		}
		
		$formvalues = $this->_getAllParams();
		$formvalues['createdby'] = $session->getVar('userid');
		
		$password = '';
		if(!isEmptyString($this->_getParam('password')) && $this->_getParam('adminactivate') == '1'){
			$password = $formvalues['password'];
		}
		// debugMessage($formvalues);
		
		$user = new UserAccount();
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$id = $formvalues['id'] = decode($formvalues['id']);
			$user->populate($id);
		}
		$user->processPost($formvalues);
		/*debugMessage($user->toArray());
		debugMessage('error is '.$user->getErrorStackAsString()); // exit();*/
		
		if($user->hasError()){
			$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString());
			$session->setVar(FORM_VALUES, $formvalues);
			$url = $this->view->baseUrl("mobile/farmer/id/".encode($user->getID()));
			if($formvalues['adminactivate'] == 1){
				$url = $this->view->baseUrl("mobile/farmer/id/".encode($user->getID())."/type/other");
			}
			if($this->_getParam('regsource') == 1){
				$this->_helper->redirector->gotoUrl($url);
			}
		}
		// exit();
		try {
			$session->setVar(ERROR_MESSAGE, '');
			$user->beforeSave();
			$user->clearRelated('farmer');
			// debugMessage($user->toArray());
			$user->save();
			
			if($this->_getParam('action') == 'create'){
				$user->afterSave();
				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("farmer_add_success"));
			}
			if($this->_getParam('action') == 'edit'){
				$user->afterUpdate();
				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("farmer_update_success"));
			}
			// invite the farmer to activate via email
			if($this->_getParam('isinvited') == 1 && !isEmptyString($this->_getParam('email'))){
				$user->inviteOne();
				$session->setVar('emailinvitesuccess', sprintf($this->_translate->translate("farmer_invite_email_success"), $user->getEmail()));
			}
			// invite the farmer to activate via phone
			if($this->_getParam('isphoneinvited') == 1 && !isEmptyString($this->_getParam('phone'))){
				$user->inviteOneByPhone();
				$session->setVar('phoneinvitesuccess', sprintf($this->_translate->translate("farmer_invite_phone_success"), $user->getFormattedPhone()));
			}
			# send credentials to email 
			if($this->_getParam('sendlogintoemail') == 1 && !isEmptyString($this->_getParam('email'))){
				$user->sendCredentialsByEmail($password);
				$session->setVar('emailinvitesuccess', sprintf($this->_translate->translate("farmer_login_email_success"), $user->getEmail()));
			}
			
			# send credentials to phone
			if($this->_getParam('sendlogintophone') == 1 && !isEmptyString($this->_getParam('phone')) && !isEmptyString($password)){
				$user->sendCredentialsByPhone($password);
				$session->setVar('phoneinvitesuccess', sprintf($this->_translate->translate("farmer_login_phone_success"), $user->getFormattedPhone()));
			}
			
			$url = $this->view->baseUrl("mobile/view/id/".encode($user->getID()));
			// debugMessage($user->toArray());
		} catch (Exception $e) {
			$error = $e->getMessage().$user->getErrorStackAsString();
			$session->setVar(ERROR_MESSAGE, $error);
			$session->setVar(FORM_VALUES, $formvalues);
			$url = $this->view->baseUrl("mobile/farmer/id/".encode($user->getID()));
			if($this->_getParam('adminactivate') == 1){
				$url = $this->view->baseUrl("mobile/farmer/id/".encode($user->getID())."/type/other");
			}
		}
		/*debugMessage('source is '.$this->_getParam('regsource'));
		debugMessage($session->getVar(ERROR_MESSAGE));
		debugMessage($url); exit();*/
		if($this->_getParam('regsource') == 1){
			$this->_helper->redirector->gotoUrl($url);
		}
	}
	
	function viewAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		parent::viewAction();
	}
	
	function editAction() {
		$this->createAction();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	
	function listAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		if(isEmptyString($this->_getParam('farmgroupid')) && isFarmGroupAdmin()){
			$user = new UserAccount();
			$user->populate($session->getVar('userid'));
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/list/farmgroupid/".$user->getFarmGroupID()));
		}
		parent::listAction();
	}
	function listsearchAction(){
		$this->_helper->layout->disableLayout();
		$formvalues = $this->_getAllParams();
    	// debugMessage($formvalues); exit();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_helper->redirector->gotoSimple('list', 'mobile', 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function loginAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(!isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/home"));
		}
	}
	
    function logoutAction()  {
    	$this->clearSession();
        // redirect to the login page 
        $this->_helper->redirector("login", "mobile");
    }
    
	function homeAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	
	function signupAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString(!$session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/home"));
		}
	}
	
	function signupconfirmAction() {
		$this->_helper->layout->disableLayout();
		
	}
	
	function activateAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance(); 
		$formvalues = $this->_getAllParams();
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			// debugMessage($formvalues);
			$isphoneactivation = false;
			if(!isArrayKeyAnEmptyString('act_byphone', $formvalues)){
				// debugMessage('activated via phone');
				$isphoneactivation = true;
			}
			$user = new UserAccount(); 
			$user->populate(decode($formvalues['id'])); 
			// debugMessage($user->toArray()); 
			
			if ($user->isUserActive() && isEmptyString($user->getActivationKey())) {
				// account already activated 
	    		$session->setVar(ERROR_MESSAGE, 'Account is already activated. Please login.');
				if($user->getregsource() == 1){
					$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
				}
				$this->_helper->redirector->gotoUrl($this->view->baseUrl("user/login"));
			}
			
			// exit();
			$this->_setParam(URL_FAILURE, encode($this->view->baseUrl("signup/confirm/id/".encode($user->getID()))));
			if($user->getregsource() == 1){
				$this->_setParam(URL_FAILURE, encode($this->view->baseUrl("mobile/signupconfirm/id/".encode($user->getID()))));
			}
			$key = $this->_getParam('actkey');
			
			$this->view->result = $user->activateAccount($key, $isphoneactivation, false);
			if (!$this->view->result) {
				// activation failed
				$this->view->message = $user->getErrorStackAsString();
				$session->setVar(FORM_VALUES, $this->_getAllParams());
	    		$session->setVar(ERROR_MESSAGE, $user->getErrorStackAsString()); 
				$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
			}
		}
	}
	
	public function gpsAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
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
	    $user = new UserAccount();
	    $user->populate($formvalues['id']);
	    
	    $user->processPost($formvalues);
	    // debugMessage('error is '.$user->getErrorStackAsString());
	    // debugMessage($user->toArray());
	    
	    try {
	    	$user->save();
	    	$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_SUCCESS)));
	    } catch (Exception $e) {
	    	$session->setVar(ERROR_MESSAGE, $e->getMessage()); 
	    	$this->_helper->redirector->gotoUrl(decode($this->_getParam(URL_FAILURE)));
	    }
	}
	
	public function pictureAction() {
		$this->_helper->layout->disableLayout();
	}
	
	public function processpictureAction() {
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
				// $this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/picture/id/".encode($user->getID()).'/crop/1/type/'.$type));
				$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/view/id/".encode($user->getID())));
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
				$session->setVar(FORM_VALUES, $this->_getAllParams());
				$this->_helper->redirector->gotoUrl($this->view->baseUrl('mobile/picture/id/'.encode($user->getID()).'/type/'.$type));
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
			
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('mobile/picture/id/'.encode($user->getID()).'/type/'.$type));
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
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('mobile/view/id/'.encode($user->getID())));
		}
		if($type == 'sign'){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('mobile/view/id/'.encode($user->getID())));
		}	
		// exit();
    }
    function populategroupAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		// debugMessage($this->_getAllParams());
		$group = new FarmGroup();
		$group->populate($this->_getParam('id'));
		
		$resultarray = array(
    					'id' => $group->getID(),
						'name' => $group->getOrgName(),
						'districtid' => $group->getDistrictID(),
						'district' => $group->getDistrict()->getName(),
    				);
    	// debugMessage($resultarray);
		echo json_encode($resultarray);
    }
	function populatefarmerAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		// debugMessage($this->_getAllParams());
		$user = new UserAccount();
		$user->populate($this->_getParam('id'));
		
		$resultarray = array(
    					'id' => $user->getID(),
						'userid' => $user->getID(),
						'name' => $user->getName(),
						'farmgroupid' => $user->getFarmGroupID(),
						'subgroupid' => $user->getSubGroupID(),
						'phone' => $user->getFormattedPhone(),
						'email' => $user->getEmail(),
						'district' => $user->getLocationID()
						
    				);
    	// debugMessage($resultarray);
		echo json_encode($resultarray);
    }
    
	function usersAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		parent::listAction();
	}
	function userssearchAction(){
		$this->_helper->layout->disableLayout();
		$formvalues = $this->_getAllParams();
    	// debugMessage($formvalues); exit();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_helper->redirector->gotoSimple('users', 'mobile', 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	function groupsAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		parent::listAction();
	}
	function groupssearchAction(){
		$this->_helper->layout->disableLayout();
		$formvalues = $this->_getAllParams();
    	// debugMessage($formvalues); exit();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_helper->redirector->gotoSimple('groups', 'mobile', 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function addgroupAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	
	function createaddgroupAction(){
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate"); 
		
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		$this->_setParam('action', 'create');
		if(!isEmptyString($this->_getParam('id'))){
			$this->_setParam('action', 'edit');
		}
		parent::createAction();
	}
	function viewgroupAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		parent::viewAction();
	}
	
	function selectseasonAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	
	function addseasonAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	function createaddseasonAction(){
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate"); 
		
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		$this->_setParam('action', 'create');
		if(!isEmptyString($this->_getParam('id'))){
			$this->_setParam('action', 'edit');
		}
		parent::createAction();
	}
	function viewseasonAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		parent::viewAction();
	}
	function seasonsAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	function seasonssearchAction(){
		$this->_helper->layout->disableLayout();
		$formvalues = $this->_getAllParams();
    	// debugMessage($formvalues); exit();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_helper->redirector->gotoSimple('seasons', 'mobile', 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	function addseasoneventAction(){
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	function createseasoneventAction(){
		$session = SessionWrapper::getInstance();
		$this->_translate = Zend_Registry::get("translate"); 
		
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		$this->_setParam('action', 'create');
		if(!isEmptyString($this->_getParam('id'))){
			$this->_setParam('action', 'edit');
		}
		parent::createAction();
	}
	function viewseasoneventAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		parent::viewAction();
	}
	
	function expensesAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	function expensessearchAction(){
		$this->_helper->layout->disableLayout();
		$formvalues = $this->_getAllParams();
    	// debugMessage($formvalues); exit();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_helper->redirector->gotoSimple('expenses', 'mobile', 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function salesAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	function salessearchAction(){
		$this->_helper->layout->disableLayout();
		$formvalues = $this->_getAllParams();
    	// debugMessage($formvalues); exit();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_helper->redirector->gotoSimple('sales', 'mobile', 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	
	function addpaymentAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	function createaddpaymentAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance();
		$formvalues = $this->_getAllParams(); // debugMessage($formvalues);
		
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
		$this->_setParam('action', 'create');
		if(!isEmptyString($this->_getParam('id'))){
			$this->_setParam('action', 'edit');
		}
		
		$payment = new Payment();
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$id = $formvalues['id'] = decode($formvalues['id']);
			$payment->populate($id);
		}
		$payment->processPost($formvalues);
		/*debugMessage($payment->toArray());
		debugMessage('error is '.$payment->getErrorStackAsString()); exit();*/
		
		if($payment->hasError()){
			// debugMessage('Error: '.$user->getErrorStackAsString());
			$session->setVar(ERROR_MESSAGE, $payment->getErrorStackAsString());
			$session->setVar(FORM_VALUES, $formvalues);
			$url = $this->view->baseUrl("mobile/addpayment/id/".encode($payment->getID()));
			$this->_helper->redirector->gotoUrl($url);
		} 
		try {
			$payment->beforeSave();
			$payment->save();
			if($this->_getParam('action') == 'create'){
				$payment->afterSave();
				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("global_save_success"));
			}
			if($this->_getParam('action') == 'edit'){
				$payment->afterUpdate();
				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("global_update_success"));
			}
			
			# send confirmation to email 
			if($this->_getParam('sendconfirmationtoemail') == 1 && !isEmptyString($this->_getParam('email'))){
				$payment->sendSubscriptionConfirmationByEmail();
				$session->setVar('emailinvitesuccess', sprintf($this->_translate->translate("farmer_subscription_email_success"), $payment->getUser()->getEmail()));
			}
			
			# send credentials to phone
			if($this->_getParam('sendconfirmationtophone') == 1 && !isEmptyString($this->_getParam('phone'))){
				$payment->sendSubscriptionConfirmationByPhone();
				$session->setVar('phoneinvitesuccess', sprintf($this->_translate->translate("farmer_subscription_phone_success"), getShortPhone($payment->getUser()->getPhone())));
			}
			
			$url = $this->view->baseUrl("mobile/viewpayment/id/".encode($payment->getID()));
			// debugMessage($user->toArray());
		} catch (Exception $e) {
			$error = $e->getMessage()." - ".$payment->getErrorStackAsString();
			$session->setVar(ERROR_MESSAGE, $error);
			$session->setVar(FORM_VALUES, $formvalues);
			$url = $this->view->baseUrl("mobile/addpayment/id/".encode($payment->getID()));
			// debugMessage($error);
		}
		
		// debugMessage($url); exit();
		$this->_helper->redirector->gotoUrl($url);
		// exit();
	}
	function viewpaymentAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
		
	}
	function paymentsAction() {
		$this->_helper->layout->disableLayout();
		$session = SessionWrapper::getInstance();
		if(isEmptyString($session->getVar('userid'))){
			$this->_helper->redirector->gotoUrl($this->view->baseUrl("mobile/login"));
		}
	}
	function paymentssearchAction(){
		$this->_helper->layout->disableLayout();
		$formvalues = $this->_getAllParams();
    	// debugMessage($formvalues); exit();
		// $this->_helper->viewRenderer->setNoRender(TRUE);
		$this->_helper->redirector->gotoSimple('payments', 'mobile', 
    											$this->getRequest()->getModuleName(),
    											array_remove_empty(array_merge_maintain_keys($this->_getAllParams(), $this->getRequest()->getQuery())));
	}
	function selectchainAction() {
		// disable rendering of the view and layout so that we can just echo the AJAX output 
	    $this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);    
		$select_type = $this->_getParam(SELECT_CHAIN_TYPE); 
		
    	switch ($select_type) { 		
			case 'district_dnaprofiles':
				# get all the dna profiles in a district
				$result = getDNAsInDistrict($this->_getParam('locationid2'));
				$result = json_encode($result);			
				echo ($result);			
				break;
			case 'farmgroup_children':
				# get all the dna profiles in a district
				$result = getSubGroups($this->_getParam('farmgroupid'));
				$result = json_encode($result);			
				echo ($result);			
				break;
			case 'district_counties': 
				# get all the counties in a district
				$result = getCountiesInDistrict($this->_getParam('districtid'));
				$result = json_encode($result);			
				echo ($result);			
				break;		
			case 'county_subcounties': 
				# get all the subcounties in a county		
				$result = getSubcountiesInCounty($this->_getParam('countyid'));
				$result = json_encode($result);			
				echo ($result);			
				break;			
			case 'subcounty_parishes': 
				# get all the parishes in a subcounty		
				$result = getParishesInSubCounty($this->_getParam('subcountyid'));
				$result = json_encode($result);			
				echo ($result);			
				break;
			case 'parish_villages': 
				# get all the villages in a parish		
				$result = getVillagesInParishes($this->_getParam('parishid'));
				$result = json_encode($result);			
				echo ($result);			
				break;			
			default: 
				# get all the villages in a parishes			
				echo '';			
				break;
		}
	}
}

