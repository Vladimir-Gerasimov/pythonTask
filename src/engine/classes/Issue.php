<?php

/**
* This class is for working with a single Issue
* Contains setters and getters for each property of an Issue
* Containg all methods for interaction with the issue
**/
class Issue implements JsonSerializable {
	protected $id;
	protected $head;
	protected $text;
	protected $creator;
	protected $date;
	protected $status;
	protected $rating;
	protected $files;
	
	function __construct($id, $head, $text, $creator, $date, $status, $rating, FileFactory $files) {
		$this->id = $id;
		$this->head = $head;
		$this->text = $text;
		$this->creator = $creator;
		$this->date = $date;
		$this->status = $status;
		$this->rating = $rating;
		$this->files = $files;
	}
	
	/**
	* Block of setters
	**/
	public function setHead($head) {
		$this->head = $head;
	}
	
	public function setText($text) {
		$this->text = $text;
	}
	
	public function setCreator($creator) {
		$this->creator = $creator;
	}
	
	public function setStatus($status) {
		$this->status = $status;
	}
	
	public function setRating($rating) {
		$this->rating = $rating;
	}
	
	public function setFiles(FileFactory $files) {
		$this->files = $files;
	}
	
	/**
	* Block of getters
	**/
	public function getId() {
		return $this->id;
	}
	
	public function getHead() {
		return $this->head;
	}
	
	public function getText() {
		return $this->text;
	}
	
	public function getCreator() {
		return $this->creator;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	public function getRating() {
		return $this->rating;
	}
	
	public function getFiles() {
		return $this->files;
	}
	
	/**
	* Methods
	**/
	public function jsonSerialize() {
        return array(
			'id' => $this->id, 
			'head' => $this->head, 
			'text' => $this->text, 
			'creator' => $this->creator, 
			'date' => $this->date, 
			'status' => $this->status, 
			'rating' => $this->rating, 
			'files' => $this->files, 
		);
    }
	
	public function increaseRating() {
		$this->rating++;
	}
	
	public function addFile(File $file) {
		$this->files->addFile($file);
	}

}
