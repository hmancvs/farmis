<?php

/**
 * Model for season input
 *
 */

class SeasonInput extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('seasoninput');
		$this->hasColumn('seasonid', 'integer', null);	
		$this->hasColumn('userid', 'integer', null, array('notblank' => true));
		$this->hasColumn('type', 'integer', null, array('default' => 1)); // 1 Season, 2 Non Season/Other sales
		$this->hasColumn('ref', 'string', 50);
		$this->hasColumn('activityname', 'string', 255);
		$this->hasColumn('activitydescription','string', 1000);
		$this->hasColumn('startdate','date', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('enddate','date', null);
		$this->hasColumn('totalamount', 'decimal', 11, array('default' => '0'));
		$this->hasColumn('financetype', 'integer', null, array('default' => '1'));
		$this->hasColumn('status', 'integer', null, array('default' => 3));
		$this->hasColumn('contract', 'string', 1000); 
		$this->hasColumn('notes','string', 1000);
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		$this->addDateFields(array("startdate"));
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"userid.notblank" => $this->translate->_("season_userid_error"),
       									"startdate.notblank" => $this->translate->_("season_activitydate_error"),
       	       						));
	}
	public function setUp() {
		parent::setUp();
		
		$this->hasOne('Season as season',
							array('local' => 'seasonid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('UserAccount as user', 
							array(
								'local' => 'userid',
								'foreign' => 'id'
							)
						);
		$this->hasMany('SeasonInputDetail as inputdetails',
					 		array(
								'local' => 'id',
								'foreign' => 'inputid'
							)
						);
		$this->hasMany('Loan as activitycredit',
					 		array(
								'local' => 'id',
								'foreign' => 'inputid'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		# trim spaces from the name field
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		} else {
			$type = $formvalues['type'];
			if($type == 2){
				$stage = '';
				$activityid = '';
				if(!isArrayKeyAnEmptyString('activityid', $formvalues)){
					$datarray = explode(',', $formvalues['activityid']);
					if(is_array($datarray)){
						$stage = $datarray[0];
						$activityid = $datarray[1];
					}
				}
			}
		}
		if(isArrayKeyAnEmptyString('status', $formvalues)){
			unset($formvalues['status']); 
		}
		if(isArrayKeyAnEmptyString('enddate', $formvalues)){
			unset($formvalues['enddate']); 
		}
		if(isArrayKeyAnEmptyString('seasonid', $formvalues)){
			unset($formvalues['seasonid']); 
		}
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']); 
		}
		# process season input details
		$detailsarray = array();
		$total = 0;
		if(!isArrayKeyAnEmptyString('inputdetails', $formvalues)){
			foreach ($formvalues['inputdetails'] as $key => $value){
				if(isEmptyString($value['name'])){
					unset($value[$key]);
				} else {
					$detailsarray[$key] = $value;
					if(!isArrayKeyAnEmptyString('id', $value)){
						$detailsarray[$key]['id'] = $value['id'];
					}
					if(!isArrayKeyAnEmptyString('inputdetails_type_'.$key, $formvalues)){
						$detailsarray[$key]['type'] = $formvalues['inputdetails_type_'.$key];
					}
					if(!isEmptyString($stage) && !isEmptyString($activityid)){
						switch ($stage){
							case 2:
								$detailsarray[$key]['tillageid'] = $activityid;
								$detailsarray[$key]['plantingid'] = NULL;
								$detailsarray[$key]['trackingid'] = NULL;
								$detailsarray[$key]['harvestid'] = NULL;
								$detailsarray[$key]['saleid'] = NULL;
								break;
							case 3:
								$detailsarray[$key]['plantingid'] = $activityid;
								$detailsarray[$key]['tillageid'] = NULL;
								$detailsarray[$key]['trackingid'] = NULL;
								$detailsarray[$key]['harvestid'] = NULL;
								$detailsarray[$key]['saleid'] = NULL;
								break;
							case 4:
								$detailsarray[$key]['trackingid'] = $activityid;
								$detailsarray[$key]['tillageid'] = NULL;
								$detailsarray[$key]['plantingid'] = NULL;
								$detailsarray[$key]['harvestid'] = NULL;
								$detailsarray[$key]['saleid'] = NULL;
								break;
							case 6:
								$detailsarray[$key]['harvestid'] = $activityid;
								$detailsarray[$key]['tillageid'] = NULL;
								$detailsarray[$key]['plantingid'] = NULL;
								$detailsarray[$key]['trackingid'] = NULL;
								$detailsarray[$key]['saleid'] = NULL;
								break;
							case 7:
								$detailsarray[$key]['saleid'] = $activityid;
								$detailsarray[$key]['tillageid'] = NULL;
								$detailsarray[$key]['plantingid'] = NULL;
								$detailsarray[$key]['trackingid'] = NULL;
								$detailsarray[$key]['harvestid'] = NULL;
								break;
							default:
								break;
						}
					}
					$total += $value['amount'];
				}
			}
		}
		$formvalues['totalamount'] = $total;
		if(count($detailsarray) > 0){
			$formvalues['inputdetails'] = $detailsarray;
		} else {
			unset($formvalues['inputdetails']);
		}
		
		if(!isArrayKeyAnEmptyString('financetype', $formvalues)){
			if($formvalues['financetype'] == 3 || $formvalues['financetype'] == 4 || $formvalues['financetype'] == 5){
				$formvalues['activitycredit'][0]['financetype'] = $formvalues['financetype'];
				$formvalues['activitycredit'][0]['userid'] = $formvalues['userid'];
				$formvalues['activitycredit'][0]['stage'] = $formvalues['stage'];
				$formvalues['activitycredit'][0]['type'] = $formvalues['type'];
				isArrayKeyAnEmptyString('principal', $formvalues) ? $formvalues['activitycredit'][0]['principal'] = NULL : $formvalues['activitycredit'][0]['principal'] = $formvalues['principal'];
				isArrayKeyAnEmptyString('interestrate', $formvalues) ? $formvalues['activitycredit'][0]['interestrate'] = NULL : $formvalues['activitycredit'][0]['interestrate'] = $formvalues['interestrate'];
				isArrayKeyAnEmptyString('paybackamount', $formvalues) ? $formvalues['activitycredit'][0]['paybackamount'] = NULL : $formvalues['activitycredit'][0]['paybackamount'] = $formvalues['paybackamount'];
				isArrayKeyAnEmptyString('installment', $formvalues) ? $formvalues['activitycredit'][0]['installment'] = NULL : $formvalues['activitycredit'][0]['installment'] = $formvalues['installment'];
				isArrayKeyAnEmptyString('installmentunit', $formvalues) ? $formvalues['activitycredit'][0]['installmentunit'] = NULL : $formvalues['activitycredit'][0]['installmentunit'] = $formvalues['installmentunit'];
				isArrayKeyAnEmptyString('paybackperiod', $formvalues) ? $formvalues['activitycredit'][0]['paybackperiod'] = NULL : $formvalues['activitycredit'][0]['paybackperiod'] = $formvalues['paybackperiod'];
				isArrayKeyAnEmptyString('paybackperiodunit', $formvalues) ? $formvalues['activitycredit'][0]['paybackperiodunit'] = NULL : $formvalues['activitycredit'][0]['paybackperiodunit'] = $formvalues['paybackperiodunit'];
				isArrayKeyAnEmptyString('creditdate', $formvalues) ? $formvalues['activitycredit'][0]['creditdate'] = NULL : $formvalues['activitycredit'][0]['creditdate'] = changeDateFromPageToMySQLFormat($formvalues['creditdate']);
				isArrayKeyAnEmptyString('financesourceid', $formvalues) ? $formvalues['activitycredit'][0]['financesourceid'] = NULL : $formvalues['activitycredit'][0]['financesourceid'] = $formvalues['financesourceid'];
				isArrayKeyAnEmptyString('financesourcetext', $formvalues) ? $formvalues['activitycredit'][0]['financesourcetext'] = NULL : $formvalues['activitycredit'][0]['financesourcetext'] = $formvalues['financesourcetext'];
				isArrayKeyAnEmptyString('clientid', $formvalues) ? $formvalues['activitycredit'][0]['clientid'] = NULL : $formvalues['activitycredit'][0]['clientid'] = $formvalues['clientid'];
				isArrayKeyAnEmptyString('quantity', $formvalues) ? $formvalues['activitycredit'][0]['quantity'] = NULL : $formvalues['activitycredit'][0]['quantity'] = $formvalues['quantity'];
				isArrayKeyAnEmptyString('quantityunit', $formvalues) ? $formvalues['activitycredit'][0]['quantityunit'] = NULL : $formvalues['activitycredit'][0]['quantityunit'] = $formvalues['quantityunit'];
				isArrayKeyAnEmptyString('price', $formvalues) ? $formvalues['activitycredit'][0]['price'] = NULL : $formvalues['activitycredit'][0]['price'] = $formvalues['price'];
				isArrayKeyAnEmptyString('clienttype', $formvalues) ? $formvalues['activitycredit'][0]['clienttype'] = NULL : $formvalues['activitycredit'][0]['clienttype'] = $formvalues['clienttype'];
				isArrayKeyAnEmptyString('sourcetype', $formvalues) ? $formvalues['activitycredit'][0]['sourcetype'] = NULL : $formvalues['activitycredit'][0]['sourcetype'] = $formvalues['sourcetype'];
				isArrayKeyAnEmptyString('contract', $formvalues) ? $formvalues['activitycredit'][0]['contract'] = NULL : $formvalues['activitycredit'][0]['contract'] = $formvalues['contract'];
			} else {
				$formvalues['activitycredit'] = array();
			}
		}
		debugMessage($formvalues); // exit();
		parent::processPost($formvalues);
	}
	/**
     * Overide  to save persons relationships
     *	@return true if saved, false otherwise
     */
    function afterSave(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
    	$loan = $this->getCreditDetails();
    	if(!isEmptyString($loan->getID())){
    		$loan->setInputID($this->getID());
    		$loan->save();
    	}
    	// exit();
    	return true;
    }
	function afterUpdate(){
    	$session = SessionWrapper::getInstance();
    	$conn = Doctrine_Manager::connection();
    	$update = false;
    	
		$loan = $this->getCreditDetails();
    	if(!isEmptyString($loan->getID())){
    		$loan->setInputID($this->getID());
    		$loan->save();
    	}
    	// exit();
    	return true;
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
	# generate next activity reference counter
    function getNextReferencePointer() {
    	$conn = Doctrine_Manager::connection();
    	$session = SessionWrapper::getInstance();
    	$userid = $session->getVar('userid');
		$sql = "SELECT COUNT(id) FROM seasoninput WHERE seasonid = ".$this->getSeasonID()." "; 
		$result = $conn->fetchOne($sql);
		return str_pad(($result+1), 3, "0", STR_PAD_LEFT);
    }
	# get snippet of inputs
    function getInputsSnippet(){
    	$inputlines = $this->getInputDetails();
   		$names_array = array(); 
        foreach($inputlines as $input) {
            $names_array[] = $input->getName(); 
        }
        return snippet(implode(", ", $names_array), 300, '...');
    }
	# determine all notes for entry
	function getNotesDetails() {
    	$q = Doctrine_Query::create()->from('Notes n')->where("n.inputid = '".$this->getID()."'")->orderby('n.datenoted DESC');
		$result = $q->execute();
		return $result;
	}
	# determine credit history for activity
	function getCreditDetails() {
    	$q = Doctrine_Query::create()->from('Loan l')->where("l.inputid = '".$this->getID()."'");
		$result = $q->execute();
		return $result->get(0);
	}
	function hasPreselectActivity(){
		$name = $this->getExpenseActivityName();
		return isEmptyString($name) ? false : true;
	}
	function getExpenseActivityName(){
		$name= '';
		$details = $this->getInputDetails()->get(0);
		if(!isEmptyString($details->getTillageID())){
			$name = $details->getTillage()->getActivityName().' - '.$details->getTillage()->getRef();
		}
		if(!isEmptyString($details->getPlantingID())){
			$name = $details->getPlanting()->getActivityName().' - '.$details->getPlanting()->getRef();
		}
		if(!isEmptyString($details->getTrackingID())){
			$name = $details->gettreatment()->getActivityName().' - '.$details->gettreatment()->getRef();
		}
		if(!isEmptyString($details->getHarvestID())){
			$name = $details->getHarvest()->getActivityName().' - '.$details->getHarvest()->getRef();
		}
		if(!isEmptyString($details->getSaleID())){
			$name = $details->getSale()->getActivityName().' - '.$details->getSale()->getRef();
		}
		return $name;
	}
	function getExpenseActivityID() {
		$id= '';
		$details = $this->getInputDetails()->get(0);
		if(!isEmptyString($details->getTillageID())){
			$id = $details->getTillageID();
		}
		if(!isEmptyString($details->getPlantingID())){
			$id = $details->getPlantingID();
		}
		if(!isEmptyString($details->getTrackingID())){
			$id = $details->getTrackingID();
		}
		if(!isEmptyString($details->getHarvestID())){
			$id = $details->getHarvestID();
		}
		if(!isEmptyString($details->getSaleID())){
			$id = $details->getSaleID();
		}
		return $id;
	}
	function getExpenseActivityStage() {
		$stage = '';
		$details = $this->getInputDetails()->get(0);
		if(!isEmptyString($details->getTillageID())){
			$stage = 'tillage';
		}
		if(!isEmptyString($details->getPlantingID())){
			$stage = 'plant';
		}
		if(!isEmptyString($details->getTrackingID())){
			$stage = 'treat';
		}
		if(!isEmptyString($details->getHarvestID())){
			$stage = 'harvest';
		}
		if(!isEmptyString($details->getSaleID())){
			$stage = 'sale';
		}
		return $stage;
	}
	function getExpenseActivityType() {
		$stage = '';
		$details = $this->getInputDetails()->get(0);
		if(!isEmptyString($details->getTillageID())){
			$stage = '2';
		}
		if(!isEmptyString($details->getPlantingID())){
			$stage = '3';
		}
		if(!isEmptyString($details->getTrackingID())){
			$stage = '4';
		}
		if(!isEmptyString($details->getHarvestID())){
			$stage = '6';
		}
		if(!isEmptyString($details->getSaleID())){
			$stage = '7';
		}
		return $stage;
	}
}

?>