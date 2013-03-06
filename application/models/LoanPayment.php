<?php

/**
 * Model for loan payment
 *
 */

class LoanPayment extends BaseRecord  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('loanpayment');
		$this->hasColumn('loanid', 'integer', null, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('amount', 'decimal', 11, array('notnull' => true, 'notblank' => true, 'default' => '0'));
		$this->hasColumn('paymentdate','date', null, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('paidby','string', 255);
		$this->hasColumn('notes','string', 1000);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("paymentdate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"loanid.notblank" => "Please specify the loan details",
       									"amount.notblank" => "Please enter loan payment amount",
       									"paymentdate.notblank" => "Please select payment date"
       	       						));
	}
	public function setUp() {
		parent::setUp();
		
		$this->hasOne('Loan as loanentry',
							array('local' => 'loanid',
									'foreign' => 'id'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		
		parent::processPost($formvalues);
	}
}

?>