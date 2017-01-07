<?php

/**
* This class is for working with a Position
* Contains setters and getters for each property of a Position
**/
class Position implements JsonSerializable {
	protected $id;
	protected $name;
	protected $position;
	protected $block;
	protected $maxItems;
	
	function __construct($id, $name, $position, $block, $maxItems) {
		$this->id = $id;
		$this->name = $name;
		$this->position = $position;
		$this->block = $block;
		$this->maxItems = $maxItems;
	}
	
	/**
	* Block of setters
	**/	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function setPosition($position) {
		$this->position = $position;
	}
	
	public function setBlock($block) {
		$this->block = $block;
	}
	
	/**
	* Block of getters
	**/
	public function getId() {
		return $this->id;
	}
		
	public function getName() {
		return $this->name;
	}
	
	public function getPosition() {
		return $this->position;
	}
	
	public function getMaxItems() {
		return $this->maxItems;
	}
	
	public function getBlock() {
		return $this->block;
	}
	
	/**
	* Methods
	**/
	public function jsonSerialize() {
        return array(
			'id' => $this->id,
			'name' => $this->name,
			'position' => $this->position,
			'block' => $this->block,
			'maxItems' => $this->maxItems,
		);
    }
}
