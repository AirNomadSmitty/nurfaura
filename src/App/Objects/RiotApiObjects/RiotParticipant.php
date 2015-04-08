<?php

namespace App\Objects\RiotApiObjects;

/**
 * Class to house riot participant json
 *
 * Class RiotMatch
 *
 * @package App\Objects\RiotApiObjects\RiotParticipant
 */
class RiotParticipant {

	protected $participantId;
	protected $teamId;
	protected $spell1Id;
	protected $spell2Id;
	protected $championId;
	protected $highestAchievedSeasonTear;
	protected $timeline;
	protected $masteries;
	protected $stats;
	protected $runes;


	public function __construct($participantJson){
		$this->participantId = $participantJson['participantId'];
		$this->teamId = $participantJson['teamId'];
		$this->spell1Id = $participantJson['spell1Id'];
		$this->spell2Id = $participantJson['spell2Id'];
		$this->championId = $participantJson['championId'];
		$this->highestAchievedSeasonTear = $participantJson['highestAchievedSeasonTier'];
		$this->timeline = $participantJson['timeline'];
		$this->masteries = $participantJson['masteries'];
		$this->stats = $participantJson['stats'];
		$this->runes = $participantJson['runes'];
	}

	/**
	 * @param mixed $championId
	 */
	public function setChampionId( $championId ) {
		$this->championId = $championId;
	}

	/**
	 * @return mixed
	 */
	public function getChampionId() {
		return $this->championId;
	}

	/**
	 * @param mixed $highestAchievedSeasonTear
	 */
	public function setHighestAchievedSeasonTear( $highestAchievedSeasonTear ) {
		$this->highestAchievedSeasonTear = $highestAchievedSeasonTear;
	}

	/**
	 * @return mixed
	 */
	public function getHighestAchievedSeasonTear() {
		return $this->highestAchievedSeasonTear;
	}

	/**
	 * @param mixed $masteries
	 */
	public function setMasteries( $masteries ) {
		$this->masteries = $masteries;
	}

	/**
	 * @return mixed
	 */
	public function getMasteries() {
		return $this->masteries;
	}

	/**
	 * @param mixed $participantId
	 */
	public function setParticipantId( $participantId ) {
		$this->participantId = $participantId;
	}

	/**
	 * @return mixed
	 */
	public function getParticipantId() {
		return $this->participantId;
	}

	/**
	 * @param mixed $runes
	 */
	public function setRunes( $runes ) {
		$this->runes = $runes;
	}

	/**
	 * @return mixed
	 */
	public function getRunes() {
		return $this->runes;
	}

	/**
	 * @param mixed $spell1Id
	 */
	public function setSpell1Id( $spell1Id ) {
		$this->spell1Id = $spell1Id;
	}

	/**
	 * @return mixed
	 */
	public function getSpell1Id() {
		return $this->spell1Id;
	}

	/**
	 * @param mixed $spell2Id
	 */
	public function setSpell2Id( $spell2Id ) {
		$this->spell2Id = $spell2Id;
	}

	/**
	 * @return mixed
	 */
	public function getSpell2Id() {
		return $this->spell2Id;
	}

	/**
	 * @param mixed $stats
	 */
	public function setStats( $stats ) {
		$this->stats = $stats;
	}

	/**
	 * @return mixed
	 */
	public function getStats() {
		return $this->stats;
	}

	/**
	 * @param mixed $teamId
	 */
	public function setTeamId( $teamId ) {
		$this->teamId = $teamId;
	}

	/**
	 * @return mixed
	 */
	public function getTeamId() {
		return $this->teamId;
	}

	/**
	 * @param mixed $timeline
	 */
	public function setTimeline( $timeline ) {
		$this->timeline = $timeline;
	}

	/**
	 * @return mixed
	 */
	public function getTimeline() {
		return $this->timeline;
	}



}