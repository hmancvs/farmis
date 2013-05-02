<?php

class ApiController extends IndexController  {

    function indexAction() {
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
    }
    
    function farmerAction() {
    	$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(TRUE);
	    $conn = Doctrine_Manager::connection(); 
    	$session = SessionWrapper::getInstance();
    	$formvalues = $this->_getAllParams();
    	
    	$feed = '';
    	$hasall = true;
    	$issearch = false;
    	$iscount = false;
    	$ispaged = false;
    	$where_query = " ";
    	$type_query = " ";
    	$group_query = " GROUP BY f.id ";
    	$limit_query = "";
    	$select_query = " f.id, f.firstname, f.lastname, f.othernames, u.email, t.phone 
    	";
    	
    	if(isArrayKeyAnEmptyString('filter', $formvalues)){
    		echo "NO_FILTER_SPECIFIED";
    		exit();
    	}
    	
    	// global search
    	if($this->_getParam('filter') == 'search'){
    		if(isEmptyString($this->_getParam('searchterm'))){
    			echo "NO_SEARCHTERM_SPECIFIED";
    			exit();
    		}
    	}
    	
    	// search by column
    	if($this->_getParam('filter') == 'column'){
    		// fetch by phone
    		if($this->_getParam('getphone') == 'Y'){
    			$phone = $this->_getParam('phone');
    			if(isEmptyString($phone)){
    				echo "PHONE_NULL";
	    			exit();
    			}
    			if(!isEmptyString($phone) && !isUgNumber($phone)){
    				echo "PHONE_INVALID";
	    			exit();
    			}
    			$formated_phone = substr($phone, -9);
    			// debugMessage($formated_phone);
    			$where_query .= " AND t.phone LIKE '%".$formated_phone."%' ";
    		}
    		// fetch by firstname
    		if($this->_getParam('getfirstname') == 'Y'){
    			$firstname = $this->_getParam('firstname');
    			if(isEmptyString($phone)){
    				echo "FIRSTNAME_NULL";
	    			exit();
    			}
    			// debugMessage($formated_phone);
    			$where_query .= " AND u.firstname LIKE '%".$firstname."%' ";
    		}
    		// fetch by lastname
    		if($this->_getParam('getlastname') == 'Y'){
    			$firstname = $this->_getParam('lastname');
    			if(isEmptyString($firstname)){
    				echo "LASTNAME_NULL";
	    			exit();
    			}
    			$where_query .= " AND u.lastname LIKE '%".$firstname."%' ";
    		}
    		// fetch by email
    		if($this->_getParam('getemail') == 'Y'){
    			$email = $this->_getParam('email');
    			if(isEmptyString($email)){
    				echo "EMAIL_NULL";
	    			exit();
    			}
    			$where_query .= " AND u.email LIKE '%".$email."%' ";
    		}
    		// fetch my username
    		if($this->_getParam('getusername') == 'Y'){
    			$username = $this->_getParam('username');
    			if(isEmptyString($username)){
    				echo "USERNAME_NULL";
	    			exit();
    			}
    			$where_query .= " AND u.username LIKE '%".$username."%' ";
    		}
    	}
    	
   	 	// when fetching total results
    	if(!isEmptyString($this->_getParam('fetch')) && $this->_getParam('fetch') == 'total'){
    		$select_query = " count(c.id) as records ";
    		$group_query = "";
    		$iscount = true;
    	}
    	// when fetching limited results via pagination 
    	if(!isEmptyString($this->_getParam('paged')) && $this->_getParam('paged') == 'Y'){
    		$ispaged = true;
    		$hasall = false;
    		$start = $this->_getParam('start');
    		$limit = $this->_getParam('limit');
    		if(isEmptyString($start)){
    			echo "RANGE_START_NULL";
	    		exit();
    		}
    		if(!is_numeric($limit)){
    			echo "INVALID_RANGE_START";
	    		exit();
    		}
    		if(isEmptyString($start)){
    			echo "RANGE_LIMIT_NULL";
	    		exit();
    		}
    		if(!is_numeric($limit)){
    			echo "INVALID_RANGE_LIMIT";
	    		exit();
    		}
    		$limit_query = " limit ".$start.",".$limit." ";
    	}
    	
   	 	$mak_query = "SELECT ".$select_query." FROM farmer f 
   	 	INNER JOIN useraccount u ON f.userid = u.id 
   	 	LEFT JOIN userphone t ON (t.userid = u.id) LEFT JOIN 
    	subscription as s ON (s.userid = u.id) WHERE f.id <> '' ".$type_query.$where_query."  
    	".$group_query." ORDER BY f.firstname ASC ".$limit_query;
    	debugMessage($mak_query);
    	
    	$result = $conn->fetchAll($mak_query);
    	$makcount = count($result);
    	debugMessage($result); // exit();
    	
    	if($makcount == 0){
    		echo "RESULT_NULL";
    		exit();
    	} else {
    		if($iscount){
    			$feed .= '<item>';
	    		$feed .= '<total>'.$result[0]['records'].'</total>';
			    $feed .= '</item>';
    		}
    		if(!$iscount){
	    		foreach ($result as $line){
			    	$feed .= '<item>';
		    		$feed .= '<id>'.$line['id'].'</id>';
		    		$feed .= '<name>'.$line['firstname']." ".$line['lastname']." ".$line['othernames'].'</name>';
			    	$feed .= '<email>'.$line['email'].'</email>';
			    	$feed .= '<phone>'.$line['phone'].'</phone>';
				    $feed .= '</item>';
		    	}
    		}
    	}
    	
    	# output the xml returned
    	if(isEmptyString($feed)){
    		echo "EXCEPTION_ERROR";
    		exit();
    	} else {
    		echo '<?xml version="1.0" encoding="UTF-8"?><items>'.$feed.'</items>';
    	}
    	
    }
}

