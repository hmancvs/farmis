<?php

class Contact extends BaseEntity {
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('contact');
		$this->hasColumn('categoryid', 'integer', null, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('contacttype', 'integer', array('notnull' => true, 'notblank' => true, 'default' => 1));
		$this->hasColumn('userid', 'integer', null);
		$this->hasColumn('farmerid', 'integer', null);
		$this->hasColumn('farmid', 'integer', null);
		$this->hasColumn('farmgroupid', 'integer', null);
		$this->hasColumn('organisationid', 'integer', null);
		$this->hasColumn('type', 'integer', null, array('default' => '1')); // 1 farmer, 2 farm group, 3 farm, 4 organisation
		$this->hasColumn('salutation', 'integer', null);
		$this->hasColumn('gender', 'integer', null); # 1=Male, 2=Female, 3=Unknown
		$this->hasColumn('firstname', 'string', 100);
		$this->hasColumn('lastname', 'string', 100);
		$this->hasColumn('othernames', 'string', 100);
		$this->hasColumn('orgname', 'string', 255);
		
		$this->hasColumn('contactperson', 'string', 255);
		$this->hasColumn('phone', 'string', 25, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('phone2', 'string', 25);
		$this->hasColumn('email', 'string', 255);
		$this->hasColumn('address', 'string', 255);
		$this->hasColumn('visibility', 'integer', null, array('default' => 1));
		$this->hasColumn('locationid', 'integer', null);
		$this->hasColumn('countyid', 'integer', null);
		$this->hasColumn('subcountyid', 'integer', null);
		
		$this->hasColumn('idorpassportno', 'string', 255);
		$this->hasColumn('driverlicenceno', 'string', 255);
		$this->hasColumn('licenceno', 'string', 255);
		$this->hasColumn('dateofregistration', 'date', null);
		$this->hasColumn('numberofmale', 'integer', null);
		$this->hasColumn('numberoffemale', 'integer', null);
		$this->hasColumn('businessdescription', 'clob', array('notnull' => true, 'notblank' => true));
		$this->hasColumn('goodsorservicesoffered', 'clob', array('notnull' => true, 'notblank' => true));
		$this->hasColumn('numberofoutlets', 'integer', null);
		$this->hasColumn('wishtoadvertise', 'integer', null, array('default' => 0));
		$this->hasColumn('goodsorservicetoadvertise', 'clob');
		$this->hasColumn('vatnumber', 'string', 255);
		$this->hasColumn('tinnumber', 'string', 255);
		
		
		$this->setSubclasses(array(
				'Person' => array('contacttype' => 1),
				'Company' => array('contacttype' => 2)
			)
		);
		
		// unique constraint
		# TODO add custom validation for unique depending on contact type
		
	}
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// define the date fields
		$this->addDateFields(array("dateofregistration"));
		// set the default contract type
		/*if(isEmptyString($this->getContactType())){
			$this->setContactType($this->config->contact->defaultcontacttype);
		}*/
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"contacttype.notblank" => $this->translate->_("contact_contactytype_label"),								
       									"phone.notblank" => $this->translate->_("contact_phone_error"),
       									"categoryid.notblank" => $this->translate->_("contact_category_error")
       	       						));
	}
	
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('Farmer as farmer', 
								array(
									'local' => 'farmerid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('FarmGroup as farmgroup', 
								array(
									'local' => 'farmgroupid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('FarmGroup as farm', 
								array(
									'local' => 'farmid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('District as location',
						 array(
								'local' => 'locationid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('County as county',
						 array(
								'local' => 'countyid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Subcounty as subcounty',
						 array(
								'local' => 'subcountyid',
								'foreign' => 'id'
							)
					); 
		$this->hasMany('ContactCategory as contactcategories',
							array('local' => 'id',
									'foreign' => 'contactid'
							)
						);
		$this->hasOne('BusinessDirectoryCategory as category',
							array('local' => 'categoryid',
									'foreign' => 'id'
							)
						);
	}
	/*
	 * 
	 */
	function validate() {
		parent::validate();
		
		$conn = Doctrine_Manager::connection();
		
		# Validate that the contact firstname,lastname,othernames are unique for person contacttype
		if($this->getContactType() == "1"){
			# Check that the firstname been specified
			if(isEmptyString($this->getFirstName())){
				$this->getErrorStack()->add("firstname.notblank", $this->translate->_("useraccount_firstname_error"));
			}
			# Check that the lastname been specified
			if(isEmptyString($this->getLastName())){
				$this->getErrorStack()->add("lastname.notblank", $this->translate->_("useraccount_lastname_error"));
			}
			# Check that the gender been specified
			if(isEmptyString($this->getGender())){
				$this->getErrorStack()->add("gender.notblank", $this->translate->_("contact_gender_error"));
			}

			# Validate that the person firstname, lastname and othernames are unique for person contacttype 
			$person_query = "SELECT id FROM contact WHERE firstname = '".$this->getFirstName()."' AND lastname = '".$this->getLastName()."' AND othernames = '".$this->getOtherNames()."' AND id <> '".$this->getID()."'";		
			$person_result = $conn->fetchOne($person_query);
			if(!isEmptyString($person_result)){ 
				$this->getErrorStack()->add("contact.unique", sprintf($this->translate->_("contact_person_unique_error"), $this->getFirstName()." ".$this->getLastName()));
			}
		}
		
		# Custom validation for Company contact type 
		if($this->getContactType() == "2"){
			# Check that the company name has been specified
			if(isEmptyString($this->getOrgName())){
				$this->getErrorStack()->add("orgname.notblank", $this->translate->_("contact_orgname_error"));
			}
			
			# Validate that the company name is unique for company contacttype
			$company_query = "SELECT id FROM contact WHERE orgname = '".$this->getOrgName()."' AND contacttype = '2' AND id <> '".$this->getID()."'";
			$company_result = $conn->fetchOne($company_query);
			if(!isEmptyString($company_result)){ 
				$this->getErrorStack()->add("company.unique",  sprintf($this->translate->_("contact_person_unique_error"),$this->getOrgName()));
			}
		}
	}
	/*
	 * 
	 */
	function processPost($formvalues){
		// check if the locationid is specified
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']); 
		}
		if(isArrayKeyAnEmptyString('farmerid', $formvalues)){
			unset($formvalues['farmerid']); 
		}
		if(isArrayKeyAnEmptyString('farmgroupid', $formvalues)){
			unset($formvalues['farmgroupid']); 
		}
		if(isArrayKeyAnEmptyString('farmid', $formvalues)){
			unset($formvalues['farmid']); 
		}
		if(isArrayKeyAnEmptyString('organisationid', $formvalues)){
			unset($formvalues['organisationid']); 
		}
		if (isArrayKeyAnEmptyString('locationid', $formvalues)) {
			$formvalues['locationid'] = NULL;
		}
		if (isArrayKeyAnEmptyString('countyid', $formvalues)) {
			$formvalues['countyid'] = NULL;
		}
		if (isArrayKeyAnEmptyString('subcountyid', $formvalues)) {
			$formvalues['subcountyid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('gender', $formvalues)){
			unset($formvalues['gender']); 
		}
		if(isArrayKeyAnEmptyString('salutation', $formvalues)){
			unset($formvalues['salutation']); 
		}
		//unset number fields that can be empty
		if (isArrayKeyAnEmptyString('contactcategories', $formvalues)) {
			unset($formvalues['contactcategories']); 
		}
		//reset all empty number fields to empty string
		if(isArrayKeyAnEmptyString('numberofmale', $formvalues)){
			unset($formvalues['numberofmale']); 
		}
		if(isArrayKeyAnEmptyString('numberoffemale', $formvalues)){
			unset($formvalues['numberoffemale']); 
		}
	    if(isArrayKeyAnEmptyString('numberofoutlets', $formvalues)){
			unset($formvalues['numberofoutlets']); 
		}
		if(isArrayKeyAnEmptyString('wishtoadvertise', $formvalues)){
			unset($formvalues['wishtoadvertise']); 
		}
		
		// move the data from $formvalues['contact_categoryid'] into $formvalues['contactcategories'] array
		$contactcategories = array(); 
		if (array_key_exists('contact_categoryid', $formvalues)) {
			$categoryids = $formvalues['contact_categoryid']; 
			foreach ($categoryids as $id) {
				$contactcategories[]['categoryid'] = $id; 
			}
			$formvalues['contactcategories'] = $contactcategories; 
			// remove the contact_categoryid array, it will be ignored, but to be on the safe side
			unset($formvalues['contact_categoryid']); 
		}
		
		if(count($contactcategories) > 0){
			foreach($formvalues['contactcategories'] as $key => $value){
				if(isEmptyString($value['categoryid'])){
					unset($formvalues['contactcategories'][$key]); 
				}
			}
		}
		// debugMessage($formvalues); exit();		
		parent::processPost($formvalues);
	}
	/**
	 * Returns the full name of the Contact. If the contact is a person, return a concatination on the firstname and the lastname. 
	 * Else if a Company, return the organization name
	 *
	 * @return String
	 */
	function getName() {
		if ($this->isPerson()) {
			$name = '';
			
			if(!isEmptyString($this->getFirstName())){
				$name .= $this->getFirstName().' ';
			}
			if(!isEmptyString($this->getLastName())){
				$name .= $this->getLastName().' ';
			}
			if(!isEmptyString($this->getOtherNames())){
				$name .= $this->getOtherNames().' ';
			}
			if(!isEmptyString($this->getSalutation())){
				$name .= ', ('.$this->getSalutationLabel().')';
			}
			return $name;
		} else {
			return $this->getOrgName();
		}
	}
	/**
     * Determine the gender strinig of a person
     * @return String the gender
     */
    function getGenderLabel(){
    	return $this->getGender() == '1' ? 'Male' : 'Female'; 
    }
 	/**
     * Determine if a person is male
     * @return bool
     */
    function isMale(){
    	return $this->getGender() == '1' ? true : false; 
    }
	/**
     * Determine if a person is female
     * @return bool
     */
    function isFemale(){
    	return $this->getGender() == '2' ? true : false; 
    }
	/**
     * Determine the person's life status label
     * @return String the life status 
     */
    function getSalutationLabel(){
    	$salution = '';
    	$lab = LookupType::getLookupValueDescription("SALUTATION", $this->getSalutation());
    	if(!isEmptyString($this->getSalutation())){
    		$salution = $lab;
    	}
    	return $salution; 
    }
    # determine the contact visibility
    function getVisibilityLabel() {
    	$visiblearray = array("1" => "Show to me only", "2" => "Show to Farm Group", "3" => "Show to Everyone")	;
		echo $visiblearray[$this->getVisibility()];
    }
	/**
     * Return an array containing the IDs of the categories that the contacts belongs to
     *
     * @return Array of the IDs of the categories that the contacts belongs to
     */
    function getSubCategoryIDs() {
        $ids = array();
        $subcategories = $this->getSubCategories();
        //debugMessage($categories->toArray());
        foreach($subcategories as $thecategories) {
            $ids[] = $thecategories->getCategoryID();
        }
        return $ids;
    }
	/**
     * Display a list of categories that the contact belongs
     *
     * @return String HTML list of the categories that the contact belongs to
     */
    function displayCategories() {
        $categories = $this->getSubCategories();
        $str = "";
        if ($categories->count() == 0) {
            return $str;
        }
        $str .= '<ul class="list">';
        foreach($categories as $thecategories) {
            $str .= "<li>".$thecategories->getBusinessDirectoryCategory()->getName()."</li>"; 
        }
        $str .= "</ul>";
        return $str; 
    }
	# determine list of sub categories as comma separated
	function getCategoryList() {
		$categories = $this->getSubCategories();
		// debugMessage($categories->toArray());
       	$str = "";
        $names = array();
        if ($categories->count() > 0) {
	        foreach($categories as $category) {
	        	$names[] = $category->getBusinessDirectoryCategory()->getName();
	        }
	       	$str = implode(', ', $names);
        } else {
        	$str = "--";
        }
        
        return $str; 
	}
    # determine the category name
    function getCategoryName() {
    	$maincategories = $this->getMainCategories();
    	$cat = $maincategories->get(0)->getbusinessdirectorycategory()->getName();
    	$previouscat = isEmptyString($cat) ? '--' : $cat;
    	return isEmptyString($this->getCategoryID()) ? $previouscat : $this->getCategory()->getName();
    }
	# determine the category id
    function getTheCategoryID() {
    	$maincategories = $this->getMainCategories();
    	$cat = $maincategories->get(0)->getbusinessdirectorycategory()->getID();
    	$previouscat = isEmptyString($cat) ? '--' : $cat;
    	return isEmptyString($this->getCategoryID()) ? $previouscat : $this->getCategoryID();
    }
	# determine the sub categories for a category
	function getSubCategories() {
		$q = Doctrine_Query::create()
		->from('ContactCategory c')->innerJoin('c.businessdirectorycategory b')
		->where("c.contactid = '".$this->getID()."' AND b.parentid IS NOT NULL ")
		->orderby("b.name ASC");
		return $q->execute();
	}
	# determine the sub categories for a category
	function getMainCategories() {
		$q = Doctrine_Query::create()
		->from('ContactCategory c')->innerJoin('c.businessdirectorycategory b')
		->where("c.contactid = '".$this->getID()."' AND b.parentid IS NULL ")
		->orderby("b.name ASC");
		return $q->execute();
	}
	# determine if contact is a person
    function isPerson(){
    	return $this->getContactType() == '1' ? true : false; 
    }
	# determine if contact is a company
    function isCompany(){
    	return $this->getContactType() == '2' ? true : false; 
    }
}
?>
