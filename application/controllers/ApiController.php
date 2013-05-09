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
    	$iscolumn = false;
    	$where_query = " ";
    	$type_query = " ";
    	$group_query = " GROUP BY f.id ";
    	$limit_query = "";
    	$select_query = " f.id, f.firstname, f.lastname, f.othernames, u.email, t.phone, t2.phone as altphone,
    	l.name as district, fg.orgname as farmgroup, u.dateofbirth, f.regdate, u.isactive, s.startdate, 
    	s.enddate, s.planid as paymentplan, s.id as sid, group_concat(c.name separator ',') as crops
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
    	if($this->_getParam('filter') == 'column' || $this->_getParam('filter') == 'search'){
    		if($this->_getParam('filter') == 'column'){
    			$iscolumn = true;
    		}
    		if($this->_getParam('filter') == 'search' && !isEmptyString($this->_getParam('searchterm'))){
    			$issearch = true;
    		}
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
    			if(isEmptyString($firstname)){
    				echo "FIRSTNAME_NULL";
	    			exit();
    			}
    			// debugMessage($formated_phone);
    			$where_query .= " AND u.firstname LIKE '%".$firstname."%' ";
    		}
    		// fetch by lastname
    		if($this->_getParam('getlastname') == 'Y'){
    			$lastname = $this->_getParam('lastname');
    			if(isEmptyString($lastname)){
    				echo "LASTNAME_NULL";
	    			exit();
    			}
    			$where_query .= " AND u.lastname LIKE '%".$lastname."%' ";
    		}
    		// fetch by email
    		if($this->_getParam('getemail') == 'Y'){
    			$email = $this->_getParam('email');
    			if(isEmptyString($email)){
    				echo "EMAIL_NULL";
	    			exit();
    			}
    			// TODO add check for invalid email
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
    		if($issearch){
    			$searchterm = $this->_getParam('searchterm');
    			$where_query .= " AND (t.phone LIKE '%".$searchterm."%' OR u.firstname LIKE '%".$searchterm."%'  
    				OR u.lastname LIKE '%".$searchterm."%' OR u.email LIKE '%".$searchterm."%' OR u.username LIKE '%".$searchterm."%'
    			)";
    			// debugMessage($where_query);
    		}
    	}
    	
   	 	// when fetching total results
    	if(!isEmptyString($this->_getParam('fetch')) && $this->_getParam('fetch') == 'total'){
    		$select_query = " count(f.id) as records ";
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
    		if(!is_numeric($start)){
    			echo "INVALID_RANGE_START";
	    		exit();
    		}
    		if(isEmptyString($limit)){
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
   	 	INNER JOIN useraccount u ON (f.userid = u.id) 
   	 	INNER JOIN location l ON (u.locationid = l.id AND l.locationtype = 2) 
   	 	LEFT JOIN userphone t ON (t.userid = u.id AND t.isprimary = 1) 
   	 	LEFT JOIN userphone t2 ON (t2.userid = u.id AND t.isprimary = 0) 
   	 	LEFT JOIN subscription as s ON (s.userid = u.id AND s.isactive = 1)
   	 	LEFT JOIN farmgroup fg ON (f.farmgroupid = fg.id)  
   	 	LEFT JOIN farmcrop as fc ON (fc.userid = u.id)
   	 	LEFT JOIN commodity as c ON (fc.cropid = c.id)
   	 	WHERE f.id <> '' ".$type_query.$where_query."  
    	".$group_query." ORDER BY f.firstname ASC ".$limit_query;
    	// debugMessage($mak_query);
    	
    	$result = $conn->fetchAll($mak_query);
    	$makcount = count($result);
    	// debugMessage($result); // exit();
    	
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
	    			# determine if current subscription has a valid payment assigned to it
	    			$subscriptionexists = false;
	    			if(!isEmptyString($line['paymentplan']) && !isEmptyString($line['startdate']) && !isEmptyString($line['enddate'])){
	    				$subscriptionexists = true;
	    			}
	    			$paid = 0;
	    			if($subscriptionexists && $line['paymentplan'] == 2){
	    				$subscription = new Subscription();
	    				$subscription->populate($line['sid']);
	    				// debugMessage($subscription->toArray());
	    				$payment = $subscription->getPayment();
	    				$haspayment = false;
	    				
	    				if($payment->get(0)){
		    				if(!isEmptyString($payment->get(0)->getID())){
		    					$haspayment = true;
		    					$paid = 1;
		    				}
	    				}
	    				
	    				$start_stamp = Strtotime($line['startdate']);
	    				$now_stamp = strtotime(date('Y-m-d'));
	    				$end_stamp = strtotime($line['enddate']);
	    				if($now_stamp >= $start_stamp && $now_stamp <= $end_stamp && $haspayment){
	    					$haspaid = 1;
	    				}
	    			}
	    			
			    	$feed .= '<item>';
		    		$feed .= '<id>'.$line['id'].'</id>';
		    		$feed .= '<firstname>'.$line['firstname'].'</firstname>';
		    		$feed .= '<lastname>'.$line['lastname'].'</lastname>';
		    		$feed .= '<othernames>'.$line['othernames'].'</othernames>';
			    	$feed .= '<email>'.$line['email'].'</email>';
			    	$feed .= '<phone>'.$line['phone'].'</phone>';
			    	$feed .= '<altphone>'.$line['altphone'].'</altphone>';
			    	$feed .= '<country>UG</country>';
			    	$feed .= '<district>'.$line['district'].'</district>';
			    	$feed .= '<farmgroup>'.$line['farmgroup'].'</farmgroup>';
			    	$feed .= '<dateofbirth>'.$line['dateofbirth'].'</dateofbirth>';
			    	$feed .= '<regdate>'.$line['regdate'].'</regdate>';
			    	$feed .= '<isactive>'.$line['isactive'].'</isactive>';
			    	$feed .= '<paymentplan>'.$line['paymentplan'].'</paymentplan>';
			    	$feed .= '<startdate>'.$line['startdate'].'</startdate>';
			    	$feed .= '<enddate>'.$line['enddate'].'</enddate>';
			    	$feed .= '<hasaccess>'.$paid.'</hasaccess>';
			    	$feed .= '<crops>'.$line['crops'].'</crops>';
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

