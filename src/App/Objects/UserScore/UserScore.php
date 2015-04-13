<?php

namespace App\Objects\UserScore;

class UserScore {

	protected $id;
	protected $username;
	protected $score;
	protected $created;
	protected $questionCount;

	public function __construct($id, $username, $score, $created, $questionCount){
		$this->id = $id;
		$this->username = $username;
		$this->score = $score;
		$this->created = $created;
		$this->questionCount = $questionCount;
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated( $created ) {
		$this->created = $created;
	}

	/**
	 * @return mixed
	 */
	public function getCreated() {
		return $this->created;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $questionCount
	 */
	public function setQuestionCount($questionCount){
		$this->questionCount = $questionCount;
	}

	/**
	 * @return int
	 */
	public function getQuestionCount(){
		return $this->questionCount;
	}

	/**
	 * @param mixed $score
	 */
	public function setScore( $score ) {
		$this->score = $score;
	}

	/**
	 * @return mixed
	 */
	public function getScore() {
		return $this->score;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername( $username ) {
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getUsername() {
		return $this->username;
	}


}