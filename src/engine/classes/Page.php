<?php

/**
* This class is for working with a Page
* Contains setters and getters for each property of a Page
* Containg all methods for interaction with the page
**/
class Page implements JsonSerializable {
	protected $id;
	protected $route;
	protected $params;
	protected $name;
	
	function __construct() {}
	
	/**
	* Block of setters
	**/
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setRoute($route) {
		$this->route = $route;
	}
	
	public function setParams($params) {
		$this->params = $params;
	}
	
	/**
	* Block of getters
	**/
	public function getId() {
		return $this->id;
	}
		
	public function getRoute() {
		return $this->route;
	}
	
	public function getParams() {
		return $this->params;
	}
	
	public function getName() {
		return $this->name;
	}
	
	
	/**
	* Methods
	**/
	public function jsonSerialize() {
        return array(
			'id' => $this->id, 
			'route' => $this->route, 
			'params' => $this->params, 
			'name' => $this->name,
		);
    }
}
