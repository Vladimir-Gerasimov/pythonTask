<?php

/**
* This class is for working with a Poll
* Contains setters and getters for each property of a Poll
* Containg all methods for interaction with the poll
**/
class Poll implements JsonSerializable {
	protected $id;
	protected $creator;
	protected $items = array();
	
	function __construct() {
	
	}
	
	/**
	* Block of setters
	**/
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setCreator($creator) {
		$this->creator = $creator;
	}
	
	/**
	* Block of getters
	**/
	public function getId() {
		return $this->id;
	}
		
	public function getCreator() {
		return $this->creator;
	}
	
	public function getItems() {
		return $this->items;
	}
	
	
	/**
	* Methods
	**/
	public function jsonSerialize() {
        return array(
			'id' => $this->id, 
			'creator' => $this->creator, 
			'items' => $this->items, 
		);
    }
	
	public function addItem($item, $votes) {
		array_push($this->items, array('item' => $item, 'votes' => $votes));
	}

}
