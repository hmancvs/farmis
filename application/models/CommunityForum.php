<?php 

class CommunityForum extends BaseEntity {
	
	public function setTableDefinition(){
		parent::setTableDefinition();
		
		$this->setTableName('communityforum');
		$this->hasColumn('topic', 'string', 1000, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('content', 'string', 65535, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('category', 'tinyint');
	}
	/**
	 * Contructor method for custom functionality - add error messages and any fields to be marked as dates
	*/
	public function construct() {
		parent::construct();
		
		// set the custom error messages
       	$this->addCustomErrorMessages(array(
       									"topic.notblank" => $this->translate->_("communityforum_topic_error"),
       									"content.notblank" => $this->translate->_("communityforum_content_error")
       								)); 
	}
	
	function setUp() {
    	parent::setUp();
		$this->hasMany('Comment as comments',
					array('local' => 'id',
						  'foreign' => 'communityforumid'
						)
					);
    }
	/*
	 * Pre process model data 
	 */
	function processPost($formvalues){
		# force setting of default none string column values. enum, int and date 	
		if(isArrayKeyAnEmptyString('category', $formvalues)){
			unset($formvalues['category']); 
		}
		parent::processPost($formvalues);
	}
	/**
	 * 
	 * Return collection of the latest communityforum topics
	 */
	function getLatestPosts() {
		# query latest five communityforums
		$q = Doctrine_Query::create()
		->from("CommunityForum c")
		->orderby("c.datecreated DESC, c.id DESC")
		->limit(4);
		
		// debugMessage($q->fetchOne()->toArray());
		return $q->execute();
	}
	/**
	 * 
	 * Return comments sorted by date
	 */
	function getAllComments() {
		# query latest five communityforums
		$q = Doctrine_Query::create()
		->from("Comment c")
		->orderby("c.datecreated ASC, c.id ASC")
		->where("communityforumid = '".$this->getID()."'");
		
		// debugMessage($q->fetchOne()->toArray());
		return $q->execute();
	}
	/**
	 * Return actual lookup text from the current category 
	 */
	function getCategoryText() {
		$text = '';
		if(!isEmptyString($this->getCategory())){
			$categories = getForumCategories();
			$text = $categories[$this->getCategory()];
		}
		return $text;
	}
	# fetch the no of comments on a topic
	function countComments() {
		return $this->getComments()->count();
	}
}
?>