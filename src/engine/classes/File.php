<?php

/**
* This class represents a File uploaded by user or admin
* All methods for interaction with a single file 
* We allow Image or Video mime type
**/
class File implements JsonSerializable {
	protected $id;
	protected $user_id;
	protected $type;
	protected $name;
	
	function __construct() {
	
	}
	
	/**
	* Block of setters
	**/
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setUserId($uid) {
		$this->user_id = $uid;
	}
	
	public function setType($type) {
		$this->type = $type;
	}
	
	public function setName($name) {
		$this->name = $name;
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
	
	public function getUserId() {
		return $this->user_id;
	}
	
	public function getType() {
		return $this->type;
	}
	
	/**
	* Methods
	**/
	public function jsonSerialize() {
        return array(
			'id' => $this->id, 
			'user_id' => $this->user_id, 
			'type' => $this->type, 
			'name' => $this->name,
		);
    }
}
