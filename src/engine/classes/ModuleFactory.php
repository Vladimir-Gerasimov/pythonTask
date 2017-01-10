<?php

/**
* This class is for working with a pool of Modules
* It is a kind of container for a group of Modules
* Contains methods for Modules creation and exctaction
**/
class ModuleFactory implements JsonSerializable, Iterator {
	protected $ModulesPool = array();
	private $position = 0;
	
	function __construct() {
		$this->position = 0;
	}
	
	public function getCount() {
		return count($this->PagesPool);
	}
	
	public function getIds() {
		$ids = array();
		foreach($this->ModulesPool as $Module) {
			array_push($ids, $Module->getId());
		}
		return $ids;
	}
	
	public function getStyles() {
		$styles = array();
		foreach($this->ModulesPool as $mod) {
			foreach($mod->getStyles() as $style) {
				array_push($styles, $style);
			}
		}
		return array_unique($styles);
	}
	
	public function getScripts() {
		$scripts = array();
		foreach($this->ModulesPool as $mod) {
			foreach($mod->getScripts() as $script) {
				array_push($scripts, $script);
			}
		}
		return array_unique($scripts);
	}
	
	public function addModule(Module $mod) {
		array_push($this->ModulesPool, $mod);
	}
	
	public function getModule($id) {
		if($id < $this->getCount()) {
			return $this->ModulesPool[$id];
		}
	}
	
	public function getModulesNumInBlock($id) {
		$n = 0;
		foreach($this->ModulesPool as $Module) {
			if($Module->getPosition()->getBlock() == $id) {
				$n++;
			}
		}
		return $n;
	}
	
	/**
	* Inherited from JsonSerializable
	**/
	public function jsonSerialize() {
		return $this->ModulesPool;
	}
	
	/**
	* Inherited from Iterator
	**/
	function rewind() {
		$this->position = 0;
	}

	function current() {
		return $this->ModulesPool[$this->position];
	}

	function key() {
		return $this->position;
	}

	function next() {
		++$this->position;
	}

	function valid() {
		return isset($this->ModulesPool[$this->position]);
	}
}
