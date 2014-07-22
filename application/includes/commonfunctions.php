<?php

# functions to create and manage drop down lists
require_once 'dropdownlists.php';
require_once 'BrowserDetection.php';

define("ACTION_CREATE", "create");
define("ACTION_INDEX", "index"); // maps to the default controller for Zend Framework, same as the create action in the ACL 
define("ACTION_EDIT", "edit");
define("ACTION_APPROVE", "approve");
define("ACTION_DELETE", "delete");
define("ACTION_EXPORT", "export");
define("ACTION_VIEW", "view");
define("ACTION_LIST", "list");

# redirect, success and error urls during the processing of an action 
define("URL_REDIRECT", "redirecturl"); // url forwarded to when a user has to login 
define("URL_SUCCESS", "successurl"); // override the url when an action suceeds
define("URL_FAILURE", "failureurl"); // override the url when an action fails

# the separator between a table name and a column name for filtering since the . cannot be used as
# a separator for HTML field names
define("HTML_TABLE_COLUMN_SEPARATOR", "__");

# the session variable holding the values from the REQUEST when an error occurs
define("FORM_VALUES", "formvalues");
# the session variable holding the error message when processing a form 
define("ERROR_MESSAGE", "errors"); 
# the session variable holding the success message when processing a form 
define("SUCCESS_MESSAGE", "successmessage"); 
# the session variable holding the error message for the error page which is not cleared from page to page 
define("APPLICATION_ERROR_PAGE_MESSAGE", "error_page_erros"); 
# the session variable for the access control lists 
define("SESSION_ACL", "acl"); 

# calendar view options
define("CALENDAR_VIEW_MONTH", "month_view"); 
define("CALENDAR_VIEW_WEEK", "week_view"); 

# constant for showing views in a popup
define("PAGE_CONTENTS_ONLY", "pgc"); 
define("EXPORT_TO_EXCEL", "excel"); 

# constant for the select chain value
define("SELECT_CHAIN_TYPE", "select_chain_type"); 

# excel generation constants
# a comma delimited list of column indexes with numbers
define("EXPORT_NUMBER_COLUMN_LIST", "numbercolumnlist");
# the number of columns to ignore at the beginning of the query 
define("EXPORT_IGNORE_COLUMN_COUNT", "columncheck");  
# the query string with all the results
define("ALL_RESULTS_QUERY", "arq");
# the query string with the searches and filters applied
define("CURRENT_RESULTS_QUERY", "crq");
# the page title for current list
define("PAGE_TITLE", "ttl");

define('COUNTRY_CODE_UG', '256');
define('FARMER_REG_PREFIX', 'UGF');
define('FARMGROUP_REG_PREFIX', 'UD');
define('COUNTRY_CODE_KE', '254');
define('FARMER_REG_PREFIX_KE', 'KF');
define('FARMGROUP_REG_PREFIX_KE', 'KD');
define('FARM_REG_PREFIX', 'F');
define('SEASON_PREFIX', 'S/');
define('MAX_NO_FARMS_LANDS', '4');
define('ACTIVITY_INPUT_PREFIX', 'Act/INP/');
define('ACTIVITY_TILLAGE_PREFIX', 'Act/TLG/');
define('ACTIVITY_PLANTING_PREFIX', 'Act/PLG/');
define('ACTIVITY_TREATMENT_PREFIX', 'Act/TRT/');
define('ACTIVITY_OTHER_PREFIX', 'Act/');
define('ACTIVITY_HARVESTING_PREFIX', 'Act/HAV/');
define('ACTIVITY_EXPENSE_PREFIX', 'Act/EXP/');
define('ACTIVITY_SALES_PREFIX', 'Act/SAL/');
define("COUNTRY_UG_CURRENCY", "(UGX)");
define("COUNTRY_UG_CURRENCY_KENYA", "(KSHS)");
define("BILLING_SERVER", "http://localhost.com/test.php");

define("SMS_SERVER", "http://121.241.242.114:8080/bulksms/bulksms");
define("SMS_USERNAME", 'fti-farmis');
define("SMS_PASSWORD", 'farmis');
define("SMS_PORT", "8080");
define("SMS_TEST_NUMBER", "256776595279");

define("SMS_SERVER_KENYA", "http://41.220.239.178:65015/sokopepe/farmis.jsp");
define("SMS_USERNAME_KENYA", 'farmis');
define("SMS_PASSWORD_KENYA", 'p@ssw079');
define("SMS_TEST_NUMBER_KENYA", "254720529868");

// define("PESAPAL_MERCHANT_KEY", "ZdISXxXFTvNxHHJmvl6rc4Cxc9Y3DmYm"); // hman inc
define("PESAPAL_MERCHANT_KEY", "dvGq7zrxIws7dqmgiaYZFQfKDWFydaP1"); // infotrade live
// define("PESAPAL_MERCHANT_KEY", "fU6H1/vnyquxtW/LG6xA8cGzIKDVBP9f"); // test merchant globalsys/hmusiitwa@outlook.com

// define("PESAPAL_MERCHANT_SECRET", "taiHm02VrvM+ZM8W/sp0rkLUGBc="); // hman inc
define("PESAPAL_MERCHANT_SECRET", "d0gvUhPIkahHKRVScjgk/pq7Pe8="); // infotrade live
// define("PESAPAL_MERCHANT_SECRET", "/HyjbEBAm6bVv7c1+1loxIxq4J4="); // test merchant globalsys/hmusiitwa@outlook.com

define("PESAPAL_POST_URL", 'https://www.pesapal.com/API/PostPesapalDirectOrderV4'); // live
// define("PESAPAL_POST_URL", 'http://demo.pesapal.com/api/PostPesapalDirectOrderV4'); // demo sunbox

