<?php

class Address extends BaseEntity {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('address');
		$this->hasColumn('userid', 'integer', null);
		$this->hasColumn('farmgroupid', 'integer', null);
		$this->hasColumn('type', 'integer', null, array('default' => '1')); // 1 farmer, 2 farm group, 3 farm, 4 organisation
		
		$this->hasColumn('country', 'string', 2, array('default' => 'UG'));
		$this->hasColumn('districtid', 'integer', null);
		$this->hasColumn('countyid', 'integer', null);
		$this->hasColumn('subcountyid', 'integer', null);
		$this->hasColumn('parishid', 'integer', null);
		$this->hasColumn('villageid', 'integer', null);
		
		$this->hasColumn('streetaddress', 'string', 255);
		$this->hasColumn('city', 'string', 50);
		$this->hasColumn('state', 'string', 50);
		$this->hasColumn('zipcode', 'string', 15);
		$this->hasColumn('isprimary', 'integer', null, array('default' => '1'));		
	}
	/**
	 * Contructor method for custom initialization
	 */
	public function construct() {
		parent::construct();
		
	}
	/**
	 * Model relationships
	 */
	public function setUp() {
		parent::setUp();
		
		$this->hasOne('UserAccount as user', 
								array(
									'local' => 'userid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('FarmGroup as farmgroup', 
								array(
									'local' => 'farmgroupid',
									'foreign' => 'id'
								)
						);
		$this->hasOne('Location as district',
						 array(
								'local' => 'districtid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Location as county',
						 array(
								'local' => 'countyid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Location as subcounty',
						 array(
								'local' => 'subcountyid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Location as parish',
						 array(
								'local' => 'parishid',
								'foreign' => 'id'
							)
					); 
		$this->hasOne('Location as village',
						 array(
								'local' => 'villageid',
								'foreign' => 'id'
							)
					); 
	}
	/**
	 * Preprocess model data
	 */
	function processPost($formvalues){
		// set default values for integers, dates, decimals
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']); 
		}
		if(isArrayKeyAnEmptyString('farmgroupid', $formvalues)){
			unset($formvalues['farmgroupid']); 
		}
		if(isArrayKeyAnEmptyString('districtid', $formvalues)){
			unset($formvalues['districtid']); 
		}
		if(isArrayKeyAnEmptyString('countyid', $formvalues)){
			unset($formvalues['countyid']); 
		}
		if(isArrayKeyAnEmptyString('subcountyid', $formvalues)){
			unset($formvalues['subcountyid']); 
		}
		if(isArrayKeyAnEmptyString('parishid', $formvalues)){
			unset($formvalues['parishid']); 
		}
		if(isArrayKeyAnEmptyString('villageid', $formvalues)){
			unset($formvalues['villageid']); 
		}
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		}
		if(isArrayKeyAnEmptyString('isprimary', $formvalues)){
			unset($formvalues['isprimary']); 
		}
		
		parent::processPost($formvalues);
	}
	/**
	 * Return the user's full physical address
	 *
	 * @return String The full physical address
	 */
	function getFullAddress() {
		$textstring = "";
		
		return $textstring;
	}
	/**
	 * Get the full name of the state from the two digit code
	 * 
	 * @return String The full name of the state 
	 */
	function getStateName() {
		if(isEmptyString($this->getState())){
			$currentstate = "";
		}
		if(strlen(getStates() == '2')) {
			if($this->getCountry() == 'US'){
				$states = getStates(); 
				$currentstate = $states[$this->getState()];
			}
		} else {
			$currentstate = $this->getState();
		}
		
		return $currentstate; 
	}
	/**
	 * Get the full name of the country from the two digit code
	 * 
	 * @return String The full name of the state 
	 */
	function getCountryName() {
		if(isEmptyString($this->getCountry())){
			return "--";
		}
		$countries = getCountries(); 
		return $countries[$this->getCountry()];
	}
	function getVillageName() {
		$q = Doctrine_Query::create()->from('Village v')->where("v.id = '".$this->getID()."' ");
		$result = $q->execute();
		debugMessage($result->toArray());
		//return $result->getName();
	}
	# determine if is ugandan
    function isUgandan() {
    	return $this->getCountry() == 'UG' || isEmptyString($this->getCountry()) ? true : false; 
    }
	# determine if is kenyan
    function isKenyan() {
    	return $this->getCountry() == 'KE' ? true : false; 
    }
}
?>