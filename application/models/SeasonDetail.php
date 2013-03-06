<?php
/**
 * Model for season detail
 *
 */
class SeasonDetail extends BaseRecord {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		$this->setTableName('seasondetail');
		$this->hasColumn('seasonid', 'integer', null, array('notnull' => true, 'notblank' => true));	
		$this->hasColumn('farmid', 'integer', null, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('cropid', 'integer', null, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('type', 'integer', null, array('notnull' => true, 'notblank' => true, 'default' => 0));
		$this->hasColumn('value1', 'integer', null);
		$this->hasColumn('value2', 'integer', null);
	}
	
	public function construct() {
		parent::construct();
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"seasonid.notblank" => $this->translate->_("season_detail_seasonid_error"),
       									"farmid.notblank" => $this->translate->_("season_detail_farmid_error"),
       									"cropid.notblank" => $this->translate->_("season_detail_commodityid_error"),
       									"type.notblank" => $this->translate->_("season_detail_type_error")
       	       						));
	}
	
	public function setUp() {
		parent::setUp(); 
		$this->hasOne('Season as season',
							array('local' => 'seasonid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('Farm as farm',
							array('local' => 'farmid',
									'foreign' => 'id'
							)
						);
		$this->hasOne('Commodity as crop',
							array('local' => 'cropid',
									'foreign' => 'id'
							)
						);
		$this->hasMany('SeasonPlanting as seasonplants',
					 		array(
								'local' => 'seasonid',
								'foreign' => 'seasonid'
							)
						);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('value1', $formvalues)){
			$formvalues['value1'] = NULL;
		}
		if(isArrayKeyAnEmptyString('value2', $formvalues)){
			$formvalues['value2'] = NULL;
		}
		parent::processPost($formvalues);
	}
}

?>