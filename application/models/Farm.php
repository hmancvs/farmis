<?php

class Farm extends BaseEntity {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('farm');
		$this->hasColumn('farmerid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('businessname', 'string', 255, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('shortname', 'string', 50);
		$this->hasColumn('description', 'string', 255);
		$this->hasColumn('type', 'integer', null);
		$this->hasColumn('regno', 'string', 15);
		$this->hasColumn('regdate', 'date');
		$this->hasColumn('bizstartmonth', 'string', 4, array('default' => NULL));
		$this->hasColumn('bizstartyear', 'string', 4, array('default' => NULL));
		$this->hasColumn('parentid', 'integer', null);
		$this->hasColumn('isdefault', 'integer', null);
		$this->hasColumn('logo', 'string', 255);
		$this->hasColumn('landsize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('landactivesize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('landunits', 'integer', null, array('default' => 1));
		$this->hasColumn('landacquiremethod', 'integer', null, array('default' => 1));
		$this->hasColumn('landarea', 'string', 1000);
		$this->hasColumn('gpsmeta', 'string', 500);
		$this->hasColumn('numberofbranches', 'integer', null);
		$this->hasColumn('numberofemployees', 'integer', null);
		$this->hasColumn('numberoffields', 'integer', null, array('default' => 1));
		$this->hasColumn('notes', 'string', 1000);
		$this->hasColumn('addressid', 'integer', null);
		$this->hasColumn('hashistory', 'integer', null, array('default' => 0));
		$this->hasColumn('farmingtools', 'string', 50);
	}
	/**
	 * Contructor method for custom initialization
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("regdate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"businessname.notblank" => $this->translate->_("farm_businessname_error"),
       									"farmerid.notblank" => $this->translate->_("farm_farmerid_error")
       	       						));
	}
	/**
	 * Model relationships
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('Farmer as farmer', 
								array(
									'local' => 'farmerid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('Address as address',
						 array(
								'local' => 'addressid',
								'foreign' => 'id'
							)
					); 
		$this->hasMany('Address as addresses',
						 array(
								'local' => 'id',
								'foreign' => 'farmid'
							)
					);
		$this->hasMany('Season as seasons',
						 array(
								'local' => 'id',
								'foreign' => 'farmid'
							)
					);
		$this->hasMany('FarmLand as fields',
						 array(
								'local' => 'id',
								'foreign' => 'farmid'
							)
					);
		$this->hasMany('FarmCrop as farmcrops',
						 array(
								'local' => 'id',
								'foreign' => 'farmid'
							)
					);
		$this->hasMany('FarmPreseason as preseasons',
						 array(
								'local' => 'id',
								'foreign' => 'farmid'
							)
					);
		$this->hasMany('FarmPreseasonDetail as preseasonlines',
						 array(
								'local' => 'id',
								'foreign' => 'farmid'
							)
					);
	}
	
	/**
	 * Preprocess model data
	 */
	function processPost($formvalues){
		// debugMessage($formvalues);
		$session = SessionWrapper::getInstance();
    	$farmerid = $session->getVar('farmerid');
    	$userid = $session->getVar('userid');
    	
		// set default values for integers, dates, decimals
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		}
		if(isArrayKeyAnEmptyString('parentid', $formvalues)){
			$formvalues['parentid'] = NULL;  
		}
		if(isArrayKeyAnEmptyString('addressid', $formvalues)){
			unset($formvalues['addressid']); 
		}
		if(isArrayKeyAnEmptyString('regdate', $formvalues)){
			unset($formvalues['regdate']); 
		}
		if(isArrayKeyAnEmptyString('bizstartyear', $formvalues)){
			unset($formvalues['bizstartyear']); 
		}
		if(isArrayKeyAnEmptyString('bizstartmonth', $formvalues)){
			unset($formvalues['bizstartmonth']); 
		}
		if(isArrayKeyAnEmptyString('isdefault', $formvalues)){
			unset($formvalues['isdefault']); 
		}
		if(isArrayKeyAnEmptyString('numberofbranches', $formvalues)){
			unset($formvalues['numberofbranches']); 
		}
		if(isArrayKeyAnEmptyString('numberofemployees', $formvalues)){
			unset($formvalues['numberofemployees']); 
		}
		if(isArrayKeyAnEmptyString('numberoffields', $formvalues)){
			unset($formvalues['numberoffields']); 
		}
		if(isArrayKeyAnEmptyString('landsize', $formvalues)){
			unset($formvalues['landsize']); 
		}
		if(isArrayKeyAnEmptyString('landactivesize', $formvalues)){
			unset($formvalues['landactivesize']); 
		}
		if(isArrayKeyAnEmptyString('landunits', $formvalues)){
			unset($formvalues['landunits']);  
		}
		if(isArrayKeyAnEmptyString('landacquiremethod', $formvalues)){
			unset($formvalues['landacquiremethod']);
		}
		if(isArrayKeyAnEmptyString('hashistory', $formvalues)){
			unset($formvalues['hashistory']);
		}
		
		# process address information
		$address = array(); 
		$theaddress = $this->getAddress();
		$address[0]['id'] = $theaddress->getID();
		$address[0]['type'] = 3;
		if(!isArrayKeyAnEmptyString('id', $formvalues)){
			$address[0]['farmid'] = $formvalues['id'];
		}
		$address[0]['country'] = !isArrayKeyAnEmptyString('country', $formvalues) ? $formvalues['country'] : NULL;
		if(!isArrayKeyAnEmptyString('districtid', $formvalues)){
			$address[0]['districtid'] = $formvalues['districtid'];
		}
		if(!isArrayKeyAnEmptyString('countyid', $formvalues)){
			$address[0]['countyid'] = $formvalues['countyid'];
		}
		if(!isArrayKeyAnEmptyString('subcountyid', $formvalues)){
			$address[0]['subcountyid'] = $formvalues['subcountyid'];
		}
		if(!isArrayKeyAnEmptyString('parishid', $formvalues)){
			$address[0]['parishid'] = $formvalues['parishid'];
		}
		if(!isArrayKeyAnEmptyString('villageid', $formvalues)){
			$address[0]['villageid'] = $formvalues['villageid'];
		}
		if(!isArrayKeyAnEmptyString('streetaddress', $formvalues)){
			$address[0]['streetaddress'] = $formvalues['streetaddress'];
		}
		
		if(count($address) > 0){
			$formvalues['addresses'] = $address;
		}
		
		$fields = array();
		$maxfields = MAX_NO_FARMS_LANDS;
		$i = 1;
		if(!isArrayKeyAnEmptyString('fields', $formvalues)){
			$fieldsdata = $formvalues['fields'];
			foreach($fieldsdata as $key => $value){
				if(!isArrayKeyAnEmptyString('name', $value) && !isEmptyString($value['name'])){
					$fields[$i]['farmid'] = $formvalues['id'];
					$fields[$i]['name'] = $value['name'];
					$fields[$i]['landsize'] = $value['landsize'];
					$fields[$i]['landunits'] = $formvalues['fields_landunits_'.$i];
					$fields[$i]['sameaddress'] = $formvalues['fields_sameaddress_'.$i];
					$i++;
				}
			}
		}
		
		if(count($fields) > 0){
			$formvalues['fields'] = $fields;
		}
		
		if(!isArrayKeyAnEmptyString('hashistory', $formvalues)){
			if($formvalues['hashistory'] == 1){
				if(!isArrayKeyAnEmptyString('startyear', $formvalues)){
					$formvalues['preseasons'][0]['startyear'] = $formvalues['startyear'];
				}
				if(!isArrayKeyAnEmptyString('startmonth', $formvalues)){
					$formvalues['preseasons'][0]['startmonth'] = $formvalues['startmonth'];
				}
				if(!isArrayKeyAnEmptyString('endyear', $formvalues)){
					$formvalues['preseasons'][0]['endyear'] = $formvalues['endyear'];
				}
				if(!isArrayKeyAnEmptyString('endmonth', $formvalues)){
					$formvalues['preseasons'][0]['endmonth'] = $formvalues['endmonth'];
				}
				$formvalues['preseasons'][0]['userid'] = $formvalues['userid'];
				$formvalues['preseasons'][0]['farmerid'] = $formvalues['farmerid'];
				$formvalues['preseasons'][0]['farmid'] = $formvalues['farmid'];
				$formvalues['preseasons'][0]['createdby'] = 1;
				
				$cropdetails = $formvalues['details'];
				foreach ($cropdetails as $key => $value){
					// debugMessage($value);
					if(!isArrayKeyAnEmptyString('cropid_'.$key, $formvalues)){
						$cropdetails[$key]['cropid'] = $formvalues['cropid_'.$key];
						$cropdetails[$key]['farmid'] = $formvalues['id'];
						if(!isArrayKeyAnEmptyString('id_'.$key, $formvalues)){
							$cropdetails[$key]['id'] = $formvalues['id_'.$key];
						}
						if(!isArrayKeyAnEmptyString('fieldsizeunit_'.$key, $formvalues)){
							$cropdetails[$key]['fieldsizeunit'] = $formvalues['fieldsizeunit_'.$key];
						} else {
							$cropdetails[$key]['fieldsizeunit'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('totalharvestunit_'.$key, $formvalues)){
							$cropdetails[$key]['totalharvestunit'] = $formvalues['totalharvestunit_'.$key];
						} else {
							$cropdetails[$key]['totalharvestunit'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('yieldunit_'.$key, $formvalues)){
							$cropdetails[$key]['yieldunit'] = $formvalues['yieldunit_'.$key];
						} else {
							$cropdetails[$key]['totalharvestunit'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('quantitysoldunit_'.$key, $formvalues)){
							$cropdetails[$key]['quantitysoldunit'] = $formvalues['quantitysoldunit_'.$key];
						} else {
							$cropdetails[$key]['quantitysoldunit'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('saletype_'.$key, $formvalues)){
							$cropdetails[$key]['saletype'] = $formvalues['saletype_'.$key];
						} else {
							$cropdetails[$key]['saletype'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('fieldsize', $value)){
							$cropdetails[$key]['fieldsize'] = $value['fieldsize'];
						} else {
							$cropdetails[$key]['fieldsize'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('totalplanted', $value)){
							$cropdetails[$key]['totalplanted'] = $value['totalplanted'];
						} else {
							$cropdetails[$key]['totalplanted'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('totalplantedunit_'.$key, $formvalues)){
							$cropdetails[$key]['totalplantedunit'] = $formvalues['totalplantedunit_'.$key];
						} else {
							$cropdetails[$key]['totalplantedunit'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('totalharvest', $value)){
							$cropdetails[$key]['totalharvest'] = $value['totalharvest'];
						} else {
							$cropdetails[$key]['totalharvest'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('quantitysold', $value)){
							$cropdetails[$key]['quantitysold'] = $value['quantitysold'];
						} else {
							$cropdetails[$key]['quantitysold'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('unitprice', $value)){
							$cropdetails[$key]['unitprice'] = $value['unitprice'];
						} else {
							$cropdetails[$key]['unitprice'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('totalsalesamount', $value)){
							$cropdetails[$key]['totalsalesamount'] = $value['totalsalesamount'];
						} else {
							$cropdetails[$key]['totalsalesamount'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('nextseasonrevenue', $value)){
							$cropdetails[$key]['nextseasonrevenue'] = $value['nextseasonrevenue'];
						} else {
							$cropdetails[$key]['nextseasonrevenue'] = NULL;
						}
						if(!isArrayKeyAnEmptyString('financetype_'.$key, $formvalues)){
							if($formvalues['financetype_'.$key] == 1){
								// debugMessage('processing loan');
								$cropdetails[$key]['loans'][0]['createdby'] = $formvalues['userid'];
								$cropdetails[$key]['loans'][0]['userid'] = $formvalues['userid'];
								$cropdetails[$key]['loans'][0]['farmid'] = $formvalues['farmid'];
								$cropdetails[$key]['loans'][0]['farmerid'] = $formvalues['farmerid'];
								isArrayKeyAnEmptyString('principal', $value) ? $cropdetails[$key]['loans'][0]['principal'] = NULL : $cropdetails[$key]['loans'][0]['principal'] = $value['principal'];
								isArrayKeyAnEmptyString('interestrate', $value) ? $cropdetails[$key]['loans'][0]['interestrate'] = NULL : $cropdetails[$key]['loans'][0]['interestrate'] = $value['interestrate'];
								isArrayKeyAnEmptyString('paybackamount', $value) ? $cropdetails[$key]['loans'][0]['paybackamount'] = NULL : $cropdetails[$key]['loans'][0]['paybackamount'] = $value['paybackamount'];
								isArrayKeyAnEmptyString('installment', $value) ? $cropdetails[$key]['loans'][0]['installment'] = NULL : $cropdetails[$key]['loans'][0]['installment'] = $value['installment'];
								isArrayKeyAnEmptyString('installmentunit', $value) ? $cropdetails[$key]['loans'][0]['installmentunit'] = NULL : $cropdetails[$key]['loans'][0]['installmentunit'] = $value['installmentunit'];
								isArrayKeyAnEmptyString('paybackperiod', $value) ? $cropdetails[$key]['loans'][0]['paybackperiod'] = NULL : $cropdetails[$key]['loans'][0]['paybackperiod'] = $value['paybackperiod'];
								isArrayKeyAnEmptyString('paybackperiodunit_'.$key, $formvalues) ? $cropdetails[$key]['loans'][0]['paybackperiodunit'] = NULL : $cropdetails[$key]['loans'][0]['paybackperiodunit'] = $formvalues['paybackperiodunit_'.$key];
								isArrayKeyAnEmptyString('creditdate', $value) ? $cropdetails[$key]['loans'][0]['creditdate'] = NULL : $cropdetails[$key]['loans'][0]['creditdate'] = $value['creditdate'];
								isArrayKeyAnEmptyString('financesourceid', $value) ? $cropdetails[$key]['loans'][0]['financesourceid'] = NULL : $cropdetails[$key]['loans'][0]['financesourceid'] = $value['financesourceid'];
								isArrayKeyAnEmptyString('financesourcetext', $value) ? $cropdetails[$key]['loans'][0]['financesourcetext'] = NULL : $cropdetails[$key]['loans'][0]['financesourcetext'] = $value['financesourcetext'];
							} else {
								$cropdetails[$key]['loans'] = array();
							}
						} 
						$cropdetails[$key]['financetype'] = $formvalues['financetype_'.$key];
					} else {
						unset($cropdetails[$key]);
					}
				}
				if(count($cropdetails)){
					$formvalues['preseasons'][0]['details'] = $cropdetails;
				} else {
					$formvalues['preseasons'][0]['details'] = array();
				}
				unset($formvalues['details']);
			} else {
				$formvalues['preseasons'] = array();
			}
		}
		
		if(!isArrayKeyAnEmptyString('farmingtoolsids', $formvalues)) {
			// if(!isEmptyString($formvalues['farmingtoolsids'])){
				$ids = $formvalues['farmingtoolsids']; 
				$typelist = ''; 
				if(count($ids) > 0){
					$typelist = createHTMLCommaListFromArray($ids, ",");
				}
				$formvalues['farmingtools'] = $typelist; 
				# remove the usergroups_groupid array, it will be ignored, but to be on the safe side
				unset($formvalues['farmingtoolsids']); 
			
		} else {
			unset($formvalues['farmingtools']); 
		}
		
        debugMessage($formvalues); // exit();
		parent::processPost($formvalues);
	}
	/**
	 * Return the person's full names, which is a concatenation of the first and the surname
	 *
	 * @return String
	 */
	function getName() {
	    return $this->getBusinessName();
	}
	/**
     * Determine the type of person
     * @return bool
     */
    function getTypeLabel(){
    	$label = '--';
    	return $label; 
    }
    /**
     * Determine the type of person
     * @return bool
     */
    function getLandUnitsLabel(){
    	$label = '--';
    	$allmeasures = getAreaUnits();
    	if(!isEmptyString($this->getLandUnits())){
    		$label = $allmeasures[$this->getLandUnits()];
    	}
    	return $label;
    }
    # determine text string for available land size
    function displayActiveLandSize(){
    	if(isEmptyString($this->getLandActiveSize()) || $this->getLandActiveSize() == 0 || $this->getLandActiveSize() == 0.00) {
    		return '--';
    	} else {
    		$ret = '--';
    		if(!isEmptyString($this->getLandUnitsLabel())){
    			$ret = clean_num($this->getLandActiveSize()).'&nbsp; <span class="pagedescription">('.$this->getLandUnitsLabel().')</span>';
    		}
    		return $ret;
    	}
    }
	# determine text string for active land size
    function displayLandSize(){
    	if(isEmptyString($this->getLandSize()) || $this->getLandSize() == 0 || $this->getLandSize() == 0.00) {
    		return '--';
    	} else {
    		$ret = '--';
    		if(!isEmptyString($this->getLandUnitsLabel())){
    			$ret = clean_num($this->getLandSize()).'&nbsp; <span class="pagedescription">('.$this->getLandUnitsLabel().')</span>';
    		}
    		return $ret;
    	}
    }
 	/**
     * Determine the type of person
     * @return bool
     */
    function getLandAcquireMethodLabel(){
    	$label = '--';
    	$allmethods = getLandAcquireMethods();
    	if(!isEmptyString($this->getLandAcquireMethod()) || $this->getLandAcquireMethod() != 0){
    		$label = $allmethods[$this->getLandAcquireMethod()];
    	}
    	return $label;
    }
    /**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$farmerid = $session->getVar('farmerid');
    	$userid = $session->getVar('userid');
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	if(!isEmptyString($this->getAddress()->getID())){
    		$this->setAddressID($this->getAddress()->getID());
    		$update = true;
    	}
    	if(isEmptyString($this->getRegDate())){
    		$this->setRegDate(date("Y-m-d"));
    		$update = true;
    	}
    	# generate registration number for farmer
    	if(isEmptyString($this->getRegNo())){
			$this->setRegNo($this->getNextRegNo());
			$update = true;
    	}
    	
    	# save changes 
    	if($update){
    		$this->save();
    	}
    	// exit();
    	return true;
    }
    /**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterUpdate(){
    	$session = SessionWrapper::getInstance();
    	$farmerid = $session->getVar('farmerid');
    	$userid = $session->getVar('userid');
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	if(!isEmptyString($this->getAddress()->getID())){
    		$this->setAddressID($this->getAddress()->getID());
    		$update = true;
    	}
    	if(isEmptyString($this->getRegDate())){
    		$this->setRegDate(date("Y-m-d"));
    		$update = true;
    	}
    	# generate registration number for farmer
    	if(isEmptyString($this->getRegNo())){
			$this->setRegNo($this->getNextRegNo());
			$update = true;
    	}
    	
    	# save changes 
    	if($update){
    		$this->save();
    	}
    	
    	// exit();
    	return true;
    }
	# determine if person has profile image
	function hasLogo(){
		$real_path = APPLICATION_PATH.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."user_".$this->getFarmer()->getUserID().DIRECTORY_SEPARATOR."farm_".$this->getID();
		$real_path = $real_path.DIRECTORY_SEPARATOR."large_".$this->getLogo();
		if(file_exists($real_path) && !isEmptyString($this->getLogo())){
			return true;
		}
		return false;
	}
	# determine path to thumbnail profile picture
	function getThumbnailLogoPath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/farms/default/thumbnail_default.jpg';
		if($this->hasLogo()){
			$path = $baseUrl.'/uploads/user_'.$this->getFarmer()->getUserID().'/farm_'.$this->getID().'/thumbnail_'.$this->getLogo();
		}
		return $path;
	}
	# determine path to medium profile picture
	function getMediumLogoPath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/farms/default/medium_default.jpg';
		if($this->hasLogo()){
			$path = $baseUrl.'/uploads/user_'.$this->getFarmer()->getUserID().'/farm_'.$this->getID().'/medium_'.$this->getLogo();
		}
		return $path;
	}
	# determine path to large profile picture
	function getLargeLogoPath() {
		$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
		$path = $baseUrl.'/uploads/farms/default/large_default.jpg'; 
		if($this->hasLogo()){
			$path = $baseUrl.'/uploads/user_'.$this->getFarmer()->getUserID().'/farm_'.$this->getID().'/large_'.$this->getLogo();
		}
		// debugMessage($path);
		return $path;
	}
	
	# generate next farmer registration number
	function getNextRegNo(){
		$regno  = '';
		$prefix = FARM_REG_PREFIX;
		$regno = $prefix.'-'."00".$this->getID();
		//debugMessage($prefix);
		return $regno;
	}
	/**
	 * Return the date of birth 
	 * @return string dateofbirth 
	 */
	function getRegDateFormatted() {
		$birth = "--";
		if(!isEmptyString($this->getRegDate())){
			$birth = changeMySQLDateToPageFormat($this->getRegDate());
		} 
		return $birth;
	}
	# determine the address for farmer
	function getAddress() {
		$address_object = new Address();
		$add = $this->getAddresses();
		# debugMessage($add->toArray());
		if (!isEmptyString($add->get(0)->getID())) {
			$address_object = $add->get(0);
		}
		return $address_object; 
	}
	# cleanup by creating address entry if does not exit
	function cleanUpAddress() {
		if(isEmptyString($this->getAddress()->getID())){
			$address = $this->getAddress();
			$address->setFarmID($this->getID());
			$address->setCreatedBy(1);
			
			$address->save();
			if(!isEmptyString($address->getID())){
				$this->setAddressID($address->getID());
				$this->clearRelated(); 
				$this->save();
			}
		}
		return true;
	}
	# determine the inventory history for inventory item
    function getInventoryDetails(){
    	$q = Doctrine_Query::create()->from('Inventory i')->where("i.farmid = '".$this->getID()."'")->orderby('i.datecreated DESC');
		$result = $q->execute();
		return $result;
    }
	# determine the credit history for inventory item
    function getCreditDetails(){
    	$q = Doctrine_Query::create()->from('Loan l')->where("l.farmid = '".$this->getID()."' AND l.principal > 0 ")->orderby('l.creditdate DESC');
		$result = $q->execute();
		return $result;
    }
    # determine loan history for the farmer 
    function getAllLoanTransactions(){
    	return true;
    }
    
	# determine level of completion for primary profile
	function getStep2_1_Status(){
		$total = 0;
		$count = 0;
		if(!isEmptyString($this->getName())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getDescription())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getNumberofEmployees())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getCountry())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getDistrictID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getDistrictID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getCountyID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getSubCountyID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getParishID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getVillageID())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getAddress()->getStreetAddress())){
			$total += 10;
		} 
		$count += 10;
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
	// determine status of land usage profiling
	function getStep2_2_Status(){
		$total = 0;
		$count = 0;
		if(!isEmptyString($this->getlandsize())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getlandactivesize())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getlandunits())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getlandacquiremethod())){
			$total += 10;
		} 
		$count += 10;
		if(!isEmptyString($this->getnumberoffields())){
			$total += 10;
		} 
		$count += 10;
		
		$percentage = round(ceil(($total/$count) * 100),-1);
		return $percentage;
	}
	# get crops for farm
	function getCrops() {
		$q = Doctrine_Query::create()->from('FarmCrop fc')->where("fc.farmid = '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	}
	function getCropList(){
		$crops = $this->getCrops();
		$countcrops = $crops->count();
		$list = '';
		$dataarray = array();
		if($countcrops > 0) {
			foreach ($crops as $crop){
				$dataarray[] = $crop->getCrop()->getName();
			}
		}
		return createHTMLCommaListFromArray($dataarray);
	}
	# function determine if history of estimates is available
	function getHistoryStatusText(){
		return $this->getHasHistory() == '1' ? 'Yes' : 'No' ;
	}
	function hasPreviousSeason(){
		return $this->getHasHistory() == '1' ? true : false ;
	}
	# the start date
	function getFullStartDate() {
		$date = "--";
		if(!isEmptyString($this->getBizStartYear()) && $this->getBizStartYear() != 0){
			$date = $this->getBizStartYear();
		}
		if(!isEmptyString($this->getBizStartMonth()) && !isEmptyString($this->getBizStartYear())){
			$months = getAllMonthsAsShortNames();
			$date = $months[$this->getBizStartMonth()].", ".$this->getBizStartYear();
		}
		return $date;
	}
	# determine if farm has atleast one season 
	function hasSeason() {
		$seasons = $this->getSeasons();
		$scount = $seasons->count();
		if($scount == 0) {
			return false;
		} else {
			return true;
		}
	}
	# determine the cropids
	function getCropIDs() {
        $ids = array();
        $crops = $this->getCrops();
        if($crops){
	        //debugMessage($groups->toArray());
	        foreach($crops as $crop) {
	            $ids[] = $crop->getCropID();
	        }
        }
        return $ids;
    }
	# format the farming types from the comma list
	function getFarmingToolsLabel(){
		$label = '--';
		if(!isEmptyString($this->getFarmingTools())){
			$lookup_array = getFarmingTools();
			$list_array = explode(',', $this->getFarmingTools());
			$list_text_array = array();
			if(count($list_array) > 0){
				foreach ($list_array as $value){
					$list_text_array[$value] = $lookup_array[$value];
				}
				asort($list_text_array);
			}
			$label = createHTMLCommaListFromArray($list_text_array, ", ");
		}
		return $label;
	}
	# list of farming typeids
	function getFarmingToolsIDs(){
		$dataarray = array();
		if(!isEmptyString($this->getFarmingTools())){
			$list_array = explode(',', $this->getFarmingTools());
			if(is_array($list_array)){
				$dataarray = $list_array;
			}
		}
		return $dataarray;
	}
	# count number of seasons
	function getCountSeasons(){
		$seasons = $this->getSeasons();
		$scount = $seasons->count();
		return $scount;
	}
	# the total revenue to date on farm
	function getTotalSalesToDate(){
		$seasons = $this->getSeasons();
		$total = 0;
		if($seasons->count()>0){
			foreach ($seasons as $aseason){
				$total += $aseason->getTotalRevenue();
			}
		}
		return $total = 0;
	}
	# the total expenses to date on farm
	function getTotalExpensesToDate(){
		$seasons = $this->getSeasons();
		$total = 0;
		if($seasons->count()>0){
			foreach ($seasons as $aseason){
				$total += $aseason->getTotalExpenses();
			}
		}
		return $total = 0;
	}
	# fetch order farm seasons 
	function getOrderedSeasons() {
		$q = Doctrine_Query::create()->from('Season s')->where("s.farmid = '".$this->getID()."' ")->orderby('s.datecreated desc');
		$result = $q->execute();
		return $result;
	}
}

?>