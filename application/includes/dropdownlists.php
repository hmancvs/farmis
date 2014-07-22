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
	# get the first day of the current year and month
	function getFirstDayOfCurrentMonth(){
		return date("Y-m-d", mktime (0,0,0, date("n"),1, date("Y")));
	}
	# get the last day of the last month
	function getLastDayOfCurrentMonth() {
		return date("Y-m-d", mktime(0,0,0, date("n")+1,0, date("Y")));
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
	# return districts in country
	function getDistricts($country = 'UG', $region = '') {
		$custom_query = '';
		if(!isEmptyString($region)){
			$custom_query = " AND l.regionid = '".$region."' ";
		}
		$query = "SELECT l.name AS optiontext, l.id AS optionvalue FROM location AS l WHERE l.locationtype = '2' AND l.country = UPPER('".$country."') ".$custom_query." ORDER BY optiontext";
		// debugMessage($query); 
		return getOptionValuesFromDatabaseQuery($query);
	}
	function getRegions($country = 'UG') {
		$query = "SELECT l.name AS optiontext, l.id AS optionvalue FROM location AS l WHERE l.locationtype = '1' AND l.country = UPPER('".$country."') ORDER BY optiontext";
		// debugMessage($query); 
		return getOptionValuesFromDatabaseQuery($query);
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
	function getRegionForDistrict($districtid) {
		$conn = Doctrine_Manager::connection(); 
		$query = "select l.regionid from location l where l.id = '".$districtid."' ";
		$result = $conn->fetchOne($query);
		// debugMessage($result);
		return $result;
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
		// debugMessage($query);
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
	function getSubGroups($farmgroupid, $country = 'UG') {
	    if(isEmptyString($farmgroupid)) {
	        return array();
	    }
		$ugcustom_query ='';
		if(strtolower($country) == 'ug'){
			$ugcustom_query = " OR f.country is null ";
		}
	    $query = "SELECT f.id as optionvalue, f.orgname as optiontext FROM farmgroup f
	    WHERE f.parentid = '".$farmgroupid."' AND 
	    (f.country = UPPER('".$country."') ".$ugcustom_query.")  
	    ORDER BY optiontext";
	    // debugMessage($query);
	    return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the education levels 
	function getAllEducationLevels(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'EDUCATION_LEVELS'";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the marital statuses 
	function getAllMaritalStatuses(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name = 'MARITAL_STATUS_VALUES'";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the list of farm group types
	function getFarmGroupTypes($ignore_list = array()){
		$customquery = '';
		if(is_array($ignore_list) && count($ignore_list) > 0){
			$list = implode("','", $ignore_list);
			$customquery = " AND l.lookuptypevalue NOT IN('".$list."') ";
		}
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'FARM_GROUP_TYPES' ".$customquery." order by optiontext";
		// debugMessage($query);
		return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the available farm groups
	function getAllFarmGroups($locationid = '', $country = 'UG') {
		$district_query = ""; $custom_query = "";
		if(!isEmptyString($locationid)){
			$district_query = " AND (f.districtid = '".$locationid."' ";
			
			$district = new Location();
			$district->populate($locationid);
			if(strtoupper($country) == 'UG' && $district->getRegionID() == 3 || $district->getRegionID() == 5 || $district->getRegionID() == 6){
				$district_query .= " OR (f.shortname = 'APSEDEC' OR f.shortname = 'FGO') )";
			} else {
				$district_query .= " ) ";
			}
		}
		$ugcustom_query ='';
		if(strtolower($country) == 'ug'){
			// $ugcustom_query = " OR f.country is null ";
		}
		$query = "SELECT f.id as optionvalue, f.orgname as optiontext FROM farmgroup f 
		WHERE f.parentid IS NULL ".$district_query." AND 
		(f.country = UPPER('".$country."') ".$ugcustom_query.$custom_query.")  
		GROUP BY f.id 
		ORDER BY optiontext";
		// debugMessage($query);
		return getOptionValuesFromDatabaseQuery($query);
	}
	function getAllFarmGroupsInDNA($dna = '', $country = 'UG') {
		$dna_query = "";
		if(!isEmptyString($dna)){
			$dna_query = " AND f.parentid = '".$dna."' ";
		}
		$ugcustom_query ='';
		if(strtolower($country) == 'ug'){
			$ugcustom_query = " OR f.country is null ";
		}
		$query = "SELECT f.id as optionvalue, f.orgname as optiontext FROM farmgroup f 
		WHERE f.parentid IS NOT NULL ".$dna_query." AND 
		(f.country = UPPER('".$country."') ".$ugcustom_query.")
		GROUP BY f.id 
		ORDER BY optiontext";
		// debugMessage($query);
		return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the available farm groups
	function getFarmGroupsInDistrict($districtid, $country = 'UG') {
		$ugcustom_query ='';
		if(strtolower($country) == 'ug'){
			$ugcustom_query = " OR f.country is null ";
		}
		$custom_query = '';
		/*$district = new Location();
		$district->populate($districtid);
		if($district->getRegionID() == 3 || $district->getRegionID() == 5 || $district->getRegionID() == 6){
			$custom_query = " (OR f.shortname = 'APSEDEC' OR f.shortname = 'FGO') ";
		}*/
		
		$query = "SELECT f.id as optionvalue, f.orgname as optiontext FROM farmgroup f 
		WHERE f.districtid = '".$districtid."' AND 
		f.parentid IS NULL AND 
		(f.country = UPPER('".$country."') ".$ugcustom_query.")
		GROUP BY f.id ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the available dna profiles
	function getDNAsInDistrict($districtid) {
		$aspedec_query = "";
		if(!isEmptyString($districtid)){
			$district = new Location();
			$district->populate($districtid);
			$regionid = $district->getRegionID();
			$custom_query = '';
			if($regionid == 3 || $regionid == 5 || $regionid == 6){
				$custom_query = " OR (f.shortname = 'APSEDEC' OR f.shortname = 'FGO') ";
			}
			// UPDATE useraccount set farmgroupid = 111 where farmgroupid IN(117,95,90,116);
			// DELETE from farmgroup where id IN(117,95,90,116);
		}
		$query = "SELECT f.id as optionvalue, f.orgname as optiontext FROM farmgroup f WHERE 
		f.districtid = '".$districtid."' AND f.parentid IS NULL ".$custom_query." 
		GROUP BY f.id ORDER BY optiontext";
		// debugMessage($query);
		return getOptionValuesFromDatabaseQuery($query);
		// SELECT fg.id, fg.orgname as DNA, count(f.id) as `Total Farmers`, sum(if(f.phone <> '',1, 0)) as `Farmers with Phone`, l.name as District, fg.regno as `Reg No`, fg.regdate as `Regn Date`  FROM `farmgroup` as fg left join useraccount as f on (f.farmgroupid = fg.id) left join location as l on (fg.districtid = l.id) WHERE fg.`type` <> '6' AND fg.`country` LIKE '%ug%' group by fg.id ORDER BY count(f.id) desc
		// update aclusergroup a inner join useraccount u on (a.userid = u.id AND a.groupid = 5) set a.groupid = 2, u.type = 2 where u.createdby = 5459;
		// update aclusergroup a inner join useraccount u on (a.userid = u.id AND a.groupid = 5) set a.groupid = 2, u.type = 2 where u.createdby = 5464;
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
	# field area units
	function getAreaUnits(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'LAND_MEASURE_UNITS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	function getLandMeasureUnits(){
		return getAreaUnits();
	}
	# land acquire methods
	function getLandAcquireMethods(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'LAND_ACQUIRE_METHODS' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# status values
	function getStatusValues(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'ACTION_STATUS' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# commodities configured for farmis 
	function getFarmisCommodities($ignore_list = array()){
		$customquery = '';
		if(is_array($ignore_list) && count($ignore_list) > 0){
			$list = implode("','", $ignore_list);
			$customquery = " AND c.id NOT IN('".$list."') ";
		}
		$valuesquery = "SELECT c.id AS optionvalue, c.`name` as optiontext FROM commodity as c WHERE c.allowfarmer = 1 AND c.categoryid <> 27 ".$customquery." ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# commodities configured for farmis 
	function getOtherEnterprises(){
		$customquery = '';
		$valuesquery = "SELECT c.id AS optionvalue, c.`name` as optiontext FROM commodity as c WHERE c.allowfarmer = 1 AND c.categoryid = 27 ".$customquery." ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# commodities configured for a farmer 
	function getCommoditiesForFarmer($userid){
		$valuesquery = "SELECT fc.cropid AS optionvalue, c.`name` as optiontext FROM farmcrop fc inner join commodity c on (fc.cropid = c.id AND c.unitid <> 16) WHERE fc.userid = '".$userid."' GROUP BY fc.cropid ORDER BY optiontext";
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
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'INPUT_TYPES' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# production input types
	function getAllExpenseTypes(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'EXPENSE_TYPES' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# methods of tillage
	function getTillageMethods(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'TILLAGE_TYPES' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# primary tillage methods
	function getPrimaryTillageMethods(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'PRIMARY_TILLAGE_METHODS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# secondary tillage methods
	function getSecondaryTillageMethods(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SECONDARY_TILLAGE_METHODS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# methods of tillage
	function getDepthUnits(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'DEPTH_UNITS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# seeding rate units
	function getSeedingUnits(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SEEDING_UNITS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# seeding rate units
	function getSeedingTotalUnits(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'PLANTING_UNITS'";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# planting methods
	function getPlantingMethods(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'PLANTING_METHODS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# treatment types
	function getTreatmentChemicalTypes(){
		$values = array();
		ksort($values);
		return $values;
	}
	# treatment methods
	function getTreatmentMethods(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'TREATMENT_METHODS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# treatment units
	function getTreatmentMeasureUnits(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'TREATMENT_MEASURE_UNITS' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# treatment units
	function getTreatmentTotalUnits(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'TREATMENT_VOLUME_UNITS' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# application timing values 
	function getTimingValues(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SEASON_TIMING_VALUES' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# treatment sub types
	function getTreatmentSubTypes(){
		$values = array();
		asort($values);
		return $values;
	}
	# treatment sub types
	function getTreatmentTypes(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SEASON_TREATMENT_TYPES' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# treatment types
	function getTreatmentForms(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SEASON_TREATMENT_FORMS' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# harvest yield rate
	function getHarvestYieldUnits(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'YIELD_UNITS' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# harvest quantity yield rate
	function getHarvestQuantityUnits(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SEASON_HARVEST_UNITS' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# harvest quantity yield rate
	function getHarvestMethods(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'HARVEST_METHODS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# sale to types
	function getSaleToTypes(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SALES_DESTINATIONS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# types of inventory
	function getInventoryTypes(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'INVENTORY_TYPES' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# categories of inventory
	function getInventoryCategories($userid = ''){
		$values = array("1"=>"Cat 1", "2"=>"Other");
		// asort($values);
		return $values;
	}
	# types of services for inventory
	function getServiceTypes(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SERVICE_TYPES' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# sources of loans for financing season activities
	function getCapitalSources(){
		$values = array(
			"1"=>"Own Cash / Personal income", 
			"2"=>"Savings from previous season", 
			"3"=>"Soft loan", 
			"4"=>"Bank loan",
			"5"=>"Crop finance contract"
		);
		// asort($values);
		return $values;
	}
	function getActivityFinanceSources($type){
		if($type == '1' || isEmptyString($type)){
			$values = array(
				"1"=>"Current Season Capital", 
				"3"=>"Soft loan", 
				"4"=>"Bank loan",
				"5"=>"Crop finance"
			);
		}
		if($type == '2'){
			$values = array(
				"1"=>"Current Season Capital", 
				"3"=>"New Soft loan", 
				"4"=>"New Bank loan",
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
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'FINANCIAL_INSTITUTIONS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	function getAllClients(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'ALL_CLIENTS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	function getAllSeasons($userid = ''){
		$custom_query = '';
		if(!isEmptyString($userid)){
			$custom_query .= " AND s.userid= '".$userid."' ";
		}
		$valuesquery = "SELECT s.id AS optionvalue, concat(s.ref, ' - ', s.activityname) as optiontext FROM season as s WHERE s.id <> '' ".$custom_query." ORDER BY optiontext";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	function getSeasonActivities($seasonid){
		$custom_query = '';
		$valuesquery = "(SELECT concat('2', ',', a.id) AS optionvalue, concat(a.activityname, ' - ', a.ref) as optiontext FROM seasontillage as a WHERE a.seasonid = '".$seasonid."' ".$custom_query." ORDER BY optiontext) 
			UNION (SELECT concat('3', ',', a.id) AS optionvalue, concat(a.activityname, ' - ', a.ref) as optiontext FROM seasonplanting as a WHERE a.seasonid = '".$seasonid."' ".$custom_query." ORDER BY optiontext)
			UNION (SELECT concat('4', ',', a.id) AS optionvalue, concat(a.activityname, ' - ', a.ref) as optiontext FROM seasontracking as a WHERE a.seasonid = '".$seasonid."' ".$custom_query." ORDER BY optiontext)
			UNION (SELECT concat('6', ',', a.id) AS optionvalue, concat(a.activityname, ' - ', a.ref) as optiontext FROM seasonharvest as a WHERE a.seasonid = '".$seasonid."' ".$custom_query." ORDER BY optiontext)
			UNION (SELECT concat('7', ',', a.id) AS optionvalue, concat(a.activityname, ' - ', a.ref) as optiontext FROM sales as a WHERE a.seasonid = '".$seasonid."' ".$custom_query." ORDER BY optiontext)  
		";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# determine signup contact categories
	function getContactUsCategories(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'CONTACTUS_CATEGORIES' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	function getPricingTypes(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SALES_PRICING_TYPES' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	
	function getFarmers($farmgroupid = '', $hasphone = true, $is_subgroup = false, $hasemail = false, $ignorelist = '', $country = 'UG'){
		$custom_query = '';
		$hasphoneq1 = ""; $hasphoneq2 = ""; $withemail = "";
		if(!isEmptyString($farmgroupid)){
			$custom_query = " AND u.farmgroupid = '".$farmgroupid."' ";
			if($is_subgroup){
				$custom_query = " AND u.subgroupid = '".$farmgroupid."' ";
			}
			if($farmgroupid == 0){
				$custom_query = " AND (u.`farmgroupid` IS NULL) ";
			}
		} else {
			$custom_query = " ";
		}
		
		if($hasemail){
			$custom_query .= " AND u.email <> '' ";
			$hasphoneq1 = ", ' [',u.email,']'";
		}
		if($hasphone){
			$hasphoneq1 = ", ' [',u.phone,']' ";
			$hasphoneq2 = " AND u.phone <> '' ";
		}
		if(!isEmptyString($ignorelist)){
			$custom_query .= " AND u.id <> '".$ignorelist."' ";
		}
		$valuesquery = "SELECT u.id AS optionvalue, concat(u.firstname, ' ', u.lastname".$hasphoneq1.") as optiontext FROM useraccount as u  WHERE u.id <> '' AND u.type = 2 AND u.country = UPPER('".$country."') ".$hasphoneq2." ".$custom_query." GROUP BY u.id ORDER BY optiontext ASC";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	function getAllFarmers($country = 'UG'){
		$custom_query = '';
		$valuesquery = "SELECT u.id AS optionvalue, concat(u.firstname, ' ', u.lastname) as optiontext FROM useraccount as u WHERE u.id <> '' AND u.type = 2  AND u.country = UPPER('".$country."') ".$custom_query." GROUP BY u.id ORDER BY optiontext ASC";
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	// count all farmers available
	function countAllFarmers($country = 'UG') {
		$conn = Doctrine_Manager::connection(); 
		$valuesquery = "SELECT count(u.id) AS total FROM useraccount as u WHERE u.type = 2 AND u.country = UPPER('".$country."') ";
		$result = $conn->fetchOne($valuesquery);
		// debugMessage($result);
		return $result;
	}
	// count all farmers under farm groups
	function countAllFarmersInGroups($country = 'UG') {
		$conn = Doctrine_Manager::connection(); 
		$valuesquery = "SELECT count(u.id) AS total FROM useraccount as u WHERE u.type = 2 AND u.country = UPPER('".$country."') AND u.farmgroupid <> '' ";
		$result = $conn->fetchOne($valuesquery);
		// debugMessage($result);
		return $result;
	}
	// count all individual farmers
	function countAllIndividualFarmers($country = 'UG') {
		$conn = Doctrine_Manager::connection(); 
		$valuesquery = "SELECT count(u.id) AS total FROM useraccount as u WHERE u.type = 2 AND u.country = UPPER('".$country."') AND u.farmgroupid IS NULL ";
		$result = $conn->fetchOne($valuesquery);
		// debugMessage($result);
		return $result;
	}
	// count all male farmers
	function countMaleFarmers($country = 'UG') {
		$conn = Doctrine_Manager::connection(); 
		$valuesquery = "SELECT count(u.id) AS total FROM useraccount as u WHERE u.type = 2 AND u.country = UPPER('".$country."') AND u.gender = '1' ";
		$result = $conn->fetchOne($valuesquery);
		// debugMessage($result);
		return $result;
	}
	// count all female farmers
	function countFemaleFarmers($country = 'UG') {
		$conn = Doctrine_Manager::connection(); 
		$valuesquery = "SELECT count(u.id) AS total FROM useraccount as u WHERE u.type = 2 AND u.country = UPPER('".$country."') AND u.gender = '2' ";
		$result = $conn->fetchOne($valuesquery);
		// debugMessage($result);
		return $result;
	}
	// count farmers registered in period
	function countFarmersInRange($country = 'UG', $start, $end, $type = ''){
		$conn = Doctrine_Manager::connection(); 
		$custom_query = " ";
		if(!isEmptyString($type)){
			if($type == 'G'){
				$custom_query = " AND u.farmgroupid <> '' ";
			}
			if($type == 'I'){
				$custom_query = " AND u.farmgroupid IS NULL ";
			}
		}
		$valuesquery = "SELECT count(u.id) AS total FROM useraccount as u WHERE u.type = 2 AND u.country = UPPER('".$country."') AND (TO_DAYS(u.datecreated) >= TO_DAYS('".$start."')) AND (TO_DAYS(u.datecreated) <= TO_DAYS('".$end."')) ".$custom_query." ";
		$result = $conn->fetchOne($valuesquery);
		// debugMessage($valuesquery);
		return $result;
	}
	// count all farm groups available
	function countAllGroups($country = 'UG') {
		$conn = Doctrine_Manager::connection(); 
		$valuesquery = "SELECT count(g.id) as total FROM farmgroup AS g WHERE g.country = UPPER('".$country."') AND g.parentid IS NULL ";
		$result = $conn->fetchOne($valuesquery);
		// debugMessage($result);
		return $result;
	}
	// count farm groups registered in period
	function countGroupsInRange($country = 'UG', $start, $end){
		$conn = Doctrine_Manager::connection(); 
		$valuesquery = "SELECT count(g.id) as total FROM farmgroup AS g WHERE g.country = UPPER('".$country."') AND g.parentid IS NULL AND (TO_DAYS(g.regdate) >= TO_DAYS('".$start."') AND TO_DAYS(g.datecreated) <= TO_DAYS('".$end."'))";
		$result = $conn->fetchOne($valuesquery);
		// debugMessage($valuesquery);
		return $result;
	}
	# farming types practised
	function getFarmingTypes(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'FARMING_TYPES' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# support types received by farmer
	function getSupportTypes(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'SUPPORT_TYPES' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# income generateing activities
	function getOtherActivityTypes(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'ACTIVITY_FORMS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# farming tools 
	function getFarmingTools(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'FARMING_TOOLS' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# forum categories
	function getForumCategories(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'FORUM_CATEGORIES' order by optiontext ";
		return getOptionValuesFromDatabaseQuery($query);
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
	# check for payment methods
	function getPaymentMethods(){
		return array(1=>'Mobile Money',2=>'Cash',3=>'Payments System');
	}
	# payment status values
	function getPaymentStatuses(){
		return array(3=>'Received',2=>'Cancelled',1=>'Pending');
	}
	# subscription periods available
	function getSubscriptionPeriods(){
		return array('365'=>'1 Year');
	}
	# subscription subjects
	function getPaymentSubjects(){
		return array(2=>'Farmer Subscription', 4=>'DNA Subscription');
	}
	# all listable variable groupings
	function getAllists(){
		$conn = Doctrine_Manager::connection();
		$all_lists = $conn->fetchAll("SELECT l.id as id, l.displayname as name FROM lookuptype AS l WHERE l.listable = 1 order by l.displayname ASC ");
		return $all_lists;
	}
	# latest system user farmers
	function getLatestUsers($limit, $country = 'UG'){
		$conn = Doctrine_Manager::connection();
		$all_users = $conn->fetchAll("SELECT u.id as id, concat(u.firstname, ' ', u.lastname, ' ', u.othernames) as name FROM useraccount AS u WHERE u.type = '2' AND u.country = UPPER('".$country."') order by u.datecreated DESC limit ".$limit);
		return $all_users;
	}
	function getProfilingUsers($country = 'UG'){
		$query = "SELECT u.id as optionvalue, concat(u.firstname, ' ', u.lastname) as optiontext FROM useraccount AS u WHERE (u.type = '1' OR u.type = '4' OR u.type = '3') AND u.country = UPPER('".$country."') order by optiontext asc ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# latest farm groups activated
	function getLatestGroups($limit, $country = 'UG'){
		$conn = Doctrine_Manager::connection();
		$all_grps = $conn->fetchAll("SELECT g.id as id, g.orgname as name FROM farmgroup AS g WHERE g.id <> '' AND g.country = UPPER('".$country."') order by g.regdate DESC limit ".$limit);
		return $all_grps;
	}
	# subscription subjects
	function getPostHarvestTypes(){
		return array(1=>'Cooling', 2=>'Cleaning', 3=>'Drying', 4=>'Sorting', 5=>'Packing', 6=>'Processing', 7=>'Packaging');
	}
	# history of farmers
	function getFarmersHistory($country = 'UG'){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT
					month(u.regdate) as monthid,
					monthname(u.regdate) as name,
					date_format(u.regdate, '%b') as shortmonthname, 
					year(u.regdate) as yearid,
					concat(year(u.regdate),  '', month(u.regdate) ) as yearmonth, 
					count(u.id) as total,
					SUM(IF(u.gender = 1, 1, 0)) as total_male,
					SUM(IF(u.gender = 2, 1, 0)) as total_female,
					round((SUM(IF(u.gender = 1, 1, 0)) /  count(u.id)) * 100)  as perc_male,
					round((SUM(IF(u.gender = 2, 1, 0)) /  count(u.id)) * 100)  as perc_female,
					SUM(IF(u.farmgroupid is null, 1, 0)) as total_indv,
					SUM(IF(u.farmgroupid is not null, 1, 0)) as total_grps,
					round((SUM(IF(u.farmgroupid is null, 1, 0)) /  count(u.id)) * 100)  as perc_indv,
					round((SUM(IF(u.farmgroupid is not null, 1, 0)) /  count(u.id)) * 100)  as perc_grps
					FROM useraccount u 
					where u.type = 2 AND u.country = UPPER('".$country."') AND (u.regdate >= date_sub(now(), interval 6 month))
					group by yearid, monthid
					order by yearmonth asc";
		// debugMessage($query);
		$result = $conn->fetchAll($query);
		return $result;
	}
	# history of farmgroups
	function getFarmGroupHistory($country = 'UG'){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT
					month(f.regdate) as monthid,
					monthname(f.regdate) as name,
					date_format(f.regdate, '%b') as shortmonthname, 
					year(f.regdate) as yearid,
					concat(year(f.regdate), '', month(f.regdate) ) as yearmonth, 
					count(f.id) as total
					FROM
					farmgroup AS f
					where f.id <> '' AND f.country = UPPER('".$country."')  
					group by yearid, monthid
					order by yearmonth asc LIMIT 6";
		// debugMessage($query);
		$result = $conn->fetchAll($query);
		return $result;
	}
	# user status
	function getUserStatus($value = ''){
		$array = array(0 =>'Pending Activation', 1 => 'Active', 2=>'Deactivated');
		if(!isEmptyString($value)){
			return $array[$value];
		}
		return $array;
	}
	# product status values
	function getActiveStatus($value = ''){
		$array = array('1' => 'Enabled', '0' =>'Disabled');
		if(!isEmptyString($value)){
			return $array[$value];
		}
		return $array;
	}
	# user types
	function getUserType($value = '', $ignorelist =''){
		$custom_query = "";
		if(!isEmptyString($ignorelist)){
			$custom_query .= " AND a.id NOT IN(".$ignorelist.") ";
		}
		
		$query = "SELECT a.id as optionvalue, a.name as optiontext FROM aclgroup a where a.id <> '' ".$custom_query." order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		if(!isEmptyString($value)){
			return $array[$value];
		}
		return $array;
	}
	function getLookupValueDescription($lookuptype, $lookuptypevalue) {
		$sql = "SELECT lv.lookupvaluedescription FROM lookuptypevalue lv INNER JOIN lookuptype l ON (lv.lookuptypeid = l.id AND l.`name` = '".$lookuptype."' AND lv.lookuptypevalue = '".$lookuptypevalue."')";
		$conn = Doctrine_Manager::connection(); 
		
		return $conn->fetchOne($sql); 
	}
	/**
     * Determine the person's life status label
     * @return String the life status 
     */
    function getSalutationLabel($str){
    	$salution = '';
    	if(!isEmptyString($str) && $str != 0){
    		$lab = LookupType::getLookupValueDescription("SALUTATION", $str);
    		$salution = ', '.$lab;
    	}
    	return $salution; 
    }
?>