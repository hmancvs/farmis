<?php
class StoreController extends IndexController   {
	
	function successAction(){
	}
	function failureAction(){
	}
	function ipnAction(){
		// disable rendering of the view and layout since it is not needed for this particular page 
		$this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
		
	    // check if this is a subscriber signup action, then ignore it since it is just confirming that 
	    // a recurring payment profile has been created 
	    if ($this->_getParam('txn_type') == 'subscr_signup') {
	    	// do not countinue
	    	return; 
	    }
	    
	    $config = Zend_Registry::get("config"); 
	    
		// below supported vals that paypal posts to us, this list is exhaustive..
		// NOTE: if a variable is not in this array, it is not going in the database. 
		$paypal_vals = array("item_name", "item_number", "custom", 
			"receiver_email", "receiver_id", "quantity", "memo", "payment_type", "payment_status", 
			"payment_date", "payment_gross", "payment_fee",
			"mc_gross", "mc_fee", "mc_currency", "settle_amount", "settle_currency", "exchange_rate",
			"txn_id", "parent_txn_id", "txn_type", "first_name", "last_name", "payer_business_name", 
			"address_name", "address_street", "address_city", "address_zip", "address_status",
			"address_country", "payer_email", "payer_id", "payer_status","pending_reason", "reason_code",
			"notify_version", "verify_sign"); 
		
		// these are used later to verify validity of transaction
		$payment_status = $this->_getParam('payment_status');
		$txn_id = $this->_getParam('txn_id');
		$receiver_email = $this->_getParam('receiver_email');
		
		// read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		$addtosql = array();
		$params = $this->_getAllParams();
		foreach ($params as $key => $value) {
			$newvalue = urlencode(stripslashes($value));		
			$req .= "&".$key."=".$newvalue;		
			// build insert statement to save papypal variables to database
			if ($key == 'payment_date') {
				// transform the paymentdate into a proper date for inserting into the database
				$addtosql[] = " ".$key."='".changeDateFromPageToMySQLFormat($value)."'"; 
			} else {
				// process other fields 
				if (in_array ($key, $paypal_vals)) { 
					if (is_numeric($value)) { 
		            	$addtosql[] = " ".$key."=".$value; 
		        	} else { 
		            	$addtosql[]= " ".$key."='".$value."'"; 
		        	} 
				}
			} 
	    }
		$queryForPaypalInfo = "INSERT INTO payment SET ".implode(", ", $addtosql);
		
		// Check whether or not paypal txn_id is a duplicate before adding new paypal info
		// to the database	
		$transactionIDValid = isTransactionIDValid($txn_id);	
		// Save transaction details from Paypal to persistent store (file or database).
		//$result = mysql_query($queryForPaypalInfo);
		$conn = Doctrine_Manager::connection(); 
		$result = $conn->execute($queryForPaypalInfo); 
		$paymentid = $conn->lastInsertId();
		if (!$result) {
			# an error occured, log it and send a message
			$this->_logger->err("Error Inserting Paypal Transaction in Database. Query :".$queryForPaypalInfo." - error ".mysql_error()); 
		}	
		
		// post back to PayPal system to verify the transaction 
		$client = new Zend_Http_Client($config->paypal->serverurl);
		$client->setMethod(Zend_Http_Client::POST);
		$client->setParameterPost(array_merge(
										array('cmd' => '_notify-validate'),
										$this->_getAllParams()
								  )
		);
		$response = $client->request();
		
		if ($response->getBody() == 'VERIFIED'){
			// check the payment_status is Completed
			if ($payment_status != "Completed") {					
				// payment not completed, just exit.	
				return; 
			}
			//  check that txn_id has not been previously processed
			if ($transactionIDValid == false) {
				return; 			
			}
			// check that receiver_email is your Primary PayPal email
			if ($receiver_email != $config->paypal->receiveremail) {					
				// receiver email is not primary email, just exit.
				return; 
			}
			
			// execute the custom login i.e. update the expiry date in the useraccount table and set the start and end dates in the payment table
			executeCustomLogic($this->_getParam('custom'), $paymentid, $this->_getParam('item_number'));
		} else {
			// TODO: log for manual investigation
			sendTestMessage("Paypal POST BACK VERIFICATION failed: Log manual investigation", "Paypal POST BACK VERIFICATION failed: Log manual investigation");
			$this->_logger->err("Paypal payment with Txn #".$txn_id." is invalid, manual investigation required");
		}
	}	
}