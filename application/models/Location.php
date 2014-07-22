<?php
/**
 * Model for a location
 *
 */

class Location extends BaseEntity {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('location');
		$this->hasColumn('name', 'string', 255, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('description', 'string', 500);
		$this->hasColumn('locationtype', 'tinyint');
		// 1=Region, 2=District, 3=County, 4=Subcounty, 5=Parish, 6=Village, 7=Municipality
		$this->hasColumn('country', 'string', 2, array('default' => 'UG'));
		$this->hasColumn('regionid','integer', null, array('default' => NULL));
		$this->hasColumn('districtid','integer', null, array('default' => NULL));
		$this->hasColumn('countyid','integer', null, array('default' => NULL));
		$this->hasColumn('subcountyid','integer', null, array('default' => NULL));
		$this->hasColumn('parishid','integer', null, array('default' => NULL));
		$this->hasColumn('gpslat', 'string', 15);
		$this->hasColumn('gpslng', 'string', 15);
		$this->hasColumn('parishname', 'string', 255);
		$this->hasColumn('villagename', 'string', 255);
	}
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"name.notblank" => $this->translate->_("region_name_error")
       	       						));
	}
	public function setUp() {
		parent::setUp(); 
		# the relationships to the different location types
		$this->hasOne('Location as region',
						 array(
								'local' => 'regionid',
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
	}
	/*
	 * 
	 */
	function processPost($formvalues){
		// Custom processing for integer and enum fields
		if (!isArrayKeyAnEmptyString('name', $formvalues)) {
			$formvalues['name'] = trim($formvalues['name']);
		}
		if (isArrayKeyAnEmptyString('regionid', $formvalues)) {
			$formvalues['regionid'] = NULL;
		}
		if (isArrayKeyAnEmptyString('districtid', $formvalues)) {
			$formvalues['districtid'] = NULL;
		}
		if (isArrayKeyAnEmptyString('countyid', $formvalues)) {
			$formvalues['countyid'] = NULL;
		}
		if (isArrayKeyAnEmptyString('subcountyid', $formvalues)) {
			$formvalues['subcountyid'] = NULL;
		}
		if (isArrayKeyAnEmptyString('parishid', $formvalues)) {
			$formvalues['parishid'] = NULL;
		}
		if (isArrayKeyAnEmptyString('villageid', $formvalues)) {
			$formvalues['villageid'] = NULL;
		}
		// debugMessage($formvalues);
		parent::processPost($formvalues);
	}
	/*
	 * 
	 */
	function validate() {
		// execute validation in parent
		parent::validate();
		
		# check that region is unique for locationtype = 1
		if (!$this->locationExists()) {
			$this->getErrorStack()->add("name.unique", sprintf($this->translate->_("location_unique_name_label"), $this->getName()));
		}
	}
	/*
	 * Validate that the location name is unique depending on the location type 
	 */
	function locationExists() {
		// connection		
		$conn = Doctrine_Manager::connection();
		
		// query for check if location exists
		$unique_query = "SELECT id FROM location WHERE name = '".$this->getName()."' AND locationtype = '".$this->getLocationType()."' AND id <> '".$this->getID()."' ";
		$result = $conn->fetchOne($unique_query);
		//debugMessage($unique_query);
		//debugMessage($result);
		if(!isEmptyString($result)){ 
			return false;
		}
		
		return true;
	}
	
	/**
     * The current market prices for a district 
     * @param int $this->getID()
     * @return Array of lattest commodity prices 
     */
	function getMarketCurrentPrices() {
		$conn = Doctrine_Manager::connection();
		
		$all_results_query = "SELECT 
			  d.datecollected AS datecollected,
			  cd.`name`,
			  ROUND(AVG(d.retailprice), -2) AS `Retail Price`,
			  ROUND(AVG(d.wholesaleprice), -2) AS `Wholesale Price`
			FROM
			  price_details AS d 
			  INNER JOIN commodity cd ON d.`commodityid` = cd.`id`
			  INNER JOIN 
			    (SELECT 
			      cp.sourceid,
			      MAX(cp.datecollected) AS datecollected,
			      p.name 
			    FROM
			      price_details cp 
			      INNER JOIN price_submission AS cs1 
			        ON (
			          cp.`submissionid` = cs1.`id` 
			          AND cs1.`status` = 'Approved'
			        ) 
			      INNER JOIN pricesource AS p 
			        ON (
			          cp.sourceid = p.id 
			          AND p.`applicationtype` = 0 AND p.locationid = '".$this->getID()."'
			        ) 
			    WHERE cp.`pricecategoryid` = 2  
			    GROUP BY cp.sourceid) AS d2 
			    ON (
			      d.`sourceid` = d2.sourceid 
			      AND d.`datecollected` = d2.datecollected
			    ) 
			WHERE d.`pricecategoryid` = 2  
			GROUP BY d.`commodityid`
			ORDER BY cd.name ";
		
		// debugMessage($all_results_query);
		return $conn->fetchAll($all_results_query);
	}
	/**
     * The current fuel prices for a district 
     * @param int $this->getID(), int $commodityid
     * @return The lattest fuel prices in a district
     * 
     * TODO: Change this method to return an array of the latest fuel prices for all commodities in the fuel price category instead of running a
     * query for each commodity 
     */
	function getCurrentFuelPrices($commodityid) {
		$conn = Doctrine_Manager::connection();
		$all_results_query = "SELECT 
				ROUND(AVG(d.retailprice), -2) AS `Retail Price`, 		
				d.datecollected as datecollected, 
				d.sourceid as sourceid, 
				d2.name as `Market`, 
				d2.locationid as `districtid`, 
				d2.districtname as `District Name` 
				FROM price_details AS d 
				INNER JOIN ( SELECT cp.sourceid, 
								MAX(cp.datecollected) AS datecollected, 
								p.name, 
								p.locationid, 
								l.name as districtname 
								FROM price_details cp 
								INNER JOIN price_submission AS cs1 
								ON (cp.`submissionid` = cs1.`id` AND cs1.`status` = 'Approved') 
								INNER JOIN pricesource AS p ON (cp.sourceid = p.id AND p.`applicationtype` = 0 ) 
								INNER JOIN location AS l on (p.locationid = l.id AND l.locationtype = 2) 
								WHERE cp.`commodityid` = '".$commodityid."' AND cp.`pricecategoryid` = 4 GROUP BY cp.sourceid) AS d2 
				ON (d.`sourceid` = d2.sourceid AND d.`datecollected` = d2.datecollected) 
				WHERE d.`commodityid` = '".$commodityid."' AND d2.locationid = '".$this->getID()."' AND d.`pricecategoryid` = 4 
				GROUP BY d2.locationid ORDER BY d2.districtname";
		// debugMessage($all_results_query);
		return $conn->fetchOne($all_results_query);;
	}
	/**
     * The open selling offers
     * @param int $this->getID()
     * @return The lattest fuel prices in a district
     */
	function getOpenSellOffers() {
		$conn = Doctrine_Manager::connection();
		$all_results_query = "SELECT 
					o.id as `id`, 
					o.createdby as `createdby`, 
					c.name as `Commodity`, 
					 if(ISNULL(cu.name), o.quantity,concat(o.quantity,' ',cu.name)) as `Quantity`, 
					 FORMAT(price,0) as `Price`, 
					 DATE_FORMAT(o.datecreated, '%b %d, %Y') as `Date Posted`, 
					 DATE_FORMAT(o.expirydate, '%b %d, %Y') as `Expiry Date`, 
					 o.contact as `Contact`, 
					 o.telephone as `Telephone`, 
					 l.name as `District` 
					 FROM offer o 
					 INNER JOIN commodity c ON o.commodityid = c.id 
					 LEFT JOIN commodityunit cu ON c.unitid = cu.id 
					 INNER JOIN location l
					 WHERE o.locationid = l.id AND o.locationid = '".$this->getID()."' AND o.offertype = '1' AND TO_DAYS(NOW()) > TO_DAYS(o.expirydate)  
					 ORDER BY o.expirydate DESC ";
		// debugMessage($all_results_query);
		return $conn->fetchAll($all_results_query);;
	}
	# determine commodityid from searchable name
    function findByName($name, $type) {
    	$str_len = strlen($name);
    	trim($name);
    	$name = str_replace('district', '', strtolower($name));
    	
		$conn = Doctrine_Manager::connection();
		// query for check if location exists
		$unique_query = "SELECT id FROM location l WHERE l.name LIKE '%".$name."%' AND l.locationtype = '".$type."' ";
		$result = $conn->fetchOne($unique_query);
		// debugMessage($unique_query);
		// debugMessage($result);
		return $result; 
	}
	# determine if location is a region
	function isRegion(){
		return $this->getLocationType() == 1 ? true : false;
	}
	# determine if location is a district
	function isDistrict(){
		return $this->getLocationType() == 2 ? true : false;
	}
	# determine if location is a county
	function isCounty(){
		return $this->getLocationType() == 3 ? true : false;
	}
	# determine if location is a subcounty
	function isSubcounty(){
		return $this->getLocationType() == 4 ? true : false;
	}
	# determine if location is a parish
	function isParish(){
		return $this->getLocationType() == 5 ? true : false;
	}
	# determine if location is a village
	function isVillage(){
		return $this->getLocationType() == 6 ? true : false;
	}
	# determine if location has gps location so as to plot out their data
    function hasGPSCoordinates() {
    	return !isEmptyString($this->getGPSLat()) && !isEmptyString($this->getGPSLng()) ? true : false;
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
		$q = Doctrine_Query::create()->from('Location v')->where("v.id = '".$this->getID()."' ");
		$result = $q->execute();
		// debugMessage($result->toArray());
		//return $result->getName();
		return '';
	}
	function getTypeName() {
		$session = SessionWrapper::getInstance();
		$txt = "Location"; 
		switch($this->getLocationType()){
			case 1:
				$txt = "Region";
				break;
			case 2:
				$txt = "District";
				if(isKenya()){
					$txt = "County";
				}
				break;
			case 3:
				$txt = "Sub-county";
				if(isKenya()){
					$txt = "County";
				}
				break;
			case 4:
				$txt = "Ward";
				if(isKenya()){
					$txt = "Sub-county";
				}
				break;
			case 5:
				$plural = "Parishes";
				break;
			case 6:
				$txt = "Village";
				break;
			default:
				break;
		}
		return $txt;
	}
	/**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
    	$conn = Doctrine_Manager::connection();
   	 	$update = false;
		
  		$duplicates = $this->getDuplicates();
    	$countdup = $duplicates->count();
		if($countdup > 0){
			$duplicates->delete();
		}
		
    	return true;
    }
    function afterUpdate() {
    	return $this->afterSave();
    }
	# find duplicates after save
	function getDuplicates(){
		$q = Doctrine_Query::create()->from('Location l')->where("l.name = '".$this->getName()."' AND 
		l.regionid = '".$this->getRegionID()."' AND 
		l.districtid = '".$this->getDistrictID()."' AND 
		l.countyid = '".$this->getCountyID()."' AND 
		l.subcountyid = '".$this->getSubCountyID()."' AND 
		l.locationtype = '".$this->getLocationType()."' AND 
		l.id <> '".$this->getID()."' ");
		$result = $q->execute();
		return $result;
	}
	# determine if farmer is ugandan
    function isUgandan() {
    	return strtoupper($this->getCountry()) == 'UG' ? true : false; 
    }
	# determine if farmer is kenyan
    function isKenyan() {
    	return strtoupper($this->getCountry()) == 'KE' ? true : false; 
    }
}

?>