define("PESAPAL_STATUS_URL", 'https://www.pesapal.com/api/querypaymentstatus'); // live
// define("PESAPAL_STATUS_URL", 'http://demo.pesapal.com/api/querypaymentstatus'); // demo sunbox
/*
 * Change a date from MySQL database Format (yyyy-mm-dd) to the format displayed on pages(mm/dd/yyyy)
 * 
 * If the date from the database is NULL, it is transformed to an empty string for display on the pages 
 *
 * @param String $mysqldate The date in MySQL format 
 * @return String the date in short date format, or an empty string if no date is provided 
 */
function changeMySQLDateToPageFormat($mysqldate) {
	$aconfig = Zend_Registry::get("config"); 
	if (isEmptyString($mysqldate)) {
		return $mysqldate;
	} else {
		return date($aconfig->dateandtime->mediumformat, strtotime($mysqldate));
	}
}
/**
 * Transform a date from the format displayed on pages(mm/dd/yyyy) to the MySQL database date format (yyyy-mm-dd). 
 * If the date from the database is an empty string or the string NULL, it is transformed to a NULL value.
 *
 * @param String $pagedate The string representing the date
 * @return String The MYSQL datetime format or NULL if the provided date is an empty string or the string NULL 
 */
function changeDateFromPageToMySQLFormat($pagedate) {
	if ($pagedate == "NULL") {
		return NULL;
	}
	if (isEmptyString($pagedate)) {
		return NULL;
	} else {
		return date("Y-m-d H:i:s", strtotime($pagedate));
	}
}
function formatDateAndTime($mysqldate, $ignoretime = true){
	if(isEmptyString($mysqldate)){
		return '--';
	}
	$timestr = '';
	if($ignoretime === true){
		$timestr = ' g:i A';
	}
	$oDate = new DateTime($mysqldate);
	$sDate = $oDate->format("d/m/Y".$timestr);
	return $sDate;
}

/**
 * Check whether or not the string is empty. The string is emptied
 *
 * @param String $str The string to be checked
 * 
 * @return Boolean Whether or not the string is empty
 */
function isEmptyString($str) {
	if ($str == "") {
		return true; 
	}
	if ((trim($str)) == "") {
		return true;
	} else {
		return false;
	}
}

/**
 * Check whether or not the value of the key in the specified array is empty
 *
 * @param String $key The key whose value is to be checked
 * @param Array $arr The array to check  
 * 
 * @return Boolean Whether or not the array key is empty
 */
function isArrayKeyAnEmptyString($key, $arr) {
	if (!array_key_exists($key, $arr)) {
		return true; 
	}
	if (is_string($arr[$key])) {
		return isEmptyString($arr[$key]);
	}
	return false; 
}
/**
 * Check whether or not the string is empty. The string is emptied
 *
 * @param String $str The string to be checked
 * 
 * @return boolean Whether or not the string is empty
 */
function isNotAnEmptyString($str) {
	return ! isEmptyString($str);
}

/**
 * Return a debug message with a break tag before and two break tags after
 *
 * @param Object $obj The object to be printed
 */
function debugMessage ($obj) {
	echo "<br />";
	print_r($obj);
	echo "<br /><br />";
}

/**
 * Return the value of the checked HTML attribute for a checkbox or radio button
 *
 * @param Boolean $bool whether or not the HTML control is checked
 * @return String the checked attribute
 */
function getCheckedAttribute($bool) {
	if ($bool) {
		return ' checked="checked"';
	}
	return "";
}
/**
 *  Merge the arrays passed to the function and keep the keys intact.
 *  If two keys overlap then it is the last added key that takes precedence.
 * 
 * @return Array the merged array
 */
function array_merge_maintain_keys() {
	$args = func_get_args();
	$result = array();
	foreach ( $args as &$array ) {
		foreach ( $array as $key => &$value ) {
			$result[$key] = $value;
		}
	}
	return $result;
}

# function that trims every value of an array
function trim_value(&$value) {
	$value = trim($value);
}

/**
 * Recursively Remove empty values from an array. If any of the keys contains an 
 * array, the values are also removed.
 *
 * @param Array $input The array
 * @return Array with the specified values removed or the filtered values
 */
function array_remove_empty($arr) {
	$narr = array();
	while ( list ($key, $val) = each($arr) ) {
		if (is_array($val)) {
			$val = array_remove_empty($val);
			// does the result array contain anything?
			if (count($val) != 0) {
				// yes :-)
				$narr[$key] = $val;
			}
		} else {
			if (! isEmptyString($val)) {
				$narr[$key] = $val;
			}
		}
	}
	unset($arr);
	return $narr;

}

/**
 * Send test email
 *
 * @param String $subject The subject of the email 
 * @param String $message The contents of the email 
 */
