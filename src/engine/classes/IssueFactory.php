<?php

/**
* This class is for working with a pool of Issues
* It is a kind of container for a group of Issues
* Contains methods for Issue creation and exctaction
**/
class IssueFactory implements JsonSerializable {
	protected $IssuePool = array();
	
	function __construct() {
	
	}
	
	public function getCount() {
		return count($this->IssuePool);
	}
	
	public function addIssue(Issue $issue) {
		array_push($this->IssuePool, $issue);
	}
	
	public function getIssue($id) {
		if($id < $this->getCount()) {
			return $this->IssuePool[$id];
		}
		return false;
	}
	
	public function jsonSerialize() {
		return $this->IssuePool;
	}
}
