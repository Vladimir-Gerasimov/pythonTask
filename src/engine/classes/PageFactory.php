<?php

/**
* This class is for working with a pool of Page
* It is a kind of container for a group of Pages
* Contains methods for Pages creation and exctaction
**/
class PageFactory implements JsonSerializable, Iterator {
	protected $PagesPool = array();
	private $position = 0;
	
	function __construct() {
		$this->position = 0;
	}
	
	public function getCount() {
		return count($this->PagesPool);
	}
	
	public function getIds() {
		$ids = array();
		foreach($this->PagesPool as $Page) {
			array_push($ids, $Page->getId());
		}
		return $ids;
	}
	
	public function addPage(Page $page) {
		array_push($this->PagesPool, $page);
	}
	
	public function getPage($id) {
		if($id < $this->getCount()) {
			return $this->PagesPool[$id];
		}
	}
	
	/**
	* Inherited from JsonSerializable
	**/
	public function jsonSerialize() {
		return $this->PagesPool;
	}
	
	/**
	* Inherited from Iterator
	**/
	function rewind() {
		$this->position = 0;
	}

	function current() {
		return $this->PagesPool[$this->position];
	}

	function key() {
		return $this->position;
	}

	function next() {
		++$this->position;
	}

	function valid() {
		return isset($this->PagesPool[$this->position]);
	}
}
