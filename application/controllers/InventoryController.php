<?php

class InventoryController extends SecureController   {

    public function getActionforACL() {
        $action = strtolower($this->getRequest()->getActionName()); 
		if($action == "service" || $action == "servicecreate" || $action == "serviceview" 
		) {
			return ACTION_CREATE; 
		}
    	if($action == "picture" || $action == "processpicture" || $action == "croppicture" || $action == "addservicessuccess"
    		|| $action == "delete"
    	) {
			return ACTION_VIEW; 
		}
		return parent::getActionforACL(); 
    }
    
    public function getResourceForACL(){
        return "Farmer"; 
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
	    
		// debugMessage($formvalues);
		$inventory = new Inventory();
		$inventory->populate(decode($this->_getParam('id')));
		
		// only upload a file if the attachment field is specified		
		$upload = new Zend_File_Transfer();
		// set the file size in bytes
		$upload->setOptions(array('useByteString' => false));
		
		// Limit the extensions to the specified file extensions
		$upload->addValidator('Extension', false, $config->profilephoto->allowedformats);
	 	$upload->addValidator('Size', false, $config->profilephoto->maximumfilesize);
		
		// base path for profile pictures
	 	$destination_path = APPLICATION_PATH."/../public/uploads/user_".$inventory->getUserID()."/inventory";
		// determine if folder exists
		if(!is_dir($destination_path)){
			// no folder exits. Create the folder
			mkdir($destination_path, 0755);
		} 
		// determine if folder exists
		$destination_path = $destination_path.DIRECTORY_SEPARATOR."inventory_".$inventory->getID();
		if(!is_dir($destination_path)){
			mkdir($destination_path, 0755);
		}
		
		// create archive folder for each user
		$archivefolder = $destination_path.DIRECTORY_SEPARATOR."archive";
		if(!is_dir($archivefolder)){
			mkdir($archivefolder, 0755);
		}
		$oldfilename = $inventory->getPhoto();
		//debugMessage($destination_path); 
		$upload->setDestination($destination_path);
		
		// the profile image info before upload
		$file = $upload->getFileInfo('profileimage');
		$uploadedext = findExtension($file['profileimage']['name']);
		$currenttime = mktime();
		$currenttime_file = $currenttime.'.'.$uploadedext;
		// debugMessage($file);
		
		$thefilename = $destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime_file;
		$updateablefile = $destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime;
		
		// rename the base image file 
		$upload->addFilter('Rename',  array('target' => $thefilename, 'overwrite' => true));		
		// exit();
		// process the file upload
		if($upload->receive()){
			//debugMessage('Completed');
			$file = $upload->getFileInfo('profileimage');
			// debugMessage($file);
			
			$basefile = $thefilename;
			// convert png,gif to jpg
			if(in_array(strtolower($uploadedext), array('png','gif'))){
				ak_img_convert_to_jpg($thefilename, $updateablefile.'.jpg', $uploadedext);
				unlink($thefilename);
				$basefile = $updateablefile.'.jpg';
			}
			
			// new profilenames
			$newlargefilename = "large_".$currenttime_file;
			// generate and save thumbnails for sizes 250, 125 and 50 pixels
			resizeImage($basefile, $destination_path.DIRECTORY_SEPARATOR.$newlargefilename, 400);
			
			// update the useraccount with the new profile images
			try {
				$inventory->setPhoto($currenttime_file);
				$inventory->save();
				
				// check if user already has profile picture and archive it
				$ftimestamp = current(explode('.', $inventory->getPhoto()));
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
				
				// exit();
				$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("global_save_success"));
				$this->_helper->redirector->gotoUrl($this->view->baseUrl("inventory/picture/id/".encode($inventory->getID()).'/crop/1'));
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
				$session->setVar(FORM_VALUES, $this->_getAllParams());
				$this->_helper->redirector->gotoUrl($this->view->baseUrl('inventory/picture/id/'.encode($inventory->getID())));
			}
		} else {
			// debugMessage($upload->getMessages());
			$uploaderrors = $upload->getMessages();
			$customerrors = array();
			if(!isArrayKeyAnEmptyString('fileUploadErrorNoFile', $uploaderrors)){
				$customerrors['fileUploadErrorNoFile'] = $this->_translate->translate('global_fileupload_error');
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
			// debugMessage($customerrors);
			
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('inventory/picture/id/'.encode($inventory->getID())));
		}
		// exit();
	}
	
	function croppictureAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$inventory = new Inventory();
		$inventory->populate(decode($formvalues['id']));
		$userfolder = $inventory->getID();
		// debugMessage($formvalues);
		//debugMessage($inventory->toArray());
		
		$oldfile = "large_".$inventory->getPhoto();
		$base = APPLICATION_PATH.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user_".$inventory->getUserID().DIRECTORY_SEPARATOR."inventory".DIRECTORY_SEPARATOR."inventory_".$inventory->getID().DIRECTORY_SEPARATOR; 
		$src = $base.$oldfile;
		// debugMessage($src);
		
		// debugMessage($inventory->getLargePicturePath());
		$currenttime = mktime();
		$currenttime_file = $currenttime.'.'.findExtension($inventory->getLargePicturePath());
		$newlargefilename = $base."large_".$currenttime_file;
		$newthumbnailfilename = $base."thumbnail_".$currenttime_file;
		// debugMessage($newlargefilename);
		
		$image = WideImage::load($src);
		$cropped1 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
		$resized_1 = $cropped1->resize(375, 300, 'fill');
		$resized_1->saveToFile($newlargefilename);
		
		//$image3 = WideImage::load($src);
		$cropped3 = $image->crop($formvalues['x1'], $formvalues['y1'], $formvalues['w'], $formvalues['h']);
		$resized_3 = $cropped3->resize(150, 110, 'fill');
		$resized_3->saveToFile($newthumbnailfilename);
		
		$inventory->setPhoto($currenttime_file);
		$inventory->save();
		
		// check if user already has profile picture and archive it
		$ftimestamp = current(explode('.', $inventory->getPhoto()));
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
				
		$this->_helper->redirector->gotoUrl($this->view->baseUrl('inventory/view/id/'.encode($inventory->getID())));
		// exit();
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
    
	public function serviceAction() {}
	
	public function serviceviewAction() {}

	public function servicecreateAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		if(isEmptyString($this->_getParam('id'))){
			$this->_setParam("action", ACTION_CREATE); 
		} else {
			$this->_setParam("action", ACTION_EDIT);
		}
		
		// debugMessage($this->_getAllParams());
		//exit();
		parent::createAction();	
	}
	
	function addservicessuccessAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$session = SessionWrapper::getInstance(); 
		$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate($this->_getParam(SUCCESS_MESSAGE)));
	}
}