function sendTestMessage($subject = "", $message = "") {
	$mailer = getMailInstance(); 
	# get an instance of the PHP Mailer
	$from_email = $mailer->getDefaultFrom();
	// debugMessage($from_email);
	// $mailer->AddTo($from_email['email']);
	$mailer->AddTo("hmanmstw@gmail.com");
	// $mailer->AddTo("admin@devmail.infomacorp.com");
	
	$mailer->setSubject($subject);
	$mailer->setBodyHTML($message); 
	// debugMessage($mailer); exit();
	try {
		$result = $mailer->send();
		// debugMessage("The email sending result is ".$result);
		if (!$result) {
			# Log the error
			echo "an error occured while sending the message " . $mailer->ErrorInfo;
		} else {
			debugMessage("message sent to ".APPLICATION_ENV);
		}
	} catch ( Exception $e ) {
		debugMessage("Error sending email ".$e);
	}
}
# send sms message to phone number
function sendSMSMessage($to, $txt, $returnresult = false, $country = 'ug', $source = 'FARMIS') {
	$phone = $to;
    // $port = SMS_PORT;
    $message = $txt;
	$sendsms = true;
	$server = SMS_SERVER;
	$username = SMS_USERNAME;
    $password = SMS_PASSWORD;
	if(isKenya()){
		$server = SMS_SERVER_KENYA;
		$username = SMS_USERNAME_KENYA;
    	$password = SMS_PASSWORD_KENYA;
	}
	return sendSMS($to, $txt, $source);
	    
    $client = new Zend_Http_Client($server);
    // the GET Parameters
	
    if(isUganda()){
		$client->setParameterGet(array(
			'username'  => $username,
			'password'  => $password,
			'type'	=>	0,
			'dlr'	=>	0,
			'source'=>	$source,
			'destination' => $phone,
			'message' => $message
		));
    }
    if(isKenya()){
    	$client->setParameterGet(array(
			'userName&'  => $username,
			'password'  => $password,
			'msisdn' => $phone,
			// 'msg' => urlencode(addslashes($message))
    		'msg' => $message
		));
    }
    
	/*debugMessage($client); 
	debugMessage(getClientUrl($client));*/
	// exit();
	if($sendsms){
		try {
			$response = $client->request();
			$body = $response->getBody();
			// debugMessage($body);
			
			if($returnresult){
				return $body;
			}
			// debugMessage($client->getLastRequest());
			 
		} catch (Exception $e) {
			# error handling
			$message = "Error in sending Message: ".$e->getMessage();
			if($returnresult){
				// debugMessage($message);
				return $message;
			}
		}
	}
	
	if(!$returnresult){
		return true;
	}
}
function sendSMS($to, $txt, $returnresult = false, $source = 'FARMIS') {
	$phone = $to;
    $message = $txt;
	$sendsms = true;
	
	if(isUganda()){
		$server = SMS_SERVER;
		$username = SMS_USERNAME;
	    $password = SMS_PASSWORD;
		$parameters = array(
			'username'  => $username,
			'password'  => $password,
			'type'	=>	0,
			'dlr'	=>	0,
			'source'=>	$source,
			'destination' => $phone,
			'message' => $message
		);
	}
	if(isKenya()){
		$server = SMS_SERVER_KENYA;
		$username = SMS_USERNAME_KENYA;
    	$password = SMS_PASSWORD_KENYA;
    	$parameters = array(
			'userName&'  => $username,
			'password'  => $password,
			'msisdn' => $phone,
    		'msg' => $message
		);
	}
	$result = curlContents($server, 'GET', $parameters, false, false);
	$resultcode = substr($result, 0, 4);
	debugMessage($result);
	if($resultcode == 1701){
		debugMessage('Success');
	} else {
		debugMessage('Error with code: '.$resultcode);
		$str = "1701 - Success<br>
				1702 - Invalid Url<br>
				1703 - Invalid Username or password<br>
				1704 - invalid type<br>
				1705 - invalid message<br>
				1706 - invalid destination<br>
				1707 - invalid source<br>
				1708 - invalid 'dlr' field<br>
				1709 - user validation failed<br>
				1710 - internal serve error<br>
				1025 - insufficient credit<br>
				1715 - Response timeout";
		
		debugMessage($str);
	}
	return true;
}
function curlContents($url, $method = 'GET', $data = false, $headers = false, $returnInfo = false) {    
    $ch = curl_init();
    
    if($method == 'POST') {
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        if($data !== false) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    } else {
        if($data !== false) {
            if(is_array($data)) {
                $dataTokens = array();
                foreach($data as $key => $value) {
                    array_push($dataTokens, urlencode($key).'='.urlencode($value));
                }
                $data = implode('&', $dataTokens);
            }
            curl_setopt($ch, CURLOPT_URL, $url.'?'.$data);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    if($headers !== false) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    $contents = curl_exec($ch);
    
    if($returnInfo) {
        $info = curl_getinfo($ch);
    }
	debugMessage(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
    curl_close($ch);

    if($returnInfo) {
        return array('contents' => $contents, 'info' => $info);
    } else {
        return $contents;
    }
}
function getClientUrl (Zend_Http_Client $client)
{
    try
    {
        $c = clone $client;
        /*
         * Assume there is nothing on 80 port.
         */
        $c->setUri ('http://127.0.0.1');

        $c->getAdapter ()
            ->setConfig (array (
            'timeout' => 0
        ));

        $c->request ();
    }
    catch (Exception $e)
    {
        $string = $c->getLastRequest ();
        $string = substr ($string, 4, strpos ($string, "HTTP/1.1\r\n") - 5);
    }
    return $client->getUri (true) . $string;
}
/**
 * Wrapper function for the encoding of the urls using base64_encode 
 *
 * @param String $str The string to be encoded
 * @return String The encoded string 
 */
function encode($str) {
	return base64_encode($str); 
}
/**
 * Wrapper function for the decoding of the urls using base64_decode 
 *
 * @param String $str The string to be decoded
 * @return String The encoded string 
 */
function decode($str) {
	return base64_decode($str); 
}

/**
 * Function to generate a JSON string from an array of data, using the keys and values
 *
 * @param $data The data to be converted into a string
 * @param $default_option_value Value of the default option
 * @param $default_option_text Test for the default 
 * 
 * @return the JSON string containing the select options
 */
function generateJSONStringForSelectChain($data, $default_option_value = "", $default_option_text = "<Select One>", $freetexthtml ='') {
	// debugMessage($data);
	$values = array(); 
	//debugMessage($data);
	if (!isEmptyString($default_option_value)) {
		# use the text and option from the data
		if(!isArrayKeyAnEmptyString($default_option_value, $data)){
			$values[] = '{"id":"' . $default_option_value . '", "label":"' . $data[$default_option_value] . '"}';
			// remove the default option from the available options
			unset($data[$default_option_value]);
		}
	}
	# add a default option
	$values[] = '{"id":"", "label":"' . $default_option_text . '"}';
	foreach ( $data as $key => $value ) {
		$values[] = '{"id":"'.$key.'", "label":"' . $value . '"}';
		//debugMessage($strstring);
	}
	# remove the first comma at the end
	return '[' . implode("," , $values). "]";
	// return $data;
}
/**
 * Format a number to two decimal places and a comma separator between thousands. Empty Strings are considered to be numeric
 *
 * @param Number $number The number to be formatted
 * @return Number The formatted version of the number
 */
function formatNumber($number) {
	if (isEmptyString($number) || !is_numeric($number)) {
		return $number;
	}
	$aconfig = Zend_Registry::get("config"); 
	return number_format($number, $aconfig->currency->decimalplaces);
}
function formatMoney($amount) {
	$aconfig = Zend_Registry::get("config");
	if (isEmptyString($amount)) {
		return '--';
	}
	return formatNumber($amount)."&nbsp;<span class='pagedescription'>(".$aconfig->currency->default.")</span>";
}
function formatMoneyOnly($amount) {
	$aconfig = Zend_Registry::get("config");
	if (isEmptyString($amount)) {
		return '0';
	}
	return formatNumber($amount);
}
/**
 * Generate an HTML list from an array of values
 *
 * @param Array $array
 * @return String 
 */
function createHTMLListFromArray($array, $classname="") {
	$str = ""; 
	// return empty string if no array is passed
	if (!is_array($array)) {
		return $str; 
	}
	// return an empty string if the array is empty
	if (!$array) {
		return $str; 
	}
	$class = "";
	if(!isEmptyString($classname)){
		$class = " class='".$classname."'";
	}
	// opening list tag and the first li element
	$str  = "<ul ".$class."><li>";
	// explode the array and generate the inner list items
	$str .= implode($array, "</li><li>");
	// close the last list item, and the ul
	$str .= "</li></ul>"; 
	
	return $str; 
}
function createHTMLCommaListFromArray($array, $separator = "', '") {
	$str = ""; 
	// return empty string if no array is passed
	if (!is_array($array)) {
		return $str; 
	}
	// return an empty string if the array is empty
	if (!$array) {
		return $str; 
	}
	
	// explode the array and generate the inner list items
	$str .= implode($array, $separator);
	
	return $str; 
}
/**
  * Load the application configuration from the database
  * 
  */
function loadConfig() {
	$cache = Zend_Registry::get('cache');
	// load the configuration from the cache
	$config = $cache->load('config'); 
	if (!$config) {
		// do nothing 
	} else {
		// add the config object to the registry 
		Zend_Registry::set('config', $config);
		return; 
	}
	
	// load the active application configuration from the database
	$sql = "SELECT section, optionname, optionvalue FROM appconfig WHERE active = 'Y'";

	$conn = Doctrine_Manager::connection(); 
	$result = $conn->fetchAll($sql); 
	
	// generate a config array from the data
	if (!$result) {
		// do nothing no data returned
	} else {
		$config_array = array(); 
		foreach ($result as $line) {
			if (isEmptyString($line['section'])) {
				// no section name provided so add the option to the root
				$config_array[$line['optionname']] = $line['optionvalue']; 
			} else {
				// add the option to the section 
				$config_array[$line['section']][$line['optionname']]= $line['optionvalue'];
			}  
		}
		# Add the config object to the registry
		$config = new Zend_Config($config_array); 
		Zend_Registry::set('config', $config);
		# cache the config object
		$cache->save($config, 'config');
	}
}
/**
 * Create a Zend_Mail instance from the registry, clear all recipients and the existing subject
 * 
 * @return Zend_Mail 
 */
function getMailInstance() {
	// create mail object
	$mail = Zend_Registry::get("mail");
	//TODO: Temporary workaround for subject set twice error message
	// clear the subject to prevent an error when sending multiple emails in the same session
	$mail->clearSubject(); 
	// clear the addresses too
	$mail->clearRecipients();
	
	return $mail; 
}
/**
 * Return an instance of the access control list 
 *
 * @return ACL 
 */
function getACLInstance() {
	$cache = Zend_Registry::get('cache'); 
	$session = SessionWrapper::getInstance(); 
	// check if the acl is cached
	$aclkey = "acl".$session->getVar('userid'); 
	$acl = $cache->load($aclkey); 
	if (!$acl) {
		$acl = new ACL($session->getVar('userid')); 
	}
	
	return $acl; 
}
/**
 * Return the file extension from a file name
 * 
 * @param string $filename
 * @return The file extension 
 */
function findExtension($filename){  
	return substr(strrchr($filename,'.'),1);
}
/**
 * Decode all html entities of an array  
 * @param Array $elem the array to be decoded
 */
function decodeHtmlEntitiesInArray(&$elem){ 
	if (!is_array($elem)) { 
    	$elem=html_entity_decode($elem); 
	}  else  { 
		foreach ($elem as $key=>$value){
			$elem[$key]=decodeHtmlEntitiesInArray($value);
		} 
  	} 
	return $elem; 
}
 /**
 * Trims a given string with a length more than a specified length with a more link to view the details 
 *
 * @param string $text
 * @param int $length
 * @param string $tail
 * @return string the substring with a more link as the tail
 */
function snippet($text, $length, $tail) {
	$text = trim($text);
	$txtl = strlen($text);
	if ($txtl > $length) {
		for($i = 1; $text[$length - $i] != " "; $i ++) {
			if ($i == $length) {
				return substr($text, 0, $length) . $tail;
			}
		}
		for(; $text[$length - $i] == "," || $text[$length - $i] == "." || $text[$length - $i] == " "; $i ++) {
			;
		}
		$text = substr($text, 0, $length - $i + 1) . $tail;
	}
	return $text;
} 
function formatBytes($size, $precision = 2) { 
    $base = log($size) / log(1000);
    $suffixes = array('', 'kb', 'MB', 'GB', 'TB');   

    return round(pow(1000, $base - floor($base)), $precision) . $suffixes[floor($base)];
}
 /*
 * Generate a thumbnail from a source and a new width
 */
function resizeImage($in_filename, $out_filename, $width){
	$src_img = ImageCreateFromJpeg($in_filename);

    $old_x = ImageSX($src_img);
    $old_y = ImageSY($src_img);
    
    /* find the "desired height" of this thumbnail, relative to the desired width  */
  	$desired_height = floor($old_y *($width/$old_x));
  
    $dst_img = ImageCreateTrueColor($width, $desired_height);
    ImageCopyResampled($dst_img, $src_img, 0, 0, 0, 0, $width, $desired_height, $old_x, $old_y);

    ImageJpeg($dst_img, $out_filename, 100);

    ImageDestroy($dst_img);
    ImageDestroy($src_img);
}
# determine key for an array in a multimensional array
function array_search_key($all, $checkarray) {
   foreach ($all as $key => $value) {
		// debugMessage($subkey);
		if($checkarray['id'] == $value['id'] && count(array_diff($value, $checkarray)) == 0){
			return $key;
		}
   }
}
# determine key for id in multidimensional array
function array_search_key_by_id($themultiarray, $theid) {
   foreach ($themultiarray as $key => $value) {
		// debugMessage($subkey);
		if($theid == $value['id']){
			return $key;
		}
   }
}
# synchronise to multimensional arrays
function multidimensional_array_merge($oldarray, $newarray){
    $result = array();
    foreach($oldarray as $key => $value){
    	$result[$key] = $value;
        foreach ($newarray as $n_key => $n_value) {
        	if(strval($n_key) == strval($key)){
        		// debugMessage($value); debugMessage($newarray[$key]);
        		$merged = array_merge($oldarray[$key], $newarray[$n_key]);
        		unset($result[$key]);
        		$result[$key] = $merged;
        	} else {
        		$result[$n_key] = $n_value;
        	}
        }
        // debugMessage($oldarray[$n_key]);
    }
    return $result;
}
# convert text to url
function textToUrl($txtstring){
	if(isEmptyString($txtstring)){
		return '---';
	}
	return "<a href='".$txtstring."' target='_blank' title='Visit address'>".$txtstring."</a>";
}
# determine if person has profile image
function hasProfileImage($id, $photoname){
	$real_path = APPLICATION_PATH."/../public/uploads/user_";
 	if (APPLICATION_ENV == "production") {
 		$real_path = str_replace("public/", "", $real_path); 
 	}
	$real_path = $real_path.$id.DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR."base_".$photoname;
	if(file_exists($real_path) && !isEmptyString($photoname)){
		return true;
	}
	return false;
}
# determine path to small profile picture
function getSmallPicturePath($id, $gender, $photoname) {
	$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
	$path= "";
	if(isMale($gender)){
		$path = $baseUrl.'/uploads/user_0/avatar/default_small_male.jpg';
	}  
	if(isFemale($gender)){
		$path = $baseUrl.'/uploads/user_0/avatar/default_small_female.jpg'; 
	}
	if(hasProfileImage($id, $photoname)){
		$path = $baseUrl.'/uploads/user_'.$id.'/avatar/small_'.$photoname;
	}
	return $path;
}
# determine path to thumbnail profile picture
function getThumbnailPicturePath($id, $gender, $photoname) {
	$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
	$path= "";
	if(isMale($gender)){
		$path = $baseUrl.'/uploads/user_0/avatar/default_thumbnail_male.jpg';
	}  
	if(isFemale($gender)){
		$path = $baseUrl.'/uploads/user_0/avatar/default_thumbnail_female.jpg'; 
	}
	if(hasProfileImage($id, $photoname)){
		$path = $baseUrl.'/uploads/user_'.$id.'/avatar/thumbnail_'.$photoname;
	}
	return $path;
}
# determine path to medium profile picture
function getMediumPicturePath($id, $gender, $photoname) {
	$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
	$path= "";
	if(isMale($gender)){
		$path = $baseUrl.'/uploads/user_0/avatar/default_medium_male.jpg';
	}  
	if(isFemale($gender)){
		$path = $baseUrl.'/uploads/user_0/avatar/default_medium_female.jpg'; 
	}
	if(hasProfileImage($id, $photoname)){
		$path = $baseUrl.'/uploads/user_'.$id.'/avatar/medium_'.$photoname;
	}
	return $path;
}
# determine path to large profile picture
function getLargePicturePath($id, $gender, $photoname) {
	$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
	$path= "";
	if(isMale($gender)){
		$path = $baseUrl.'/uploads/user_0/avatar/default_large_male.jpg';
	}  
	if(isFemale($gender)){
		$path = $baseUrl.'/uploads/user_0/avatar/default_large_female.jpg'; 
	}
	if(hasProfileImage($id, $photoname)){
		$path = $baseUrl.'/uploads/user_'.$id.'/avatar/large_'.$photoname;
	}
	// debugMessage($path);
	return $path;
}
# determine if male
function isMale($gender){
	return $gender == '1' ? true : false; 
}
# determine if female
function isFemale($gender){
	return $gender == '2' ? true : false; 
}
# determine if loggedin user is admin
function isAdmin() {
	$session = SessionWrapper::getInstance(); 
	$return = false;
	if($session->getVar('type') == '1'){
		$return = true;
	}
	/*
	$acl = getACLInstance();
	if($acl->checkPermission("Is Admin", ACTION_VIEW)){
		$return = true;
	}*/
	return $return;
}
# determine the country name
function getCountry() {
	$session = SessionWrapper::getInstance();
	return $session->getVar('country');
}
# get domain 
function getDomain(){
	$domain = 'farmis.ug';
	if(isKenya()){
		$domain = 'farmis.co.ke';
	}
	return $domain;
}
# determine if browsing uganda
function isUganda() {
	$session = SessionWrapper::getInstance();
	return $session->getVar('country') == 'ug' ? true : false;
}
# determine the country name
function getCountryName($country = '') {
	$session = SessionWrapper::getInstance();
	if(!isEmptyString($country)){
		return $country == 'ug' ? 'Uganda' : 'Kenya';
	}
	return $session->getVar('country') == 'ug' ? 'Uganda' : 'Kenya';
}
function getCurrencyCode() {
	$session = SessionWrapper::getInstance();
	return isUganda() ? COUNTRY_CODE_UG : COUNTRY_CODE_KE;
}
function getCurrencySymbol() {
	$session = SessionWrapper::getInstance();
	return isUganda() ? 'Shs' : 'KShs';
}
function getServiceAmountFormatted() {
	$session = SessionWrapper::getInstance();
	return $session->getVar('country') == 'ug' ? 'Ugx 20,000' : 'KShs 850';
}
function getServiceAmount() {
	$session = SessionWrapper::getInstance();
	return $session->getVar('country') == 'ug' ? '20000' : '850';
}
# determine if browsing kenya
function isKenya() {
	$session = SessionWrapper::getInstance(); 
	return $session->getVar('country') == 'ke' ? true : false;
}
# determine if loggedin user is subscriber
function isFarmer() {
	$session = SessionWrapper::getInstance(); 
	return $session->getVar('type') == '2' ? true : false;
}
# determine if loggedin user is subscriber
function isFarmGroupAdmin() {
	$session = SessionWrapper::getInstance(); 
	return $session->getVar('type') == '3' ? true : false;
}
# determine if loggedin user is data clerk
function isDataClerk() {
	$session = SessionWrapper::getInstance(); 
	return $session->getVar('type') == '4' ? true : false;
}
# determine if loggedin user is data clerk
function isPIA() {
	$session = SessionWrapper::getInstance(); 
	return $session->getVar('type') == '4' ? true : false;
}
# determine if loggedin user is management
function isManagement() {
	$session = SessionWrapper::getInstance(); 
	return $session->getVar('type') == '5' ? true : false;
}
# determine current status label
function getStatusText($status) {
	$text = '--';
	if(!isEmptyString($status)){
		$values = getStatusValues();
		$text = $values[$status];
    }
	return $text;
}
function png2jpg($originalFile, $outputFile, $quality) {
    $image = imagecreatefrompng($originalFile);
    imagejpeg($image, $outputFile, $quality);
    imagedestroy($image);
}
function ak_img_convert_to_jpg($target, $newcopy, $ext) {
    list($w_orig, $h_orig) = getimagesize($target);
    $ext = strtolower($ext);
    $img = "";
    if ($ext == "gif"){ 
        $img = imagecreatefromgif($target);
    } else if($ext =="png"){ 
        $img = imagecreatefrompng($target);
    }
    $tci = imagecreatetruecolor($w_orig, $h_orig);
    imagecopyresampled($tci, $img, 0, 0, 0, 0, $w_orig, $h_orig, $w_orig, $h_orig);
    imagejpeg($tci, $newcopy, 84);
}
/**
 * Determine the Unix timestamp of a given MySql date
 * @param string the MySql date whose timestamp is being determined
 * @return string the timestamp of the MySql date specified
 */
function convertMySqlDateToUnixTimestamp($mysqldate) {
	if ($mysqldate) {
		$parts = explode(' ', $mysqldate);
	}
	$datebits = explode('-', $parts[0]);
	if (3 != count($datebits)) {
		return -1;
	}
	if (isset($parts[1])) {
		$timebits = explode(':', $parts[1]);
		if (3 != count($timebits)) return -1;
		return mktime($timebits[0], $timebits[1], $timebits[2], $datebits[1], $datebits[2], $datebits[0]);
	}
	return mktime (0, 0, 0, $datebits[1], $datebits[2], $datebits[0]);
}
function sort_multi_array ($array, $key, $order="DESC"){
  $keys = array();
  for ($i=1;$i<func_num_args();$i++) {
    $keys[$i-1] = func_get_arg($i);
  }

  // create a custom search function to pass to usort
  $func = function ($a, $b) use ($keys) {
    for ($i=0;$i<count($keys);$i++) {
      if ($a[$keys[$i]] != $b[$keys[$i]]) {
        return ($a[$keys[$i]] < $b[$keys[$i]]) ? -1 : 1;
      }
    }
    return 0;
  };
  usort($array, $func);
  if($order != "DESC"){
  	$result = $array;
  } else {
  	$result = array_reverse($array, true);
  }
  return $result;
}
function num_to_letter($num, $uppercase = FALSE){
	$num -= 1;
	
	$letter = 	chr(($num % 26) + 97);
	$letter .= 	(floor($num/26) > 0) ? str_repeat($letter, floor($num/26)) : '';
	return 		($uppercase ? strtoupper($letter) : $letter); 
}
# return the formatted phone number
function getShortPhone($phone){
	if(isEmptyString($phone)){
		return '';
	}
	$phone = str_pad(ltrim($phone, '256'), 10, '0', STR_PAD_LEFT);
	if(isKenya()){
		$phone = str_pad(ltrim($phone, '254'), 10, '0', STR_PAD_LEFT);
	}
	return $phone; 
} 
function getFullPhone($phone){
	if(isEmptyString($phone)){
		return '';
	}
	$phone = str_pad(ltrim($phone, '0'), 12, COUNTRY_CODE_UG, STR_PAD_LEFT);
	if(isKenya()){
		$phone = str_pad(ltrim($phone, '0'), 12, COUNTRY_CODE_KE, STR_PAD_LEFT);
	}
	return $phone;
}
function _is_curl_installed() {
    if  (in_array  ('curl', get_loaded_extensions())) {
        return true;
    }
    else{
        return false;
    }
}
function clean_num($num){
	if(isEmptyString($num)){
		return '';		
	}
	return rtrim(rtrim(number_format($num, 2, ".", ""), '0'), '.');
}
// function to covert simple xml to an array
// Convert an xml object in to an array
/**
 * convert xml string to php array - useful to get a serializable value
 *
 * @param string $xmlstr 
 * @return array
 * @author Adrien aka Gaarf
 */
function xmlstr_to_array($xmlstr) {
  $doc = new DOMDocument();
  $doc->loadXML($xmlstr);
  return domnode_to_array($doc->documentElement);
}
function domnode_to_array($node) {
  $output = array();
  switch ($node->nodeType) {
   case XML_CDATA_SECTION_NODE:
   case XML_TEXT_NODE:
    $output = trim($node->textContent);
   break;
   case XML_ELEMENT_NODE:
    for ($i=0, $m=$node->childNodes->length; $i<$m; $i++) { 
     $child = $node->childNodes->item($i);
     $v = domnode_to_array($child);
     if(isset($child->tagName)) {
       $t = $child->tagName;
       if(!isset($output[$t])){
       	// debugMessage($output[$t]);
        $output[$t] = array();
       }
       $output[$t][] = $v;
     }
     elseif($v) {
      $output = (string) $v;
     }
    }
    if(is_array($output)) {
     if($node->attributes->length) {
      $a = array();
      foreach($node->attributes as $attrName => $attrNode) {
       $a[$attrName] = (string) $attrNode->value;
      }
      $output['@attributes'] = $a;
     }
     foreach ($output as $t => $v) {
      if(is_array($v) && count($v)==1 && $t!='@attributes') {
       $output[$t] = $v[0];
      }
     }
    }
   break;
  }
  return $output;
}
# left pad number with zeros
function number_pad($number,$n) {
	return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}
# determine the number of days between two dates
function dateDiff($start, $end) {
	$start_ts = strtotime($start);
	$end_ts = strtotime($end);
	$diff = $end_ts - $start_ts;
	return round($diff / 86400);

}
function isUgNumber($number){
	$valid=true;
	$first3chars = substr($number, 0, 3);
	$allowed = array("077","078","070","071","075","079",'256');
	if(!in_array($first3chars, $allowed)) {
		$valid = false;
	}
	if(!is_numeric($number)){
		$valid = false;
	}
	if(substr($number, 0, 1) != 0 && substr($number, 0, 3) != 256){
		$valid = false;
	}
	if(substr($number, 0, 1) == 0 && strlen($number) != 10){
		$valid = false;
	}
	if(substr($number, 0, 3) == 256 && strlen($number) != 12){
		$valid = false;
	}
	return $valid;
}
function isKeNumber($number){
	$valid=true;
	$first3chars = substr($number, 0, 3);
	$allowed = array("070","071","072","073","075","077","078");
	if(!in_array($first3chars, $allowed)) {
		$valid = false;
	}
	if(!is_numeric($number)){
		$valid = false;
	}
	if(substr($number, 0, 1) != 0 && substr($number, 0, 3) != 254){
		$valid = false;
	}
	if(substr($number, 0, 1) == 0 && strlen($number) != 10){
		$valid = false;
	}
	if(substr($number, 0, 3) == 254 && strlen($number) != 12){
		$valid = false;
	}
	return $valid;
}
function getPhoneProvider($number, $country = 'UG'){
	$first3chars = substr($number, 0, 3);
	if(strtoupper($country) == 'UG'){
		$allowed = array("077","078","070","071","075","079");
		$allowed_names = array("077"=>"MTN Uganda", "078"=>"MTN Uganda", "070"=>"Warid Telcom", "071"=>"Uganda Telecom", "075"=>"Airtel", "079"=>"Orange");
		if(!in_array($first3chars, $allowed)) {
			return 'Unknown';
		}
		return $allowed_names[$first3chars];
	}
	if(strtoupper($country) == 'KE'){
		$allowed = array("070","071","072","073","075","077","078");
		$allowed_names = array("070"=>"Safaricom", "071"=>"Safaricom", "072"=>"Safaricom", "073"=>"Airtel", "075"=>"Essar Telecom", "077"=>"Orange", "078"=>"Airtel");
		if(!in_array($first3chars, $allowed)) {
			return 'Unknown';
		}
		return $allowed_names[$first3chars];
	}
}
function getAgent(){
	$tablet_browser = 0;
	$mobile_browser = 0;
	 
	if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
	    $tablet_browser++;
	}
	 
	if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
	    $mobile_browser++;
	}
	 
	if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
	    $mobile_browser++;
	}
	 
	$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
	$mobile_agents = array(
	    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
	    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
	    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
	    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
	    'newt','noki','palm','pana','pant','phil','play','port','prox',
	    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
	    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
	    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
	    'wapr','webc','winw','winw','xda ','xda-');
	 
	if (in_array($mobile_ua,$mobile_agents)) {
	    $mobile_browser++;
	}
	 
	if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
	    $mobile_browser++;
	    //Check for tablets on opera mini alternative headers
	    $stock_ua = strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
	    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
	      $tablet_browser++;
	    }
	}
	 
	if ($tablet_browser > 0) {
	   // do something for tablet devices
	   return 'tablet';
	}
	else if ($mobile_browser > 0) {
	   // do something for mobile devices
	   return 'mobile';
	}
	else {
	   // do something for everything else
	   return 'desktop';
	}
}
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
function calcutateAge($dob){
	$dob = date("Y-m-d",strtotime($dob));

	$dobObject = new DateTime($dob);
	$nowObject = new DateTime();

	$diff = $dobObject->diff($nowObject);

	return $diff->y;

}
function stringContains($substr, $str){
	if(strpos($str, $substr) !== false) {
		return true;
	}
	return false;
}
/**
 * 
 * Check whether the transaction ID has already been used, then it is a duplicate transaction
 * 
 * @param String $txn_idFromPaypal The Transaction ID from Paypal 
 * 
 * @return bool TRUE if the transaction ID does not exist in the database, and FALSE if the transaction ID already exists
 */
