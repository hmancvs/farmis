<?php

/**
 * Model for labor
 *
 */

class SeasonLabour extends BaseEntity  {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		// set the table
		$this->setTableName('seasonlabour');
		$this->hasColumn('farmerid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('farmid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		$this->hasColumn('seasonid', 'integer', null, array( 'notnull' => true, 'notblank' => true));
		
		$this->hasColumn('inputid', 'integer', null);
		$this->hasColumn('tillageid', 'integer', null);	
		$this->hasColumn('plantingid', 'integer', null);
		$this->hasColumn('trackingid', 'integer', null);
		$this->hasColumn('activityid', 'integer', null);
		$this->hasColumn('harvestid', 'integer', null);	
		$this->hasColumn('saleid', 'integer', null);
		
		$this->hasColumn('type', 'integer', null, array('default' => 1,'notnull' => true, 'notblank' => true)); // 1 Season, 2 Non Season/Other sales
		$this->hasColumn('activityname', 'string', 255, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('mcount', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('mhoursperday', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('mtotaldays', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('wcount', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('whoursperday', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('wtotaldays', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('kcount', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('khoursperday', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('ktotaldays', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('quantity', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('quantityunit', 'integer', null);
		$this->hasColumn('fieldsize', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('fieldsizeunit', 'integer', null);
		$this->hasColumn('fieldcost', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('itempaid',  'string', 50);
		$this->hasColumn('itemqty', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('unitprice', 'decimal', 10, array('default' => NULL));
		$this->hasColumn('amount', 'decimal', 10, array('default' => NULL));
	}
	
	/**
	 * Contructor method for custom functionality - add the fields to be marked as dates
	 */
	public function construct() {
		parent::construct();
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"farmerid.notblank" => $this->translate->_("season_farmerid_error"),
       									"farmid.notblank" => $this->translate->_("season_farmid_error"),
       									"seasonid.notblank" => $this->translate->_("season_seasonid_error"),
										"activityname.notblank" => $this->translate->_("season_activityname_error")
       	));
	}
	public function setUp() {
		parent::setUp();
		
		$this->hasOne('Farm as farm',
							array('local' => 'farmid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('Farmer as farmer', 
							array(
								'local' => 'farmerid',
								'foreign' => 'id'
							)
						);
		$this->hasOne('Season as season',
							array('local' => 'seasonid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonInput as input',
							array('local' => 'inputid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonTillage as tillage',
							array('local' => 'tillageid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonPlanting as planting',
							array('local' => 'plantingid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonTracking as treatment',
							array('local' => 'trackingid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonActivity as activity',
							array('local' => 'activityid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('SeasonHarvest as harvest',
							array('local' => 'harvestid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('Sales as sale',
							array('local' => 'saleid',
									'foreign' => 'id'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		}
		if(isArrayKeyAnEmptyString('farmerid', $formvalues)){
			unset($formvalues['farmerid']); 
		}
		if(isArrayKeyAnEmptyString('farmid', $formvalues)){
			unset($formvalues['farmid']); 
		}
		if(isArrayKeyAnEmptyString('seasonid', $formvalues)){
			unset($formvalues['seasonid']); 
		}
		if(isArrayKeyAnEmptyString('inputid', $formvalues)){
			$formvalues['inputid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('tillageid', $formvalues)){
			$formvalues['tillageid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('plantingid', $formvalues)){
			$formvalues['plantingid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('trackingid', $formvalues)){
			$formvalues['trackingid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('activityid', $formvalues)){
			$formvalues['activityid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('harvestid', $formvalues)){
			$formvalues['harvestid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('saleid', $formvalues)){
			$formvalues['saleid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('mcount', $formvalues)){
			$formvalues['mcount'] = NULL;
		}
		if(isArrayKeyAnEmptyString('mhoursperday', $formvalues)){
			$formvalues['mhoursperday'] = NULL;
		}
		if(isArrayKeyAnEmptyString('mtotaldays', $formvalues)){
			$formvalues['mtotaldays'] = NULL;
		}
		if(isArrayKeyAnEmptyString('wcount', $formvalues)){
			$formvalues['wcount'] = NULL;
		}
		if(isArrayKeyAnEmptyString('whoursperday', $formvalues)){
			$formvalues['whoursperday'] = NULL;
		}
		if(isArrayKeyAnEmptyString('wtotaldays', $formvalues)){
			$formvalues['wtotaldays'] = NULL;
		}
		if(isArrayKeyAnEmptyString('kcount', $formvalues)){
			$formvalues['kcount'] = NULL;
		}
		if(isArrayKeyAnEmptyString('khoursperday', $formvalues)){
			$formvalues['khoursperday'] = NULL;
		}
		if(isArrayKeyAnEmptyString('ktotaldays', $formvalues)){
			$formvalues['ktotaldays'] = NULL;
		}
		if(isArrayKeyAnEmptyString('quantity', $formvalues)){
			$formvalues['quantity'] = NULL;
		}
		if(isArrayKeyAnEmptyString('quantityunit', $formvalues)){
			$formvalues['quantityunit'] = NULL;
		}
		if(isArrayKeyAnEmptyString('fieldsize', $formvalues)){
			$formvalues['fieldsize'] = NULL;
		}
		if(isArrayKeyAnEmptyString('fieldsizeunit', $formvalues)){
			$formvalues['fieldsizeunit'] = NULL;
		}
		if(isArrayKeyAnEmptyString('fieldcost', $formvalues)){
			$formvalues['fieldcost'] = NULL;
		}
		if(isArrayKeyAnEmptyString('itempaid', $formvalues)){
			$formvalues['itempaid'] = NULL;
		}
		if(isArrayKeyAnEmptyString('itemqty', $formvalues)){
			$formvalues['itemqty'] = NULL;
		}
		if(isArrayKeyAnEmptyString('unitprice', $formvalues)){
			$formvalues['unitprice'] = NULL;
		}
		if(isArrayKeyAnEmptyString('amount', $formvalues)){
			$formvalues['amount'] = NULL;
		}
		// debugMessage($formvalues); // exit();
		parent::processPost($formvalues);
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
}
?>