<?php

/**
* This class represents User in the system
* All methods for interaction with user
**/
class User {
	protected $id;
	protected $name;
	protected $surname;
	protected $house;
	protected $flat;
	protected $porch;
	protected $mail;
	protected $pwd;
	protected $phone;
	
	function __construct() {
	
	}
	
	/**
	* Block of setters
	**/
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function setSurname($surname) {
		$this->surname = $surname;
	}
	
	public function setHouse($house) {
		$this->house = $house;
	}
	
	public function setFlat($flat) {
		$this->flat = $flat;
	}
	
	public function setPorch($porch) {
		$this->porch = $porch;
	}
	
	public function setMail($mail) {
		$this->mail = $mail;
	}
	
	public function setPwd($pwd) {
		$this->pwd = $pwd;
	}
	
	public function setPhone($phone) {
		$this->phone = $phone;
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
	
	public function getSurname() {
		return $this->surname;
	}
	
	public function getHouse() {
		return $this->house;
	}
	
	public function getFlat() {
		return $this->flat;
	}
	
	public function getPorch() {
		return $this->porch;
	}
	
	public function getMail() {
		return $this->mail;
	}
	
	public function getPwd() {
		return $this->pwd;
	}
	
	public function getPhone() {
		return $this->phone;
	}
	
	public function getUsernameShorten() {
		return $this->name . " " . mb_substr( $this->surname, 0, 1, "UTF-8") . ".";
	}
}
