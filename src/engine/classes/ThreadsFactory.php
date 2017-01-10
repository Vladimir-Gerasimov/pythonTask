<?php

/**
* This class is for working with a pool of Threads
* It is a kind of container for a group of Threads
* Contains methods for Threads creation and exctaction
**/
class ThreadsFactory implements JsonSerializable {
	protected $ThreadsPool = array();
	
	function __construct() {
	
	}
	
	public function getCount() {
		return count($this->ThreadsPool);
	}
	
	public function getIds() {
		$ids = array();
		foreach($this->ThreadsPool as $Thread) {
			array_push($ids, $Thread->getId());
		}
		return $ids;
	}
	
	public function addThread(Thread $thread) {
		array_push($this->ThreadsPool, $thread);
	}
	
	public function getThread($id) {
		if($id < $this->getCount()) {
			return $this->ThreadsPool[$id];
		}
	}
	
	public function jsonSerialize() {
		return $this->ThreadsPool;
	}
}
