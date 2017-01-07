<?php

/**
* This class is for working with a Page
* Contains setters and getters for each property of a Page
* Containg all methods for interaction with the page
**/
class Module implements JsonSerializable {
	protected $id;
	protected $moduleId;
	protected $pageId;
	protected $name;
	protected $position;
	protected $file;
	protected $params;
	protected $styles;
	protected $scripts;
	
	function __construct($id, $mId, $pId, $name, Position $pos, $file, $params, $styles, $scripts) {
		$this->id = $id;
		$this->moduleId = $mId;
		$this->pageId = $pId;
		$this->name = $name;
		$this->position = $pos;
		$this->file = $file;
		$this->params = $params;
		$this->styles = $styles;
		$this->scripts = $scripts;
	}
	
	/**
	* Block of setters
	**/
	public function setModuleId($id) {
		$this->moduleId = $id;
	}
	
	public function setPageId($id) {
		$this->pageId = $id;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function setPosition(Position $pos) {
		$this->position = $pos;
	}
	
	public function setFile($file) {
		$this->file = $file;
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
		
	public function getModuleId() {
		return $this->moduleId;
	}
		
	public function getPageId() {
		return $this->pageId;
	}
	
	public function getParams() {
		return $this->params;
	}
	
	public function getPosition() {
		return $this->position;
	}
	
	public function getParamsJson() {
		return json_encode($this->params);
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getTemplate() {
		return $this->file;
	}
	
	public function getStyles() {
		return $this->styles;
	}
	
	public function getScripts() {
		return $this->scripts;
	}
	
	
	/**
	* Methods
	**/
	public function addParam($name, $value) {
		$this->params = $this->params + array($name => $value);
	}
	public function jsonSerialize() {
        return array(
			'id' => $this->id, 
			'route' => $this->route, 
			'params' => $this->params, 
			'name' => $this->name,
		);
    }
}
