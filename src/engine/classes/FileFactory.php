<?php

/**
* This class is for working with a pool of File
* It is a kind of container for a group of Files
* Contains methods for File creation and exctaction
**/
class FileFactory implements JsonSerializable {
	protected $FilePool = array();
	
	function __construct() {
	
	}
	
	public function getCount() {
		return count($this->FilePool);
	}
	
	public function getIds() {
		$ids = array();
		foreach($this->FilePool as $File) {
			array_push($ids, $File->getId());
		}
		return $ids;
	}
	
	public function addFile(File $file) {
		array_push($this->FilePool, $file);
	}
	
	public function getFile($id) {
		if($id < $this->getCount()) {
			return $this->FilePool[$id];
		}
		return false;
	}
	
	public function jsonSerialize() {
		return $this->FilePool;
	}
}
