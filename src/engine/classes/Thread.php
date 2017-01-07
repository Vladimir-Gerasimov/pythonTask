<?php

/**
* This class is for working with a single Issue
* Contains setters and getters for each property of an Issue
* Containg all methods for interaction with the issue
**/
class Thread implements JsonSerializable {
	protected $id;
	protected $head;
	protected $text;
	protected $creator;
	protected $date;
	protected $poll;
	protected $files;
	
	function __construct($id, $head, $text, $creator, $date, Poll $poll, FileFactory $files) {
		$this->id = $id;
		$this->head = $head;
		$this->text = $text;
		$this->creator = $creator;
		$this->date = $date;
		$this->poll = $poll;
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
	
	public function setPoll(Poll $poll) {
		$this->poll = $poll;
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
	
	public function getPoll() {
		return $this->poll;
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
			'poll' => $this->poll,
			'files' => $this->files, 
		);
    }
	
}