function isTransactionIDValid($txn_idFromPaypal) {
	$conn = Doctrine_Manager::connection(); 
	$query = "SELECT txn_id from payment WHERE txn_id = '".$txn_idFromPaypal."'";
	$result = $conn->fetchOne($query); 
	
	if(!isEmptyString($result)){ 
		// an error occured while processing the query
		sendTestMessage("Paypal Transaction ID ".$txn_idFromPaypal." already exists!!", "Query: ".$query.", <br>Error: ");
		return false;
	} else {
		// if there are no rows returned then txn_id has not been used before and is therefore valid.	
		return true;
	}
}
/**
 * 
 * Update the expiry date once an author has completed payment
 * @param unknown_type $custom
 * @param unknown_type $paymentid
 * @param unknown_type $item_number
 */
function executeCustomLogic($custom, $paymentid, $item_number) {
	//sendTestMessage("Params: ".$custom." - ".$paymentid." - ".$item_number);
	// update the author's profile to indicate a new expiry date
	$user = new UserAccount();
	$user->populate($custom);
	
	//sendTestMessage("Old Expiry Date: ".$user->getExpiryDate(), "");		
	if(isEmptyString($user->getExpiryDate())){
		$startdate =  new DateTime();
		$expdate = new DateTime();
		$expdate->modify("+1 month"); 
		$user->setExpiryDate($expdate->format('Y-m-d'));
	} else {
		$expdate = new DateTime($user->getExpiryDate());
		$startdate = new DateTime($user->getExpiryDate());
		
		// $startdate = $user->getExpiryDate();
		// if the expiry date is before today, then use today as the timestamp
		// DateTime::getTimestamp() only works for PHP > 5.3 which is not supported by the hosting providers
		if ($expdate->format('U') < time()) {
			$expdate = new DateTime(); 
			$startdate = new DateTime();
		}
		$expdate->modify("+1 month"); 
		// update the expiry date for the user
		$user->setExpiryDate($expdate->format('Y-m-d'));
	}
	// save the updates to the user account and payments record
	try {	
		// update the record in the DB
		$user->save();
		// clear the variable inactive in session
		$session = SessionWrapper::getInstance(); 
		$session->setVar("accountinactive", "");
		$session->setVar("accountexpired", "");
		
		//sendTestMessage("Start Date: ", $startdate->format('Y-m-d'));
		//sendTestMessage("Enddate: ", $expdate->format('Y-m-d'));
		$paymentsupdate_query = "UPDATE payment SET startdate = '".$startdate->format('Y-m-d')."', enddate = '".$expdate->format('Y-m-d')."' WHERE id = '".$paymentid."'";
		//sendTestMessage("Query: ", $paymentsupdate_query);
		$conn = Doctrine_Manager::connection(); 
		$result = $conn->execute($paymentsupdate_query); 
		if (!$result) {
			sendTestMessage("Failed to update the payment table: ".$paymentid, "");
			# an error occured, log it and send a message
			//$this->_logger->err("Error Updating Payment Dates in Database. Query :".$paymentsupdate_query." - error ".mysql_error()); 
		}
		// TODO send an email confirming the payment
		$user->sendSubscriptionRenewalNotification();
	} catch (Exception $e){
		sendTestMessage("Failed to update the user details".$custom, "");
		//$this->_logger->err("An error occured while updating the subscription period for ".$company->getName()." ".$company->getErrorStackAsString());
	}
}
function greatUser($name){
	$b = time();

	$hour = date("g",$b);
	$m = date ("A", $b);

	$txt = '';
	if ($m == "AM"){
		if ($hour == 12){
			$txt = "Good Evening";
		} else if ($hour < 4){
			$txt = "Good Evening";
		} elseif ($hour > 3){
			$txt = "Good Morning";
		}
	} elseif ($m == "PM") {
		if ($hour == 12){
			$txt = "Good Afternoon";
		} elseif ($hour < 7){
			$txt = "Good Afternoon";
		} elseif ($hour > 6) {
			$txt = "Good Evening";
		}
	}
	return $txt.', '.$name;
}
?>