<?php
class FarmController extends SecureController   {

    public function addAction(){}
    
    public function getActionforACL() {
        $action = strtolower($this->getRequest()->getActionName()); 
		if($action == "add" || $action == "addcrop" || $action == "processadd" || $action == "processaddcrop" || $action == "processother") {
			return ACTION_CREATE; 
		}
    	if($action == "picture" || $action == "processpicture" || $action == "croppicture" || $action == "delete" ||  
    		$action == "addsuccess" || $action == "addcropsuccess" || $action == "events"
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
    
	public function addsuccessAction(){
		$session = SessionWrapper::getInstance(); 
     	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);

		$session->setVar(SUCCESS_MESSAGE, $this->_translate->translate("farmer_add_success"));
    	// echo '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.$this->_translate->translate("farmer_invite_success").'</div>';
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
			$post_data[$key]['farmerid'] = $formvalues['farmerid'];
			$post_data[$key]['farmid'] = $formvalues['farmid'];
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
		$farm = new Farm();
		$farm->populate(decode($this->_getParam('id')));
		
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
		if(!is_dir($destination_path.$farm->getFarmer()->getUserID())){
			// no folder exits. Create the folder
			mkdir($destination_path.$farm->getFarmer()->getUserID(), 0755);
		} 
		
		// set the destination path for the image
		$profilefolder = $farm->getFarmer()->getUserID();
		$destination_path = $destination_path.$profilefolder.DIRECTORY_SEPARATOR."farm_".$farm->getID();
		if(!is_dir($destination_path)){
			mkdir($destination_path, 0755);
		}
		// create archive folder for each user
		$archivefolder = $destination_path.DIRECTORY_SEPARATOR."archive";
		if(!is_dir($archivefolder)){
			mkdir($archivefolder, 0755);
		}
		
		$oldfilename = $farm->getLogo();
		
		// debugMessage($destination_path); 
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
			resizeImage($basefile, $destination_path.DIRECTORY_SEPARATOR.'medium_'.$currenttime.'.jpg', 165);
			// unlink($thefilename);
			unlink($destination_path.DIRECTORY_SEPARATOR.'base_'.$currenttime.'.jpg');
			
			// exit();
			// update the useraccount with the new profile images
			try {
				$farm->setlogo($currenttime.'.jpg');
				$farm->save();
				
				// check if user already has profile picture and archive it
				$ftimestamp = current(explode('.', $farm->getLogo()));
				
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
				$this->_helper->redirector->gotoUrl($this->view->baseUrl("farm/picture/id/".encode($farm->getID()).'/crop/1'));
			} catch (Exception $e) {
				$session->setVar(ERROR_MESSAGE, $e->getMessage());
				$session->setVar(FORM_VALUES, $this->_getAllParams());
				$this->_helper->redirector->gotoUrl($this->view->baseUrl('farm/picture/id/'.encode($farm->getID())));
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
			
			$this->_helper->redirector->gotoUrl($this->view->baseUrl('farm/picture/id/'.encode($farm->getID()).'/type/'.$type));
		}
		// exit();
	}
	
	function croppictureAction(){
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		
		$formvalues = $this->_getAllParams();
		$type = $formvalues['type'];
		
		$farm = new Farm();
		$farm->populate(decode($formvalues['id']));
		$userfolder = $farm->getFarmer()->getUserID();
		$farmfolder = $farm->getID();
		// debugMessage($formvalues);
		//debugMessage($farm->toArray());
		
		$oldfile = "large_".$farm->getLogo();
		$base = APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.PUBLICFOLDER.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'user_'.$userfolder.''.DIRECTORY_SEPARATOR.'farm_'.$farmfolder.DIRECTORY_SEPARATOR;
		
		// debugMessage($farm->toArray());
		$src = $base.$oldfile;
		// debugMessage($base);
		// exit();
				
		$currenttime = mktime();
		$currenttime_file = $currenttime.'.jpg';
		$newlargefilename = $base."large_".$currenttime_file;
		$newmediumfilename = $base."medium_".$currenttime_file;
		$newthumbnailfilename = $base."thumbnail_".$currenttime_file;
		
		// exit();
		$image = WideImage::load($src);
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
		
		$farm->setLogo($currenttime_file);
		
		$farm->save();
			
		// check if user already has profile picture and archive it
		$ftimestamp = current(explode('.', $farm->getLogo()));
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
		$this->_helper->redirector->gotoUrl($this->view->baseUrl('farm/view/id/'.encode($farm->getID())));
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
    
	function eventsAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(TRUE);
		$formvalues = $this->_getAllParams();
		
		$farm = new Farm();
		$farm->populate($formvalues['id']);
		$seasons = $farm->getOrderedSeasons();
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