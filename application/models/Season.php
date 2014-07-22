<?php

/**
 * Model for season
 *
 */

class Season extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('season');
		$this->hasColumn('userid', 'integer', null, array('notblank' => true));
		$this->hasColumn('activityname', 'string', 255, array('notblank' => true));
		$this->hasColumn('ref', 'string', 50);
		$this->hasColumn('startday', 'string', 4);
		$this->hasColumn('startmonth', 'string', 4, array('notblank' => true));
		$this->hasColumn('startyear', 'string', 4, array('notblank' => true));
		$this->hasColumn('endday', 'string', 4);
		$this->hasColumn('endmonth', 'string', 4);
		$this->hasColumn('endyear', 'string', 4);
		$this->hasColumn('status', 'integer', null, array('default' => '2'));
		$this->hasColumn('cropid', 'integer', null, array('notblank' => true));
		$this->hasColumn('method', 'integer', null, array('default' => '1'));
		$this->hasColumn('notes','string', 1000);
		
		$this->hasColumn('financetype', 'integer', null, array('default' => '1')); // 1 - Own cash, 2 - Saving from previous season, 3 - Soft loan, 4 - Bank loan, 5 - Crop finance 
		$this->hasColumn('netcapital', 'decimal', 11, array('default' => NULL));
		$this->hasColumn('fieldsize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('fieldsizeunit', 'integer', null);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"userid.notblank" => $this->translate->_("season_userid_error"),
       									"cropid.notblank" => $this->translate->_("season_cropid_error"),
       									"activityname.notblank" => $this->translate->_("season_activityname_error")
       	       						));
	}
	public function setUp() {
		parent::setUp();
		
		// match the parent id
		$this->hasOne('UserAccount as user', 
							array(
								'local' => 'userid',
								'foreign' => 'id'
							)
						);
		$this->hasMany('SeasonInput as seasoninputs',
					 		array(
								'local' => 'id',
								'foreign' => 'seasonid'
							)
						);
		$this->hasMany('Loan as loans',
					 		array(
								'local' => 'id',
								'foreign' => 'seasonid'
							)
						);
		$this->hasOne('Commodity as crop',
							array('local' => 'cropid',
									'foreign' => 'id'
							)
						);
		$this->hasMany('SeasonPlanting as seasonplants',
					 		array(
								'local' => 'id',
								'foreign' => 'seasonid'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']); 
		}
		if(isArrayKeyAnEmptyString('method', $formvalues)){
			unset($formvalues['method']); 
		}
		if(isArrayKeyAnEmptyString('fieldsize', $formvalues)){
			unset($formvalues['fieldsize']); 
		}
		if(isArrayKeyAnEmptyString('fieldsizeunit', $formvalues)){
			unset($formvalues['fieldsizeunit']); 
		}
		if(isArrayKeyAnEmptyString('netcapital', $formvalues)){
			unset($formvalues['netcapital']); 
		}
		
		// loan details
		if(!isArrayKeyAnEmptyString('financetype', $formvalues)){
			if($formvalues['financetype'] == 3 || $formvalues['financetype'] == 4 || $formvalues['financetype'] == 5){
				$formvalues['loans'][0]['financetype'] = $formvalues['financetype'];
				$formvalues['loans'][0]['userid'] = $formvalues['userid'];
				isArrayKeyAnEmptyString('principal', $formvalues) ? $formvalues['loans'][0]['principal'] = NULL : $formvalues['loans'][0]['principal'] = $formvalues['principal'];
				isArrayKeyAnEmptyString('interestrate', $formvalues) ? $formvalues['loans'][0]['interestrate'] = NULL : $formvalues['loans'][0]['interestrate'] = $formvalues['interestrate'];
				isArrayKeyAnEmptyString('paybackamount', $formvalues) ? $formvalues['loans'][0]['paybackamount'] = NULL : $formvalues['loans'][0]['paybackamount'] = $formvalues['paybackamount'];
				isArrayKeyAnEmptyString('installment', $formvalues) ? $formvalues['loans'][0]['installment'] = NULL : $formvalues['loans'][0]['installment'] = $formvalues['installment'];
				isArrayKeyAnEmptyString('installmentunit', $formvalues) ? $formvalues['loans'][0]['installmentunit'] = NULL : $formvalues['loans'][0]['installmentunit'] = $formvalues['installmentunit'];
				isArrayKeyAnEmptyString('paybackperiod', $formvalues) ? $formvalues['loans'][0]['paybackperiod'] = NULL : $formvalues['loans'][0]['paybackperiod'] = $formvalues['paybackperiod'];
				isArrayKeyAnEmptyString('paybackperiodunit', $formvalues) ? $formvalues['loans'][0]['paybackperiodunit'] = NULL : $formvalues['loans'][0]['paybackperiodunit'] = $formvalues['paybackperiodunit'];
				isArrayKeyAnEmptyString('creditdate', $formvalues) ? $formvalues['loans'][0]['creditdate'] = NULL : $formvalues['loans'][0]['creditdate'] = changeDateFromPageToMySQLFormat($formvalues['creditdate']);
				isArrayKeyAnEmptyString('financesourceid', $formvalues) ? $formvalues['loans'][0]['financesourceid'] = NULL : $formvalues['loans'][0]['financesourceid'] = $formvalues['financesourceid'];
				isArrayKeyAnEmptyString('financesourcetext', $formvalues) ? $formvalues['loans'][0]['financesourcetext'] = NULL : $formvalues['loans'][0]['financesourcetext'] = $formvalues['financesourcetext'];
				isArrayKeyAnEmptyString('clientid', $formvalues) ? $formvalues['loans'][0]['clientid'] = NULL : $formvalues['loans'][0]['clientid'] = $formvalues['clientid'];
				isArrayKeyAnEmptyString('quantity', $formvalues) ? $formvalues['loans'][0]['quantity'] = NULL : $formvalues['loans'][0]['quantity'] = $formvalues['quantity'];
				isArrayKeyAnEmptyString('quantityunit', $formvalues) ? $formvalues['loans'][0]['quantityunit'] = NULL : $formvalues['loans'][0]['quantityunit'] = $formvalues['quantityunit'];
				isArrayKeyAnEmptyString('price', $formvalues) ? $formvalues['loans'][0]['price'] = NULL : $formvalues['loans'][0]['price'] = $formvalues['price'];
				isArrayKeyAnEmptyString('clienttype', $formvalues) ? $formvalues['loans'][0]['clienttype'] = NULL : $formvalues['loans'][0]['clienttype'] = $formvalues['clienttype'];
				isArrayKeyAnEmptyString('sourcetype', $formvalues) ? $formvalues['loans'][0]['sourcetype'] = NULL : $formvalues['loans'][0]['sourcetype'] = $formvalues['sourcetype'];
				isArrayKeyAnEmptyString('contract', $formvalues) ? $formvalues['loans'][0]['contract'] = NULL : $formvalues['loans'][0]['contract'] = $formvalues['contract'];
			} else {
				$formvalues['loans'] = array();
			}
		}
		// debugMessage($formvalues); // exit();
		parent::processPost($formvalues);
	}
	# the season start date
	function getFullStartDate() {
		$date = "--";
		if(!isEmptyString($this->getStartDay())){
			$thedate = $this->getStartYear()."-".$this->getStartMonth()."-".$this->getStartDay();
			$date = changeMySQLDateToPageFormat($thedate);
		} 
		if(isEmptyString($this->getStartDay()) && !isEmptyString($this->getStartMonth()) && !isEmptyString($this->getStartYear())){
			$months = getAllMonthsAsShortNames();
			$date = $months[$this->getStartMonth()].", ".$this->getStartYear();
		}
		return $date;
	}
	# the season projected end date
	function getFullEndDate() {
		$date = "--";
		if(!isEmptyString($this->getEndDay())){
			$thedate = $this->getEndYear()."-".$this->getEndMonth()."-".$this->getEndDay();
			$date = changeMySQLDateToPageFormat($thedate);
		}
		if(isEmptyString($this->getEndDay()) && !isEmptyString($this->getEndMonth()) && !isEmptyString($this->getEndYear())){
			$months = getAllMonthsAsShortNames();
			$date = $months[$this->getEndMonth()].", ".$this->getEndYear();
		}
		return $date;
	}
	# determine current status label
    function getStatusText() {
    	$text = '--';
    	if(!isEmptyString($this->getStatus())){
    		$values = getStatusValues();
    		$text = $values[$this->getStatus()];
    	}
    	return $text;
    }
    # determine the method of farming used
    function getMethodText(){
    	$text = '--';
    	if(!isEmptyString($this->getMethod())){
    		$values = getFarmingTypes();
    		$text = $values[$this->getMethod()];
    	}
    	return $text;
    }
    # activity name
    function getName(){
    	return !isEmptyString($this->getActivityName()) ? $this->getActivityName() : '--';
    }
	# determine field size units
    function getFieldSizeUnitText() {
    	$text = '--';
    	if(!isEmptyString($this->getFieldSizeUnit())){
    		$values = getAreaUnits();
    		$text = $values[$this->getFieldSizeUnit()];
    	}
    	return $text;
    }
    function getNetCapitalValue(){
    	if(isEmptyString($this->getNetCapital()) || $this->getNetCapital() == 0){
    		return '--';
    	}
    	return formatNumber($this->getNetCapital())."&nbsp;<span class='pagedescription'>(".$this->config->currency->default.")</span>";
    }
    # determine season inputs order by date
    function getAllInputDetails(){
    	$q = Doctrine_Query::create()->from('SeasonInput s')->where("s.seasonid = '".$this->getID()."'")->orderby('s.startdate DESC');
		$result = $q->execute();
		return $result;
    }
	# determine seasontillage enteries in order by date
    function getAllTillageDetails(){
    	$q = Doctrine_Query::create()->from('SeasonTillage s')->where("s.seasonid = '".$this->getID()."'")->orderby('s.startdate DESC');
		$result = $q->execute();
		return $result;
    }
	# determine season planting enteries in order by date
    function getAllPlantingDetails(){
    	$q = Doctrine_Query::create()->from('SeasonPlanting s')->where("s.seasonid = '".$this->getID()."'")->orderby('s.startdate DESC');
		$result = $q->execute();
		return $result;
    }
	# determine season treatment enteries in order by date
    function getAllTreatingDetails(){
    	$q = Doctrine_Query::create()->from('SeasonTracking s')->where("s.seasonid = '".$this->getID()."'")->orderby('s.startdate DESC');
		$result = $q->execute();
		return $result;
    }
    # determine other season enteries in order by date
    function getAllOtherActivityDetails(){
    	$q = Doctrine_Query::create()->from('SeasonActivity s')->where("s.seasonid = '".$this->getID()."'")->orderby('s.startdate DESC');
		$result = $q->execute();
		return $result;
    }
    # determine season harvest details
	function getAllHarvestDetails(){
    	$q = Doctrine_Query::create()->from('SeasonHarvest s')->where("s.seasonid = '".$this->getID()."'")->orderby('s.startdate DESC');
		$result = $q->execute();
		return $result;
    }
    # determine season sales details
	function getAllSalesDetails(){
    	$q = Doctrine_Query::create()->from('Sales s')->where("s.seasonid = '".$this->getID()."'")->orderby('s.startdate DESC');
		$result = $q->execute();
		return $result;
    } 
    # generate next season reference counter
    function getNextReferencePointer() {
    	$conn = Doctrine_Manager::connection();
    	$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
		$sql = "SELECT COUNT(id) FROM season WHERE userid = ".$userid." "; 
		$result = $conn->fetchOne($sql);
		return str_pad(($result+1), 3, "0", STR_PAD_LEFT);
    }
    # function sum all expenses on season
    function getTotalExpenses() {
    	$total = 0;
    	$inputline = $this->getSeasonInputs();
    	if($inputline->count() > 0){
	    	foreach ($inputline as $expense) {
	    		$total = $total + $expense->getTotalAmount();
	    	}
    	}
    	$tillagelines = $this->getAllTillageDetails();
    	if($tillagelines->count() > 0){
	    	foreach ($tillagelines as $expense) {
	    		$total = $total + $expense->getTotalExpenses();
	    	}
    	}
    	$plantlines = $this->getAllPlantingDetails();
    	if($plantlines->count() > 0){
	    	foreach ($plantlines as $expense) {
	    		$total = $total + $expense->getTotalExpenses();
	    	}
    	}
    	$treatlines = $this->getAllTreatingDetails();
    	if($treatlines->count() > 0){
	    	foreach ($treatlines as $treat){
	    		$total = $total + $treat->getTotalExpenses();
	    	}
    	}
    	$harvestlines = $this->getAllHarvestDetails();
    	if($harvestlines->count() > 0){
	    	foreach ($harvestlines as $harvest){
	    		$total = $total + $harvest->getTotalExpenses();
	    	}
    	}
    	$postharvestlines = $this->getAllOtherActivityDetails();
    	if($postharvestlines->count() > 0){
	    	foreach ($postharvestlines as $activity) {
	    		$total = $total + $activity->getTotalExpenses();
	    	}
    	}
    	$saleslines = $this->getAllSalesDetails();
    	if($saleslines->count() > 0){
    		foreach ($saleslines as $sale){
	    		$total = $total + $sale->getTotalExpenses();
	    	}
    	}
    	return $total;
    }
	# function sum all revenue from season
    function getTotalRevenue() {
    	$total = 0;
    	$saleslines = $this->getAllSalesDetails();
    	if($saleslines->count() > 0){
    		foreach ($saleslines as $sale){
	    		$total = $total + $sale->getTotalAmount();
	    	}
    	}
    	return $total;
    }
 	# function sum all expenses on season
    function getTotalSeasonInputs() {
    	$total = 0;
    	$inputline = $this->getSeasonInputs();
    	if($inputline->count() > 0){
	    	foreach ($inputline as $expense) {
	    		$total = $total + $expense->getTotalAmount();
	    	}
    	}
    	return $total;
    }
    # season expenses by category
    function getBundledExpenses2() {
    	$expense_data = array();
    	$i = 1;
    	$tillagelines = $this->getAllTillageDetails();
    	if($tillagelines->count() > 0){
	    	foreach ($tillagelines as $tillage) {
			    $expenselines = $tillage->getExpensesDetails();
				if($expenselines){
					foreach ($expenselines as $expense){
						if($expense->getAmount() > 0 && !isEmptyString($expense->getAmount())){
							$expense_data[$i]['id'] = $i;
							$expense_data[$i]['type'] = $expense->getType();
							$expense_data[$i]['name'] = $expense->getTypeText();
							$expense_data[$i]['amount'] = $expense->getAmount();
							$i++;
						}
					}
				}
	    		
	    	}
    	}
    	$plantlines = $this->getAllPlantingDetails();
    	if($plantlines->count() > 0){
	    	foreach ($plantlines as $plant) {
	    		$expenselines = $plant->getExpensesDetails();
				if($expenselines){
					foreach ($expenselines as $expense){
						if($expense->getAmount() > 0 && !isEmptyString($expense->getAmount())){
							$expense_data[$i]['id'] = $i;
							$expense_data[$i]['type'] = $expense->getType();
							$expense_data[$i]['name'] = $expense->getTypeText();
							$expense_data[$i]['amount'] = $expense->getAmount();
							$i++;
						}
					}
				}
	    	}
    	}
    	$treatlines = $this->getAllTreatingDetails();
    	if($treatlines->count() > 0){
	    	foreach ($treatlines as $treat){
	    		$expenselines = $treat->getExpensesDetails();
				if($expenselines){
					foreach ($expenselines as $expense){
						if($expense->getAmount() > 0 && !isEmptyString($expense->getAmount())){
							$expense_data[$i]['id'] = $i;
							$expense_data[$i]['type'] = $expense->getType();
							$expense_data[$i]['name'] = $expense->getTypeText();
							$expense_data[$i]['amount'] = $expense->getAmount();
							$i++;
						}
					}
				}
	    	}
    	}
    	$harvestlines = $this->getAllHarvestDetails();
    	if($harvestlines->count() > 0){
	    	foreach ($harvestlines as $harvest){
	    		$expenselines = $harvest->getExpensesDetails();
				if($expenselines){
					foreach ($expenselines as $expense){
						if($expense->getAmount() > 0 && !isEmptyString($expense->getAmount())){
							$expense_data[$i]['id'] = $i;
							$expense_data[$i]['type'] = $expense->getType();
							$expense_data[$i]['name'] = $expense->getTypeText();
							$expense_data[$i]['amount'] = $expense->getAmount();
							$i++;
						}
					}
				}
	    	}
    	}
    	$saleslines = $this->getAllSalesDetails();
    	if($saleslines->count() > 0){
    		foreach ($saleslines as $sale){
    			$expenselines = $sale->getExpensesDetails();
				if($expenselines){
					foreach ($expenselines as $expense){
						if($expense->getAmount() > 0 && !isEmptyString($expense->getAmount())){
							$expense_data[$i]['id'] = $i;
							$expense_data[$i]['type'] = $expense->getType();
							$expense_data[$i]['name'] = $expense->getTypeText();
							$expense_data[$i]['amount'] = $expense->getAmount();
							$i++;
						}
					}
				}
	    	}
    	}
    	$postharvestlines = $this->getAllOtherActivityDetails();
    	if($postharvestlines->count() > 0){
	    	foreach ($postharvestlines as $activity) {
			    $expenselines = $activity->getExpensesDetails();
				if($expenselines){
					foreach ($expenselines as $expense){
						if($expense->getAmount() > 0 && !isEmptyString($expense->getAmount())){
							$expense_data[$i]['id'] = $i;
							$expense_data[$i]['type'] = $expense->getType();
							$expense_data[$i]['name'] = $expense->getTypeText();
							$expense_data[$i]['amount'] = $expense->getAmount();
							$i++;
						}
					}
				}
	    		
	    	}
    	}
    	return $expense_data;
    }
    # season expenses by category
    function getBundledExpenses() {
    	$conn = Doctrine_Manager::connection();
    	
    	$expense_data = array();
    	$i = 1;
    	
    	$alltypes = getAllExpenseTypes();
    	foreach ($alltypes as $key => $type) {
    		// query to sum types 
    		$all_results_query = "
		    	SELECT
				sd.type as type,
				sum(sd.amount) as total
				FROM
				seasoninputdetail AS sd
				left join seasontillage as st on (sd.tillageid = st.id)
				left join season as sst on (st.seasonid = sst.id)
				left join seasonplanting as sp on (sd.plantingid = sp.id)
				left join season as ssp on (sp.seasonid = ssp.id)
				left join seasontracking as sg on (sd.trackingid = sg.id)
				left join season as ssg on (sg.seasonid = ssg.id)
				left join seasonharvest as sh on (sd.harvestid = sh.id)
				left join season as ssh on (sh.seasonid = ssh.id)
				left join sales as ss on (sd.saleid = ss.id)
				left join season as sss on (ss.seasonid = sss.id)
				where sd.type = '".$key."' AND (st.seasonid = '".$this->getID()."' OR sp.seasonid = '".$this->getID()."' OR sg.seasonid = '".$this->getID()."' OR sh.seasonid = '".$this->getID()."' OR ss.seasonid = '".$this->getID()."')
				group by sd.type
	    	";  
	    	// debugMessage($all_results_query); 
			$result = $conn->fetchRow($all_results_query);
			
			if($result['total'] > 0){
				// debugMessage($result);
				$expense_data[$i]['typeid'] = $result['type'];
				$expense_data[$i]['name'] = $type;
				$expense_data[$i]['amount'] = $result['total'];
				$i++;
			}
			
    	}
    	// debugMessage($expense_data);
    	
		return $expense_data;
    }
    #determine all activities part of this timeline
    function getTimeLineDetails($ismobile = false){
    	$data_array = array();
    	$inputlines = $this->getAllInputDetails();
    	$i = 1;
    	$baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
    	foreach ($inputlines as $input){
    		$key = strtotime($input->getStartDate());
    		$data_array[$i]['order'] = $key;
    		$data_array[$i]['id'] = $input->getID();
    		$data_array[$i]['date'] = changeMySQLDateToPageFormat($input->getStartDate());
    		$data_array[$i]['startdate'] = $input->getStartDate();
    		$data_array[$i]['enddate'] = $input->getEndDate();
    		$data_array[$i]['ref'] = $input->getRef();
    		$data_array[$i]['description'] = $input->getInputsSnippet();
    		$data_array[$i]['expenses'] = $input->getTotalAmount();
    		$data_array[$i]['status'] = 'Completed';
    		$data_array[$i]['type'] = 1;
    		$data_array[$i]['uniqueid'] = 'type'.$data_array[$i]['type'].'_'.$data_array[$i]['id'];
    		$data_array[$i]['title'] = "Season Inputs";
    		$data_array[$i]['activityname'] = !isEmptyString($input->getActivityName()) ? $input->getActivityName() : "Season Inputs";
    		$data_array[$i]['url'] = $baseUrl."/season/inputview/id/".encode($input->getID());
    		$data_array[$i]['editurl'] = $baseUrl."/season/input/id/".encode($input->getID());
    		if($ismobile){
    			$data_array[$i]['url'] = $baseUrl."/mobile/viewseasonevent/stage/input/id/".encode($input->getID());
    			$data_array[$i]['editurl'] = $baseUrl."/mobile/addseasonevent/stage/input/id/".encode($input->getID());
    		}
    		$data_array[$i]['subtype'] = 1;
    		if($input->getType() == 2){
    			$data_array[$i]['subtype'] = 2;
    			$data_array[$i]['title'] = "Season Expenses";
	    		$data_array[$i]['activityname'] = "Expenses";
    		}
    		
    		$i++;
    	}
    	$tillagelines = $this->getAllTillageDetails();
    	foreach ($tillagelines as $tillage){
    		$key = strtotime($tillage->getStartDate());
    		$data_array[$i]['order'] = $key;
    		$data_array[$i]['id'] = $tillage->getID();
    		$data_array[$i]['date'] = changeMySQLDateToPageFormat($tillage->getStartDate());
    		$data_array[$i]['startdate'] = $tillage->getStartDate();
    		$data_array[$i]['enddate'] = $tillage->getEndDate();
    		$data_array[$i]['ref'] = $tillage->getRef();
    		$data_array[$i]['description'] = $tillage->getMethodText()." - ".$tillage->getDepth()."&nbsp;<span class='pagedescription'>(".$tillage->getDepthUnitText().")</span>";
    		$data_array[$i]['expenses'] = $tillage->getActivityExpenseAmount();
    		$data_array[$i]['status'] = $tillage->getStatusText();
    		$data_array[$i]['type'] = 2;
    		$data_array[$i]['title'] = "Tillage";
    		$data_array[$i]['activityname'] = !isEmptyString($tillage->getActivityName()) ? $tillage->getActivityName() : "Tillage";
    		$data_array[$i]['url'] = $baseUrl."/season/tillageview/id/".encode($tillage->getID());
    		$data_array[$i]['editurl'] = $baseUrl."/season/tillage/id/".encode($tillage->getID());
    		if($ismobile){
    			$data_array[$i]['url'] = $baseUrl."/mobile/viewseasonevent/stage/tillage/id/".encode($tillage->getID());
    			$data_array[$i]['editurl'] = $baseUrl."/mobile/addseasonevent/stage/tillage/id/".encode($tillage->getID());
    		}
    		$data_array[$i]['uniqueid'] = 'type'.$data_array[$i]['type'].'_'.$data_array[$i]['id'];
    		$i++;
    	}
    	$plantlines = $this->getAllPlantingDetails();
    	foreach ($plantlines as $plant){
    		$key = strtotime($plant->getStartDate());
    		$data_array[$i]['order'] = $key;
    		$data_array[$i]['id'] = $plant->getID();
    		$data_array[$i]['date'] = changeMySQLDateToPageFormat($plant->getStartDate());
    		$data_array[$i]['startdate'] = $plant->getStartDate();
    		$data_array[$i]['enddate'] = $plant->getEndDate();
    		$data_array[$i]['ref'] = $plant->getRef();
    		$data_array[$i]['description'] = $plant->getMethodText()." - ".$plant->getCrop()->getName();
    		$data_array[$i]['expenses'] = $plant->getActivityExpenseAmount();
    		$data_array[$i]['type'] = 3;
    		$data_array[$i]['status'] = $plant->getStatusText();
    		$data_array[$i]['title'] = "Planting";
    		$data_array[$i]['activityname'] = !isEmptyString($plant->getActivityName()) ? $plant->getActivityName() : "Planting";
    		$data_array[$i]['url'] = $baseUrl."/season/plantview/id/".encode($plant->getID());
    		$data_array[$i]['editurl'] = $baseUrl."/season/plant/id/".encode($plant->getID());
    		if($ismobile){
    			$data_array[$i]['url'] = $baseUrl."/mobile/viewseasonevent/stage/plant/id/".encode($plant->getID());
    			$data_array[$i]['editurl'] = $baseUrl."/mobile/addseasonevent/stage/plant/id/".encode($plant->getID());
    		}
    		$data_array[$i]['uniqueid'] = 'type'.$data_array[$i]['type'].'_'.$data_array[$i]['id'];
    		$i++;
    	}
    	$treatlines = $this->getAllTreatingDetails();
    	foreach ($treatlines as $treat){
    		$key = strtotime($treat->getStartDate());
    		$data_array[$i]['order'] = $key;
    		$data_array[$i]['id'] = $treat->getID();
    		$data_array[$i]['date'] = changeMySQLDateToPageFormat($treat->getStartDate());
    		$data_array[$i]['startdate'] = $treat->getStartDate();
    		$data_array[$i]['enddate'] = $treat->getEndDate();
    		$data_array[$i]['ref'] = $treat->getRef();
    		$data_array[$i]['description'] = $treat->getTotalApplied()."&nbsp;<span class='pagedescription'>(".$treat->getTotalAppliedUnitText().")</span> of '".$treat->getItemName()."' applied.";
    		$data_array[$i]['expenses'] = $treat->getActivityExpenseAmount();
    		$data_array[$i]['type'] = 4;
    		$data_array[$i]['status'] = $treat->getStatusText();
    		$data_array[$i]['title'] = "Treatment";
    		$data_array[$i]['activityname'] = !isEmptyString($treat->getActivityName()) ? $treat->getActivityName() : "Treatment";
    		$data_array[$i]['url'] = $baseUrl."/season/treatview/id/".encode($treat->getID());
    		$data_array[$i]['editurl'] = $baseUrl."/season/treat/id/".encode($treat->getID());
    		if($ismobile){
    			$data_array[$i]['url'] = $baseUrl."/mobile/viewseasonevent/stage/treat/id/".encode($treat->getID());
    			$data_array[$i]['editurl'] = $baseUrl."/mobile/addseasonevent/stage/treat/id/".encode($treat->getID());
    		}
    		$data_array[$i]['uniqueid'] = 'type'.$data_array[$i]['type'].'_'.$data_array[$i]['id'];
    		$i++;
    	}
    	$harvestlines = $this->getAllHarvestDetails();
    	foreach ($harvestlines as $harvest){
    		$key = strtotime($harvest->getStartDate());
    		$data_array[$i]['order'] = $key;
    		$data_array[$i]['id'] = $harvest->getID();
    		$data_array[$i]['date'] = changeMySQLDateToPageFormat($harvest->getStartDate());
    		$data_array[$i]['startdate'] = $harvest->getStartDate();
    		$data_array[$i]['enddate'] = $harvest->getEndDate();
    		$data_array[$i]['ref'] = $harvest->getRef();
    		$data_array[$i]['description'] = $harvest->getTotalHarvest()."&nbsp;<span class='pagedescription'>(".$harvest->getTotalHarvestUnitText().")</span>"." of '".$harvest->getCrop()->getName()."' harvested.";
    		$data_array[$i]['expenses'] = $harvest->getActivityExpenseAmount();
    		$data_array[$i]['type'] = 6;
    		$data_array[$i]['status'] = $harvest->getStatusText();
    		$data_array[$i]['title'] = "Harvesting";
    		$data_array[$i]['activityname'] = !isEmptyString($harvest->getActivityName()) ? $harvest->getActivityName() : "Harvesting";
    		$data_array[$i]['url'] = $baseUrl."/season/harvestview/id/".encode($harvest->getID());
    		$data_array[$i]['editurl'] = $baseUrl."/season/harvest/id/".encode($harvest->getID());
    		if($ismobile){
    			$data_array[$i]['url'] = $baseUrl."/mobile/viewseasonevent/stage/harvest/id/".encode($harvest->getID());
    			$data_array[$i]['editurl'] = $baseUrl."/mobile/addseasonevent/stage/harvest/id/".encode($harvest->getID());
    		}
    		$data_array[$i]['uniqueid'] = 'type'.$data_array[$i]['type'].'_'.$data_array[$i]['id'];
    		$i++;
    	}
    	$saleslines = $this->getAllSalesDetails();
    	foreach ($saleslines as $sale){
    		$key = strtotime($sale->getStartDate());
    		$data_array[$i]['order'] = $key;
    		$data_array[$i]['id'] = $sale->getID();
    		$data_array[$i]['date'] = changeMySQLDateToPageFormat($sale->getStartDate());
    		$data_array[$i]['startdate'] = $sale->getStartDate();
    		$data_array[$i]['enddate'] = $sale->getEndDate();
    		$data_array[$i]['ref'] = $sale->getRef();
    		$data_array[$i]['description'] = $sale->getQuantity()."&nbsp;<span class='pagedescription'>(".$sale->getQuantityUnitText().")</span>"." of '".$sale->getCrop()->getName()."' sold ";
    		$data_array[$i]['expenses'] = $sale->getActivityExpenseAmount();
    		$data_array[$i]['sale'] = $sale->getActivityExpenseAmount();
    		$data_array[$i]['type'] = 7;
    		$data_array[$i]['status'] = $sale->getStatusText();
    		$data_array[$i]['title'] = "Season Sales";
    		$data_array[$i]['activityname'] = !isEmptyString($sale->getActivityName()) ? $sale->getActivityName() : "Season Sales";
    		$data_array[$i]['url'] = $baseUrl."/season/saleview/id/".encode($sale->getID());
    		$data_array[$i]['editurl'] = $baseUrl."/season/sale/id/".encode($sale->getID());
    		if($ismobile){
    			$data_array[$i]['url'] = $baseUrl."/mobile/viewseasonevent/stage/sale/id/".encode($sale->getID());
    			$data_array[$i]['editurl'] = $baseUrl."/mobile/addseasonevent/stage/sale/id/".encode($sale->getID());
    		}
    		$data_array[$i]['uniqueid'] = 'type'.$data_array[$i]['type'].'_'.$data_array[$i]['id'];
    		$i++;
    	}
    	// debugMessage($data_array);
    	return $data_array;
    }
	/**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	// exit();
    	return true;
    }
	/**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterUpdate(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	// exit();
    	return true;
    }
    # compute total cost for skilled labor
    function totalSkilledLabourCost() {
    	$total = 0;
    	$tillagelines = $this->getAllTillageDetails();
    	if($tillagelines->count() > 0){
	    	foreach ($tillagelines as $tillage) {
	    		$total += $tillage->getTotalLaborCost();
	    	}
    	}
    	$plantlines = $this->getAllPlantingDetails();
    	if($plantlines->count() > 0){
	    	foreach ($plantlines as $planting) {
	    		$total += $planting->getTotalLaborCost();
	    	}
    	}
    	$treatlines = $this->getAllTreatingDetails();
    	if($treatlines->count() > 0){
	    	foreach ($treatlines as $treat){
	    		$total += $treat->getTotalLaborCost();
	    	}
    	}
    	$harvestlines = $this->getAllHarvestDetails();
    	if($harvestlines->count() > 0){
	    	foreach ($harvestlines as $harvest){
	    		$total += $harvest->getTotalLaborCost();
	    	}
    	}
    	$saleslines = $this->getAllSalesDetails();
    	if($saleslines->count() > 0){
    		foreach ($saleslines as $sale){
	    		$total += $sale->getTotalLaborCost();
	    	}
    	}
    	return $total;
    }
    # determine total interest on loans
    function getTotalCreditInterest(){
    	$total = 0;
    	$loan = $this->getLoans()->get(0);
    	if($loan){
    		$total += ($loan->getPayBackAmount() - $loan->getPrincipal());
    	}
    	
    	$tillagelines = $this->getAllTillageDetails();
    	if($tillagelines->count() > 0){
	    	foreach ($tillagelines as $tillage) {
	    		$loan = $tillage->getCreditDetails();
			    if($loan){
		    		$total += ($loan->getPayBackAmount() - $loan->getPrincipal());
		    	}
	    	}
    	}
    	$plantlines = $this->getAllPlantingDetails();
    	if($plantlines->count() > 0){
	    	foreach ($plantlines as $planting) {
	    		$loan = $planting->getCreditDetails();
			    if($loan){
		    		$total += ($loan->getPayBackAmount() - $loan->getPrincipal());
		    	}
	    	}
    	}
    	$treatlines = $this->getAllTreatingDetails();
    	if($treatlines->count() > 0){
	    	foreach ($treatlines as $treat){
	    		$loan = $treat->getCreditDetails();
			    if($loan){
		    		$total += ($loan->getPayBackAmount() - $loan->getPrincipal());
		    	}
	    	}
    	}
    	$harvestlines = $this->getAllHarvestDetails();
    	if($harvestlines->count() > 0){
	    	foreach ($harvestlines as $harvest){
	    		$loan = $harvest->getCreditDetails();
			    if($loan){
		    		$total += ($loan->getPayBackAmount() - $loan->getPrincipal());
		    	}
	    	}
    	}
    	$saleslines = $this->getAllSalesDetails();
    	if($saleslines->count() > 0){
    		foreach ($saleslines as $sale){
    			$loan = $sale->getCreditDetails();
			    if($loan){
		    		$total += ($loan->getPayBackAmount() - $loan->getPrincipal());
		    	}
	    	}
    	}
    	
    	return $total;
    }
}

?>