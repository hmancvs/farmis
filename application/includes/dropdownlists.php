<?php

	# This class require_onces functions to access and use the different drop down lists within
	# this application

	/**
	 * function to return the results of an options query as array. This function assumes that
	 * the query returns two columns optionvalue and optiontext which correspond to the corresponding key
	 * and values respectively. 
	 * 
	 * The selection of the names is to avoid name collisions with database reserved words
	 * 
	 * @param String $query The database query
	 * 
	 * @return Array of values for the query 
	 */
	function getOptionValuesFromDatabaseQuery($query) {
		$conn = Doctrine_Manager::connection(); 
		$result = $conn->fetchAll($query);
		$valuesarray = array();
		foreach ($result as $value) {
			$valuesarray[$value['optionvalue']]	= htmlentities($value['optiontext']);
		}
		return decodeHtmlEntitiesInArray($valuesarray);
	}
        # function to generate months
	function getAllMonths() {
		$months = array(
		"January" => "January",		
		"February" => "February",
		"March" => "March",
		"April" => "April",
		"May" => "May",		
		"June" => "June",
		"July" => "July",
		"August" => "August",
		"September" => "September",		
		"October" => "October",
		"November" => "November",
		"December" => "December"	
		);
		return $months;
	}
	
	# function to generate months
	function getAllMonthsAsNumbers() {
		$months = array(
		"01" => "January",		
		"02" => "February",
		"03" => "March",
		"04" => "April",
		"05" => "May",		
		"06" => "June",
		"07" => "July",
		"08" => "August",
		"09" => "September",		
		"10" => "October",
		"11" => "November",
		"12" => "December"	
		);
		return $months;
	}
	# split a date into day month and year
	function splitDate($date) {
		if(isEmptyString($date)){
			return array();
		}
		$date = date('Y-n-j',strtotime($date));
		$date_parts = explode('-', $date);
		// debugMessage($date_parts);
		return $date_parts;	
	}
	# function to generate months
	function getMonthsAsNumbers() {
		$months = array(
		"01" => "01",		
		"02" => "02",
		"03" => "03",
		"04" => "04",
		"05" => "05",		
		"06" => "06",
		"07" => "07",
		"08" => "08",
		"09" => "09",		
		"10" => "10",
		"11" => "11",
		"12" => "12"	
		);
		return $months;
	}
	# function to generate months short names
	function getAllMonthsAsShortNames() {
		$months = array(
		"1" => "Jan",		
		"2" => "Feb",
		"3" => "Mar",
		"4" => "Apr",
		"5" => "May",		
		"6" => "Jun",
		"7" => "Jul",
		"8" => "Aug",
		"9" => "Sept",		
		"10" => "Oct",
		"11" => "Nov",
		"12" => "Dec"	
		);
		return $months;
	}

	function getMonthName($number) {
		$months = getAllMonthsAsNumbers();
		return $months[$number];
	}
	
	# function to generate years
	function getAllYears($yearsback="", $yearsahead="") {				
		$aconfig = Zend_Registry::get("config"); 
		$years = array(); 
		$start_year = date("Y") - $aconfig->dateandtime->mindate;
		if(!isEmptyString($yearsback)){
			$start_year = date("Y") - $yearsback;
		}
		$end_year = date("Y") + $aconfig->dateandtime->maxdate;
		if(!isEmptyString($yearsahead)){
			$end_year = date("Y") + $yearsahead;
		}
		for($i = $start_year; $i <= $end_year; $i++) {
			$years[$i] = $i; 
		}		
		//return the years in descending order from the last year to the first and add true to maintain the array keys
		return array_reverse($years, true);
	}
	
	# function to generate future years
	function getFutureYears() {				
		$aconfig = Zend_Registry::get("config"); 
		$years = array(); 
		$start_year = date("Y");
		
		$end_year = date("Y") + $aconfig->dateandtime->mindate;
		for($i = $start_year; $i <= $end_year; $i++) {
			$years[$i] = $i; 
		}		
		//return the years in descending order from the last year to the first and add true to maintain the array keys
		return $years;
	}
        # function to generate years
	function getMultipleYears() {				
		$aconfig = Zend_Registry::get("config"); 
		$years = array(); 
		$start_year = date("Y") - $aconfig->dateandtime->mindateofbirth;
		
		$end_year = date("Y");
		for($i = $start_year; $i <= $end_year; $i++) {
			$years[$i] = $i; 
		}		
		//return the years in descending order from the last year to the first and add true to maintain the array keys
		return array_reverse($years, true);
	}
	 # function to generate years
	function getSubscribeBirthYears() {				
		$aconfig = Zend_Registry::get("config"); 
		$years = array(); 
		$start_year = (date("Y")) - 100;
		
		$end_year = (date("Y") - 18);
		for($i = $start_year; $i <= $end_year; $i++) {
			$years[$i] = $i; 
		}		
		//return the years in descending order from the last year to the first and add true to maintain the array keys
		return array_reverse($years, true);
	}
	# function to generate years
	function getMonthDays() {
		$days = array(); 
		$start_day = 1;
	
		$end_day = 31;
		for($i = $start_day; $i <= $end_day; $i++) {
			$days[$i] = $i; 
		}		
		//return the years in descending order from 2009 down to the start year and true to maintain the array keys
		return $days;
	}
	# get the first day of a month
	function getFirstDayOfMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month,1,$year));
	}
	# get the last day of a month
	function getLastDayOfMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month+1,0,$year));
	}
	# get the first day of current month
	function getFirstDayOfNextMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month,2,$year));
	}
	# get the last day of the next month
	function getLastDayOfNextMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month+2,0,$year));
	}
	# get the first day of last month
	function getFirstDayOfLastMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month,-1,$year));
	}
	# get the last day of the last month
	function getLastDayOfLastMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month-1,0,$year));
	}
	
	/**
	 * Return an array containing the 2 digit US state codes and names of the states
	 *
	 * @return Array Containing 2 digit state codes as the key, and the name of a US state as the value
	 */
	function getStates() {
		$state_list = array('AL'=>"Alabama",  
			'AK'=>"Alaska",  
			'AZ'=>"Arizona",  
			'AR'=>"Arkansas",  
			'CA'=>"California",  
			'CO'=>"Colorado",  
			'CT'=>"Connecticut",  
			'DE'=>"Delaware",  
			'DC'=>"District Of Columbia",  
			'FL'=>"Florida",  
			'GA'=>"Georgia",  
			'HI'=>"Hawaii",  
			'ID'=>"Idaho",  
			'IL'=>"Illinois",  
			'IN'=>"Indiana",  
			'IA'=>"Iowa",  
			'KS'=>"Kansas",  
			'KY'=>"Kentucky",  
			'LA'=>"Louisiana",  
			'ME'=>"Maine",  
			'MD'=>"Maryland",  
			'MA'=>"Massachusetts",  
			'MI'=>"Michigan",  
			'MN'=>"Minnesota",  
			'MS'=>"Mississippi",  
			'MO'=>"Missouri",  
			'MT'=>"Montana",
			'NE'=>"Nebraska",
			'NV'=>"Nevada",
			'NH'=>"New Hampshire",
			'NJ'=>"New Jersey",
			'NM'=>"New Mexico",
			'NY'=>"New York",
			'NC'=>"North Carolina",
			'ND'=>"North Dakota",
			'OH'=>"Ohio",  
			'OK'=>"Oklahoma",  
			'OR'=>"Oregon",  
			'PA'=>"Pennsylvania",  
			'RI'=>"Rhode Island",  
			'SC'=>"South Carolina",  
			'SD'=>"South Dakota",
			'TN'=>"Tennessee",  
			'TX'=>"Texas",  
			'UT'=>"Utah",  
			'VT'=>"Vermont",  
			'VA'=>"Virginia",  
			'WA'=>"Washington",  
			'WV'=>"West Virginia",  
			'WI'=>"Wisconsin",  
			'WY'=>"Wyoming");
		
		return $state_list; 
	}
	/**
	 * Return full name of a US state
	 *
	 * @return String Name of state
	 */
	function getFullStateName($state) {
		$statesarray = getStates();
		return $statesarray[$state];
	}
	/**
	 * Return an array containing the countries in the world
	 *
	 * @return Array Containing 2 digit country codes as the key, and the name of a couuntry as the value
	 */
	function getCountries(){
		$country_list = array(
			"GB" => "United Kingdom",
			"US" => "United States",
			"AF" => "Afghanistan",
			"AL" => "Albania",
			"DZ" => "Algeria",
			"AS" => "American Samoa",
			"AD" => "Andorra",
			"AO" => "Angola",
			"AI" => "Anguilla",
			"AQ" => "Antarctica",
			"AG" => "Antigua And Barbuda",
			"AR" => "Argentina",
			"AM" => "Armenia",
			"AW" => "Aruba",
			"AU" => "Australia",
			"AT" => "Austria",
			"AZ" => "Azerbaijan",
			"BS" => "Bahamas",
			"BH" => "Bahrain",
			"BD" => "Bangladesh",
			"BB" => "Barbados",
			"BY" => "Belarus",
			"BE" => "Belgium",
			"BZ" => "Belize",
			"BJ" => "Benin",
			"BM" => "Bermuda",
			"BT" => "Bhutan",
			"BO" => "Bolivia",
			"BA" => "Bosnia And Herzegowina",
			"BW" => "Botswana",
			"BV" => "Bouvet Island",
			"BR" => "Brazil",
			"IO" => "British Indian Ocean Territory",
			"BN" => "Brunei Darussalam",
			"BG" => "Bulgaria",
			"BF" => "Burkina Faso",
			"BI" => "Burundi",
			"KH" => "Cambodia",
			"CM" => "Cameroon",
			"CA" => "Canada",
			"CV" => "Cape Verde",
			"KY" => "Cayman Islands",
			"CF" => "Central African Republic",
			"TD" => "Chad",
			"CL" => "Chile",
			"CN" => "China",
			"CX" => "Christmas Island",
			"CC" => "Cocos (Keeling) Islands",
			"CO" => "Colombia",
			"KM" => "Comoros",
			"CG" => "Congo",
			"CD" => "Congo, The Democratic Republic Of The",
			"CK" => "Cook Islands",
			"CR" => "Costa Rica",
			"CI" => "Cote D'Ivoire",
			"HR" => "Croatia (Local Name: Hrvatska)",
			"CU" => "Cuba",
			"CY" => "Cyprus",
			"CZ" => "Czech Republic",
			"DK" => "Denmark",
			"DJ" => "Djibouti",
			"DM" => "Dominica",
			"DO" => "Dominican Republic",
			"TP" => "East Timor",
			"EC" => "Ecuador",
			"EG" => "Egypt",
			"SV" => "El Salvador",
			"GQ" => "Equatorial Guinea",
			"ER" => "Eritrea",
			"EE" => "Estonia",
			"ET" => "Ethiopia",
			"FK" => "Falkland Islands (Malvinas)",
			"FO" => "Faroe Islands",
			"FJ" => "Fiji",
			"FI" => "Finland",
			"FR" => "France",
			"FX" => "France, Metropolitan",
			"GF" => "French Guiana",
			"PF" => "French Polynesia",
			"TF" => "French Southern Territories",
			"GA" => "Gabon",
			"GM" => "Gambia",
			"GE" => "Georgia",
			"DE" => "Germany",
			"GH" => "Ghana",
			"GI" => "Gibraltar",
			"GR" => "Greece",
			"GL" => "Greenland",
			"GD" => "Grenada",
			"GP" => "Guadeloupe",
			"GU" => "Guam",
			"GT" => "Guatemala",
			"GN" => "Guinea",
			"GW" => "Guinea-Bissau",
			"GY" => "Guyana",
			"HT" => "Haiti",
			"HM" => "Heard And Mc Donald Islands",
			"VA" => "Holy See (Vatican City State)",
			"HN" => "Honduras",
			"HK" => "Hong Kong",
			"HU" => "Hungary",
			"IS" => "Iceland",
			"IN" => "India",
			"ID" => "Indonesia",
			"IR" => "Iran (Islamic Republic Of)",
			"IQ" => "Iraq",
			"IE" => "Ireland",
			"IL" => "Israel",
			"IT" => "Italy",
			"JM" => "Jamaica",
			"JP" => "Japan",
			"JO" => "Jordan",
			"KZ" => "Kazakhstan",
			"KE" => "Kenya",
			"KI" => "Kiribati",
			"KP" => "Korea, Democratic People's Republic Of",
			"KR" => "Korea, Republic Of",
			"KW" => "Kuwait",
			"KG" => "Kyrgyzstan",
			"LA" => "Lao People's Democratic Republic",
			"LV" => "Latvia",
			"LB" => "Lebanon",
			"LS" => "Lesotho",
			"LR" => "Liberia",
			"LY" => "Libyan Arab Jamahiriya",
			"LI" => "Liechtenstein",
			"LT" => "Lithuania",
			"LU" => "Luxembourg",
			"MO" => "Macau",
			"MK" => "Macedonia, Former Yugoslav Republic Of",
			"MG" => "Madagascar",
			"MW" => "Malawi",
			"MY" => "Malaysia",
			"MV" => "Maldives",
			"ML" => "Mali",
			"MT" => "Malta",
			"MH" => "Marshall Islands",
			"MQ" => "Martinique",
			"MR" => "Mauritania",
			"MU" => "Mauritius",
			"YT" => "Mayotte",
			"MX" => "Mexico",
			"FM" => "Micronesia, Federated States Of",
			"MD" => "Moldova, Republic Of",
			"MC" => "Monaco",
			"MN" => "Mongolia",
			"MS" => "Montserrat",
			"MA" => "Morocco",
			"MZ" => "Mozambique",
			"MM" => "Myanmar",
			"NA" => "Namibia",
			"NR" => "Nauru",
			"NP" => "Nepal",
			"NL" => "Netherlands",
			"AN" => "Netherlands Antilles",
			"NC" => "New Caledonia",
			"NZ" => "New Zealand",
			"NI" => "Nicaragua",
			"NE" => "Niger",
			"NG" => "Nigeria",
			"NU" => "Niue",
			"NF" => "Norfolk Island",
			"MP" => "Northern Mariana Islands",
			"NO" => "Norway",
			"OM" => "Oman",
			"PK" => "Pakistan",
			"PW" => "Palau",
			"PA" => "Panama",
			"PG" => "Papua New Guinea",
			"PY" => "Paraguay",
			"PE" => "Peru",
			"PH" => "Philippines",
			"PN" => "Pitcairn",
			"PL" => "Poland",
			"PT" => "Portugal",
			"PR" => "Puerto Rico",
			"QA" => "Qatar",
			"RE" => "Reunion",
			"RO" => "Romania",
			"RU" => "Russian Federation",
			"RW" => "Rwanda",
			"KN" => "Saint Kitts And Nevis",
			"LC" => "Saint Lucia",
			"VC" => "Saint Vincent And The Grenadines",
			"WS" => "Samoa",
			"SM" => "San Marino",
			"ST" => "Sao Tome And Principe",
			"SA" => "Saudi Arabia",
			"SN" => "Senegal",
			"SC" => "Seychelles",
			"SL" => "Sierra Leone",
			"SG" => "Singapore",
			"SK" => "Slovakia (Slovak Republic)",
			"SI" => "Slovenia",
			"SB" => "Solomon Islands",
			"SO" => "Somalia",
			"ZA" => "South Africa",
			"GS" => "South Georgia, South Sandwich Islands",
			"ES" => "Spain",
			"LK" => "Sri Lanka",
			"SH" => "St. Helena",
			"PM" => "St. Pierre And Miquelon",
			"SD" => "Sudan",
			"SR" => "Suriname",
			"SJ" => "Svalbard And Jan Mayen Islands",
			"SZ" => "Swaziland",
			"SE" => "Sweden",
			"CH" => "Switzerland",
			"SY" => "Syrian Arab Republic",
			"TW" => "Taiwan",
			"TJ" => "Tajikistan",
			"TZ" => "Tanzania, United Republic Of",
			"TH" => "Thailand",
			"TG" => "Togo",
			"TK" => "Tokelau",
			"TO" => "Tonga",
			"TT" => "Trinidad And Tobago",
			"TN" => "Tunisia",
			"TR" => "Turkey",
			"TM" => "Turkmenistan",
			"TC" => "Turks And Caicos Islands",
			"TV" => "Tuvalu",
			"UG" => "Uganda",
			"UA" => "Ukraine",
			"AE" => "United Arab Emirates",
			"UM" => "United States Minor Outlying Islands",
			"UY" => "Uruguay",
			"UZ" => "Uzbekistan",
			"VU" => "Vanuatu",
			"VE" => "Venezuela",
			"VN" => "Viet Nam",
			"VG" => "Virgin Islands (British)",
			"VI" => "Virgin Islands (U.S.)",
			"WF" => "Wallis And Futuna Islands",
			"EH" => "Western Sahara",
			"YE" => "Yemen",
			"YU" => "Yugoslavia",
			"ZM" => "Zambia",
			"ZW" => "Zimbabwe"
		);
		return $country_list;
	}
	/**
	 * Return full name of a country
	 *
	 * @return String Name of country
	 */
	function getFullCountryName($countrycode) {
		$countriesarray = getCountries();
		return $countriesarray[$countrycode];
	}
	# function to generate ethinicity dropdown list 
	function getEthinicities(){
		$ethn_list = array(
			"1" => "Afghan",
			"2" => "Albanian",
			"3" => "Algerian",
			"4" => "American",
			"5" => "Andorran",
			"6" => "Angolan",
			"7" => "Antiguans",
			"8" => "Argentinean",
			"9" => "Armenian",
			"10" => "Australian"
		);
		return $ethn_list;
	}
	/**
	 * Return an array containing the 2 digit US state codes and names of the states
	 *
	 * @return Array Containing 2 digit state codes as the key, and the name of a US state as the value
	 */
	function getLanguages() {
		$country_list = array(
				"1" => "English",
				"2" => "Luganda",
				"3" => "Lusoga",
				"10" => "Acholi",
				"11" => "Afrikaans",
				"12" => "Akan",
				"13" => "Albanian",
				"14" => "American Sign Language",
				"15" => "Amharic",
				"16" => "Arabic",
				"17" => "Armenian",
				"18" => "Assyrian",
				"19" => "Azerbaijani",
				"20" => "Azeri",
				"21" => "Bajuni",
				"22" => "Bambara",
				"23" => "Basque",
				"24" => "Behdini",
				"25" => "Belorussian",
				"26" => "Bengali",
				"27" => "Berber",
				"28" => "Bosnian",
				"29" => "Bravanese",
				"30" => "Bulgarian",
				"31" => "Burmese",
				"32" => "Cantonese",
				"33" => "Catalan",
				"34" => "Chaldean",
				"35" => "Chaochow",
				"36" => "Chamorro",
				"37" => "Chavacano",
				"38" => "Cherokee",
				"39" => "Chuukese",
				"40" => "Croatian",
				"41" => "Czech",
				"42" => "Dakota",
				"43" => "Danish",
				"44" => "Dari",
				"45" => "Dinka",
				"46" => "Diula",
				"47" => "Dutch",
				"48" => "Ewe",
				"49" => "Farsi",
				"50" => "Fijian Hindi",
				"51" => "Finnish",
				"52" => "Flemish",
				"53" => "French",
				"54" => "French Canadian",
				"55" => "Fukienese",
				"56" => "Fula",
				"57" => "Fulani",
				"58" => "Fuzhou",
				"59" => "Gaddang"
			);
		
		return $country_list; 
	}
	/**
	 * Get the districts in the specified region 
	 * 
	 * @param Integer $regionid The id of the region 
	 * 
	 * @return Array  
	 */
	function getDistrictsInRegion($regionid) {
		if (isEmptyString($regionid)) {
			return array(); 
		}
		$query = "SELECT id as optionvalue, name as optiontext FROM location WHERE regionid = '".$regionid."' AND locationtype = 2 ORDER BY optiontext"; 
		return getOptionValuesFromDatabaseQuery($query);
	}
	/**
	 * Get the Counties in the specified region 
	 * 
	 * @param Integer $districtid The id of the district 
	 * 
	 * @return Array  
	 */
	function getCountiesInDistrict($districtid) {
		if (isEmptyString($districtid)) {
			return array(); 
		}
		$query = "SELECT id as optionvalue, name as optiontext FROM location WHERE districtid = '".$districtid."' AND locationtype = 3 ORDER BY optiontext";
		// debugMessage($query);
		return getOptionValuesFromDatabaseQuery($query);
	}
	/**
	 * Get the Sub-Counties in the specified County 
	 * 
	 * @param Integer $countyid The id of the county 
	 * 
	 * @return Array  
	 */
	function getSubcountiesInCounty($countyid) {
		if (isEmptyString($countyid)) {
			return array(); 
		}
		$query = "SELECT id as optionvalue, name as optiontext FROM location WHERE countyid = '".$countyid."' AND locationtype = 4 ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($query);
	}
	/**
	 * Get the Parishes in the specified Sub-County 
	 * 
	 * @param Integer $subcountyid The id of the sub-county 
	 * 
	 * @return Array  
	 */
	function getParishesInSubCounty($subcountyid) {
		if (isEmptyString($subcountyid)) {
			return array(); 
		}
		$query = "SELECT id as optionvalue, name as optiontext FROM location WHERE subcountyid = '".$subcountyid."' AND locationtype = 5 ORDER BY optiontext";		
		return getOptionValuesFromDatabaseQuery($query);
	}
	/**
	 * Get the Villages in the specified Parish
	 * 
	 * @param Integer $parishid The id of the parish
	 * 
	 * @return Array  
	 */
	function getVillagesInParishes($parishid) {
		if (isEmptyString($parishid)) {
			return array(); 
		}
		$query = "SELECT id as optionvalue, name as optiontext FROM location WHERE parishid = '".$parishid."' AND locationtype = 6 ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($query);
	}
	/**
	 * Get the sub-counties in the specified district
	 * 
	 * @param Integer $districtid - the id of the district
	 * 
	 * @return Array  
	 */
	function getSubcountiesInDistrict($districtid) {
		if (isEmptyString($districtid)) {
			return array(); 
		}
		$query = "SELECT id as optionvalue, name as optiontext FROM location WHERE districtid = '".$districtid."' AND locationtype = 4 ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($query);
	}
	/**
	 * Get the parishes in the specified district
	 *
	 * @param Integer $districtid - the id of the district
	 *
	 * @return Array
	 */
	function getParishesInDistrict($districtid) {
	    if (isEmptyString($districtid)) {
	        return array();
	    }
	    $query = "SELECT id as optionvalue, name as optiontext FROM location WHERE districtid = '".$districtid."' AND locationtype = 5 ORDER BY optiontext";
	    return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the subgroups in a farmgroup
	function getSubGroups($farmgroupid) {
	    if(isEmptyString($farmgroupid)) {
	        return array();
	    }
	    $query = "SELECT id as optionvalue, orgname as optiontext FROM farmgroup WHERE parentid = '".$farmgroupid."' ORDER BY optiontext";
	    return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the education levels 
	function getAllEducationLevels(){
		return array('1'=>'Degree', '2'=>'Diploma', '8'=>'Institution', '3'=>'A-Level', '4'=>'0-Level', '5'=>'P.7', '7'=>'Less than P.7', '6'=>'None');
	}
	# determine the marital statuses 
	function getAllMaritalStatuses(){
		return array('1'=>'Married', '2'=>'Single', '3'=>'Divorced', '4'=>'Widowed');
	}
	# determine the list of farm group types
	function getFarmGroupTypes(){
		return array('1'=>'DFA', '3'=>'Cooperative Society', '2'=>'NGO', '4'=>'SACCO','5'=>'Organization');
	}
	# determine the available farm groups
	function getAllFarmGroups() {
		$query = "SELECT id as optionvalue, orgname as optiontext FROM farmgroup WHERE id <> '' AND parentid is null ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the available farm groups
	function getFarmGroupsInDistrict($districtid) {
		$query = "SELECT f.id as optionvalue, f.orgname as optiontext FROM farmgroup f left join address a on (a.farmgroupid = f.id) WHERE a.districtid = '".$districtid."' GROUP BY f.id ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($query);
	}
	/**
	* Return the statistics 
	*/
	function getAllStatisticUnits(){
		$valuesquery = "SELECT u.id AS optionvalue, u.`name` as optiontext FROM commodityunit as u WHERE u.type = 2 ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	/**
	* Return the statistics 
	*/
	function getAllStandardUnits(){
		$valuesquery = "SELECT u.id AS optionvalue, u.`name` as optiontext FROM commodityunit as u WHERE u.type = 1 ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	/**
	* Return the yield measures 
	*/
	function getAllYieldMeasures(){
		$valuesquery = "SELECT u.id AS optionvalue, u.`name` as optiontext FROM commodityunit as u WHERE u.type = 4 ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	/**
	* Return the yield measures 
	*/
	function getAllInputUnits(){
		$valuesquery = "SELECT u.id AS optionvalue, u.`name` as optiontext FROM commodityunit as u WHERE u.type = 3 ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	/**
	* Return the yield measures 
	*/
	function getAllOutputUnits(){
		$valuesquery = "SELECT u.id AS optionvalue, u.`name` as optiontext FROM commodityunit as u WHERE u.type = 5 ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# Return the contact categories at level 1
	function getTopLevelCategories($categoryid){
		$custom_query = '';
		if(!isEmptyString($categoryid)){
			$custom_query = " AND c.parentid = '".$categoryid."' ";
		}
		$valuesquery = "SELECT b.id AS optionvalue, b.name as optiontext FROM businessdirectorycategory as b WHERE b.parentid IS NULL ".$custom_query." ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# Return the contact sub categories
	function getAllSubCategories($categoryid){
		$custom_query = '';
		if(!isEmptyString($categoryid)){
			$custom_query = " AND c.parentid = '".$categoryid."' ";
		}
		$valuesquery = "SELECT b.id AS optionvalue, b.name as optiontext FROM businessdirectorycategory as b WHERE b.parentid IS NOT NULL ".$custom_query." ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# land measure units
	function getLandMeasureUnits(){
		return array("1"=>"Acres","2"=>"Hectares");
	}
	# land acquire methods
	function getLandAcquireMethods(){
		return array("1"=>"Personal","2"=>"Hired","3"=>"Leased");
	}
	# status values
	function getStatusValues(){
		return array("1"=>"Not Started","2"=>"In Progress","3"=>"Completed");
	}
	# commodities configured for farmis 
	function getFarmisCommodities($ignore_list = array()){
		$customquery = '';
		if(is_array($ignore_list) && count($ignore_list) > 0){
			$list = implode("','", $ignore_list);
			$customquery = " AND c.id NOT IN('".$list."') ";
		}
		$valuesquery = "SELECT c.id AS optionvalue, c.`name` as optiontext FROM commodity as c WHERE c.allowfarmer = 1 ".$customquery." ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# commodities configured for a farmer 
	function getCommoditiesForFarmer($farmerid){
		$valuesquery = "SELECT fc.cropid AS optionvalue, c.`name` as optiontext FROM farmcrop fc inner join commodity c on (fc.cropid = c.id) WHERE fc.farmerid = '".$farmerid."' GROUP BY fc.cropid ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# commodities configured for farmis 
	function getSeasonCommodities($seasonid){
		$valuesquery = "SELECT s.cropid AS optionvalue, c.`name` as optiontext FROM seasondetail as s inner join commodity as c on (s.cropid = c.id) WHERE s.seasonid = ".$seasonid." ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# production input types
	function getAllInputTypes(){
		$values = array("2"=> "Machinery", "1"=> "Seeds", "5"=> "Herbicide", "3"=> "Insectcide", "4"=> "Fungicide", "6"=> "Fertiliser", "7"=>"Farm Equipment");
		asort($values);
		return $values;
	}
	# production input types
	function getAllExpenseTypes(){
		$values = array("8"=>"Other", "9"=>"Transport", "10"=>"Labour","11"=>"Botany Services","12"=>"Consultancy","13"=>"Rent","14"=>"Training","15"=>"Salaries","16"=>"Allowances","17"=>"Brokrage");
		asort($values);
		return $values;
	}
	# methods of tillage
	function getTillageMethods(){
		$values = array("1"=>"Chem Fallow", "2"=>"Conservation Till", "4"=>"Minimum Till", "5"=>"Mulch Till", "6"=>"No Till", "7"=>"Ridge Till", "8"=>"Roll Till", "9"=>"Strip Till", "10"=>"Zone Till", "11"=>"Other");
		asort($values);
		return $values;
	}
	# primary tillage methods
	function getPrimaryTillageMethods(){
		$values = array("1" => "Wooden plough", "2"=>"Indigenous plough", "3"=>"Soil Turning Ploughs", "4"=>"Mouldboard Plough", "5"=>"One way Disc", "6"=>"Offset disc", "7"=>"Tine Implement", "8"=>"Disc Plough", "9"=>"One-way Plough", "10"=>"Subsoil Plough", "11"=>"Chisel Plough", "12"=>"Ridge Plough", "13"=>"Rotary Plough", "14"=>"Basin Lister", "15"=>"Other");
		asort($values);
		return $values;
	}
	# secondary tillage methods
	function getSecondaryTillageMethods(){
		$values = array("1"=>"Tractor Drawn Cultivator", "2"=>"Sweep Cultivator", "3"=>"Harrows", "4"=>"Disc Harrow", "5"=>"Blade Harrow", "6"=>"Indigenous Blade Harrows", "7"=>"Plank and Roller", "8"=>"Country plough", "9"=>" Ridge plough", "10"=>"Bund former", "11"=>"Peg tooth harrow", "12"=>"Disc cultivator", "13"=>"Tined cultivator", "14"=>"Rotovator", "15"=>"Other");
		asort($values);
		return $values;
	}
	# methods of tillage
	function getDepthUnits(){
		$values = array("1"=>"Feet", "2"=>"Inches", "3"=>"Millimeters", "4"=>"Centimeters", "5"=>"Yards");
		ksort($values);
		return $values;
	}
	# seeding rate units
	function getSeedingUnits(){
		$values = array("1"=>"Seeds/SqFeet", "2"=>"Seeds/SqMeter", "3"=>"Seeds/SqYard", "4"=>"Seeds/Acre");
		ksort($values);
		return $values;
	}
	# seeding rate units
	function getSeedingTotalUnits(){
		$values = array("1"=>"Seeds", "4"=>"Other");
		ksort($values);
		return $values;
	}
	# field area units
	function getAreaUnits(){
		$values = array("1"=>"SqFeet", "2"=>"SqMeters", "3"=>"SqYards", "4"=>"Acres", "5"=>"Hectares");
		asort($values);
		return $values;
	}
	# planting methods
	function getPlantingMethods(){
		$values = array("1"=>"Broadcasting", "2"=>"Seedbedding", "3"=>"Pre-sowing", "4"=>"Open-fielding", "5"=>"Dibbling", "6"=>"Transplanting", "7"=>"Other");
		asort($values);
		return $values;
	}
	# treatment types
	function getTreatmentChemicalTypes(){
		$values = array("1"=>"Type 1", "2"=>"Type 2", "3"=>"Type 3", "4"=>"Other");
		ksort($values);
		return $values;
	}
	# treatment methods
	function getTreatmentMethods(){
		$values = array("1"=>"1/128th Acre Method", "2"=>"5940 Method", "3"=>"Overall Broadcast Spray", "4"=>"Foliar", "5"=>"Stump Treatment", "6"=>"Basal Bark", "7"=>"Spot Sprays", "8"=>"Wiping Treatments", "9"=>"1 Inch away", "10"=>"2 Inch away", "11"=>"Aerial", "12"=>"Air Blast", "13"=>"Backpack Spray", "14"=>"Band", "15"=>"Banding", "16"=>"Broadcast", "17"=>"Chemigation", "18"=>"Co-Application", "19"=>"Electro-static", "20"=>"Fertigation", "21"=>"Ground", "22"=>"Hooded Sprayer", "23"=>"Impregnate", "24"=>"In Furrow", "25"=>"Injected", "26"=>"Mis-Application", "27"=>"Planter", "28"=>"Rope Wick", "29"=>"SideDress", "30"=>"Surface", "31"=>"T Band", "32"=>"Other");
		asort($values);
		return $values;
	}
	# treatment units
	function getTreatmentMeasureUnits(){
		$values = array("1"=>"Ltrs/SqFeet", "2"=>"MLtrs/SqFeet", "3"=>"cc/SqFeet", "4"=>"Ltrs/SqMeter", "5"=>"MLtrs/SqMeter", "6"=>"cc/SqMeter", "8"=>"Kgs/SqFeet", "9"=>"grams/SqFeet", "10"=>"Kgs/SqMeter", "11"=>"grams/SqMeter", "7"=>"Other");
		ksort($values);
		return $values;
	}
	# treatment units
	function getTreatmentTotalUnits(){
		$values = array("1"=>"Ltrs", "2"=>"MLtrs", "3"=>"cc", "4"=>"Gallons", "5"=>"Kgs", "6"=>"grams", "7"=>"Other");
		ksort($values);
		return $values;
	}
	# application timing values 
	function getTimingValues(){
		$values = array("1"=>"Pre Planting", "2"=>"Planting", "3"=>"Dormancy", "4"=>"Pre Harvest", "5"=>"Post Harvest", "6"=>"Mid Season", "7"=>"Burndown", "8"=>"PreEmerge", "9"=>"PostEmerge", "10"=>"PreFlood", "11"=>"Layby", "12"=>"Other");
		ksort($values);
		return $values;
	}
	# treatment sub types
	function getTreatmentSubTypes(){
		$values = array("1"=>"Type 1", "2"=>"Type 2", "3"=>"Type 3", "4"=>"Other");
		asort($values);
		return $values;
	}
	# treatment sub types
	function getTreatmentTypes(){
		$values = array("1"=>"Algicide", "2"=>"AntiMicrobial", "3"=>"Attractant", "4"=>"Biopesticide", "5"=>"Biocide", "6"=>"Disinfectant", "7"=>"Fungicide", "8"=>"Fumigant", "9"=>"Herbicide", "10"=>"Insecticide", "11"=>"Miticides", "12"=>"Molluscicide", "13"=>"Nematicide", "14"=>"Ovicide", "15"=>"Pheromone", "16"=>"Repellant", "17"=>"Rodenticide", "18"=>"Defoliant", "19"=>"Desiccant", "20"=>"Growth Regulator", "21"=>"Other");
		asort($values);
		return $values;
	}
	# treatment types
	function getTreatmentForms(){
		$values = array("1"=>"Liquid", "2"=>"Solid", "3"=>"Other");
		asort($values);
		return $values;
	}
	# harvest yield rate
	function getHarvestYieldUnits(){
		$values = array("1"=>"kgs/acre", "2"=>"kgs/hectare", "3"=>"tonnes/Kg", "4"=>"tonnes/hectare", "5"=>"bags/acre","6"=>"bags/hectare");
		ksort($values);
		return $values;
	}
	# harvest quantity yield rate
	function getHarvestQuantityUnits(){
		$values = array("1"=>"kgs", "2"=>"grammes", "3"=>"tonnes", "4"=>"bags", "5"=>"pieces");
		ksort($values);
		return $values;
	}
	# harvest quantity yield rate
	function getHarvestMethods(){
		$values = array("1"=>"Manual harvesting", "2"=>"Machine threshing", "3"=>"Machine reaping", "4"=>"Combined harvesting");
		asort($values);
		return $values;
	}
	# sale to types
	function getSaleToTypes(){
		$values = array("1"=>"Broker", "2"=>"Transporter", "3"=>"Wholesaler", "4"=>"Retailer", "5"=>"Family", "6"=>"Institution", "7"=>"Farm Group", "8"=>"Other");
		asort($values);
		return $values;
	}
	# types of inventory
	function getInventoryTypes(){
		$values = array("1"=>"Assest Inventory", "2"=>"Production Inventory", "3"=>"Output Inventory");
		// asort($values);
		return $values;
	}
	# categories of inventory
	function getInventoryCategories(){
		$values = array("1"=>"Cat 1", "2"=>"Other");
		// asort($values);
		return $values;
	}
	# types of services for inventory
	function getServiceTypes(){
		$values = array("1"=>"Repair", "2"=>"Standard", "3"=>"Warranty", "4"=>"Other");
		asort($values);
		return $values;
	}
	# sources of loans for financing season activities
	function getCapitalSources(){
		$values = array(
			"1"=>"Own Cash (personal income)", 
			"2"=>"Savings from previous season", 
			"3"=>"Soft loan", 
			"4"=>"Bank loan (credit)",
			"5"=>"Crop finance (farming contract)"
		);
		// asort($values);
		return $values;
	}
	function getActivityFinanceSources($type){
		if($type == '1' || isEmptyString($type)){
			$values = array(
				"1"=>"Current Season Capital", 
				"3"=>"Soft loan", 
				"4"=>"Bank loan (credit)",
				"5"=>"Crop finance (farming contract)"
			);
		}
		if($type == '2'){
			$values = array(
				"1"=>"Current Season Capital", 
				"3"=>"New Soft loan", 
				"4"=>"New Bank loan (credit)",
				"5"=>"New Crop Finance Contract"
			);
		}
		// asort($values);
		return $values;
	}
	# loan payback frequency
	function getLoanFrequencyValues(){
		$values = array(
			"1"=>"Years", 
			"2"=>"Months", 
			"3"=>"Weeks", 
			"4"=>"Days"
		);
		// asort($values);
		return $values;
	}
	# loan payback frequency
	function getLoanRepaymentFrequencyValues(){
		$values = array(
			"1"=>"Year", 
			"2"=>"Month", 
			"3"=>"Week", 
			"4"=>"Day"
		);
		// asort($values);
		return $values;
	}
	# available credit financial institutions
	function getAllFinancialInstitutions(){
		$values = array(
			"1"=>"Equity Bank", 
			"2"=>"Pride Microfinance", 
			"3"=>"Centenary Bank", 
			"4"=>"Opportunity Uganda",
			"5"=>"Post Bank",
			"6"=>"Finca Uganda",
			"7"=>"Standard Chartered Bank",
			"8"=>"Stanbic Bank",
			"9"=>"Bank of Africa",
			"10"=>"Housing Finance"
		);
		ksort($values);
		return $values;
	}
	function getAllClients(){
		$values = array(
			"1"=>"Mukwano", 
			"2"=>"Harvest Plus", 
			"3"=>"Vedco", 
			"4"=>"Other"
		);
		ksort($values);
		return $values;
	}
	function getAllSeasons($farmid){
		$custom_query = '';
		if(!isEmptyString($farmid)){
			$custom_query = " AND s.farmid = '".$farmid."' ";
		}
		$valuesquery = "SELECT s.id AS optionvalue, concat(s.ref, ' - ', s.activityname) as optiontext FROM season as s WHERE s.id <> '' ".$custom_query." ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# determine signup contact categories
	function getContactUsCategories(){
		$array = array('Feedback'=>'Feedback', 'Ask a Question'=>'Ask a Question', 'Submit a Bug'=>'Submit a Bug', 'Sign up Problems'=>'Sign up Problems', 'Account compromised'=>'Account compromised', 'Failed to Login'=>'Failed to Login');
		ksort($array);
		$array['Other'] = 'Other';
		return $array;
	}
	function getPricingTypes(){
		$values = array(
			"1"=>"Farm Gate Price", 
			"2"=>"Assembly Market Price", 
			"3"=>"Store Price",
			"4"=>"Wholesale Price", 
			"5"=>"Retail Price"
		);
		// asort($values);
		return $values;
	}
	function getFarmers($farmgroupid = ''){
		$custom_query = '';
		if(!isEmptyString($farmgroupid)){
			$farmgroup = new FarmGroup(); 
			$farmgroup->populate($farmgroupid);
			$manegerid = $farmgroup->getManagerID();
			$custom_query = " AND f.farmgroupid = '".$farmgroupid."' AND f.id <> '".$manegerid."'";
		}
		$valuesquery = "SELECT f.id AS optionvalue, concat(f.firstname, ' ', f.lastname) as optiontext FROM farmer as f WHERE f.id <> '' ".$custom_query." ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# farming types practised
	function getFarmingTypes(){
		$values = array(
			"1"=>"Subsistance Farming", 
			"2"=>"Commercial Farming", 
			"3"=>"Ranching", 
			"4"=>"Dry and Irrigated Farming",
			"5"=>"Mixed Farming",
			"6"=>"Single Crop Farming",
			"7"=>"Multi-crop Farming",
			"8"=>"Diversified Farming",
			"9"=>"Specialised Farming",
			"10"=>"Shifting Cultivation"
		);
		asort($values);
		return $values;
	}
	# support types received by farmer
	function getSupportTypes(){
		$values = array(
			"1"=>"Farming Inputs", 
			"2"=>"Loans", 
			"3"=>"Training", 
			"4"=>"Market Research",
			"5"=>"Advertising",
			"6"=>"Market Information",
			"7"=>"Advisory Services",
			"8"=>"Brokerage",
			"9"=>"Farming Equipment",
			"10"=>"Saving Scheme"
		);
		asort($values);
		return $values;
	}
	# income generateing activities
	function getOtherActivityTypes(){
		$values = array(
			"1"=>"Poultry", 
			"2"=>"Fishing", 
			"3"=>"Trading", 
			"4"=>"Livestock",
			"5"=>"Piggery"
		);
		asort($values);
		return $values;
	}
	# farming tools 
	function getFarmingTools(){
		$values = array(
			"1"=>"Hoe", 
			"2"=>"Spade", 
			"3"=>"Axe", 
			"4"=>"Panga",
			"5"=>"Rake",
			"6"=>"tractor "
		);
		asort($values);
		return $values;
	}
	# forum categories
	function getForumCategories(){
		$values = array(
			"1"=>"Help (using the FARMIS)",
			"2"=>"Farm Group",
			"3"=>"Farm Loans",
			"4"=>"Marketing",
			"5"=>"Methods of Farming",
			"6"=>"Market Information",
			"7"=>"Farming Inputs",
			"8"=>"Commodities",
			"9"=>"Farming Best Practices",
			"10"=>"Offers"
		);
		asort($values);
		return $values;
	}
	# function to fetch all forum categories from database
	function getForumCategoryList() {
		$conn = Doctrine_Manager::connection(); 
		// count posts in each community forum category
		$all_categories = $conn->fetchAll("SELECT d.id as id, l.lookuptypevalue as `Category ID`, l.lookupvaluedescription as `Category`, COUNT(d.category) as `No of Posts` FROM lookuptypevalue AS l Left Join communityforum AS d ON l.lookuptypevalue = d.category WHERE l.lookuptypeid = 10 GROUP BY l.lookuptypevalue ORDER BY l.lookupvaluedescription ASC");
		
		return $all_categories;
	}
	# check for forum categories available
	function getCategoryText($cat) {
		$text = '';
		if(!isEmptyString($cat)){
			$categories = getForumCategories();
			$text = $categories[$cat];
		}
		return $text;
	}
	# check for latest forum discussions
	function getLatestForumDiscussions($limit=''){
		$conn = Doctrine_Manager::connection(); 
		$limit_query = "";
		if(!isEmptyString($limit)){
			$limit_query = " LIMIT ".$limit;
		}
		$all_categories = $conn->fetchAll("SELECT c.id as id, c.topic as topic FROM communityforum AS c WHERE c.id <> '' order by datecreated desc ".$limit_query);
		
		return $all_categories;
	}
?>