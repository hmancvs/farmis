<?php

class TellFriend extends BaseRecord {
	
	public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		
		$this->setTableName('tellfriend');
		$this->hasColumn('fromname', 'string', 255);
		$this->hasColumn('fromemail', 'string', 255);
		$this->hasColumn('emails', 'string', 1000);
		$this->hasColumn('message', 'string', 1000);
	}
}
?>