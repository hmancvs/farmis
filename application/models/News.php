<?php

class News extends BaseRecord {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('news');
		$this->hasColumn('headline', 'string', 500);
		$this->hasColumn('datepublished', 'integer', null);
		$this->hasColumn('summary', 'string', 5000);
		$this->hasColumn('newsdetail', 'string', 65535);
		$this->hasColumn('newsimage', 'string', 500);
		$this->hasColumn('newslink', 'string', 255);
		$this->hasColumn('keywords', 'string', 1000);
		$this->hasColumn('publish', 'integer', null);
		$this->hasColumn('author', 'string', 255);
		$this->hasColumn('source', 'string', 50);
		$this->hasColumn('country', 'string', 2, array('default' => 'UG'));
		$this->hasColumn('featured', 'integer', null);
		$this->hasColumn('datecreated','date');
	}
	/**
	 * Contructor method for custom initialization
	 */
	public function construct() {
		
		parent::construct();
		
	}
	/**
	 * Model relationships
	 */
	public function setUp() {
		parent::setUp(); 
		
	}
	/**
	 * Preprocess model data
	 */
	function processPost($formvalues){
		// set default values for integers, dates, decimals
		if(isArrayKeyAnEmptyString('datepublished', $formvalues)){
			unset($formvalues['datepublished']); 
		}
		if(isArrayKeyAnEmptyString('datecreated', $formvalues)){
			unset($formvalues['datecreated']); 
		}
		if(isArrayKeyAnEmptyString('featured', $formvalues)){
			unset($formvalues['featured']); 
		}
		if(isArrayKeyAnEmptyString('publish', $formvalues)){
			unset($formvalues['publish']); 
		}
		parent::processPost($formvalues);
	}
	# all kings
	function getFeaturedNewsItem(){
		$q = Doctrine_Query::create()->from('News n')->where("n.featured = 1 AND n.publish = 1");
		$result = $q->fetchOne();
		return $result;
	}
	function getNewsArchive(){
		$q = Doctrine_Query::create()->from('News n')->where("n.featured <> 1 AND n.publish = 1 ")->limit(5)->orderby('n.datepublished DESC');
		$result = $q->execute();
		return $result;
	}
}
?>