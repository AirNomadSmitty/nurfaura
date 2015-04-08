<?php

namespace App\Objects\Match;

class Match {

	protected $id;
	protected $riotMatchId;
	protected $sumGuessed;
	protected $sumCorrect;

	public function __construct($id, $riotMatchId, $sumGuessed, $sumCorrect){
		$this->id = $id;
		$this->riotMatchId = $riotMatchId;
		$this->sumGuessed = $sumGuessed;
		$this->sumCorrect = $sumCorrect;
	}

	/**
	 * @param int $id
	 */
	public function setId( $id ) {
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param int $riotMatchId
	 */
	public function setRiotMatchId( $riotMatchId ) {
		$this->riotMatchId = $riotMatchId;
	}

	/**
	 * @return int
	 */
	public function getRiotMatchId() {
		return $this->riotMatchId;
	}

	/**
	 * @param int $sumCorrect
	 */
	public function setSumCorrect( $sumCorrect ) {
		$this->sumCorrect = $sumCorrect;
	}

	/**
	 * @return int
	 */
	public function getSumCorrect() {
		return $this->sumCorrect;
	}

	/**
	 * @param int $sumGuessed
	 */
	public function setSumGuessed( $sumGuessed ) {
		$this->sumGuessed = $sumGuessed;
	}

	/**
	 * @return int
	 */
	public function getSumGuessed() {
		return $this->sumGuessed;
	}


}