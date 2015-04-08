<?php

namespace App\Objects\RiotApiObjects;

/**
 * Class to house riot team json
 *
 * Class RiotMatch
 *
 * @package App\Objects\RiotApiObjects\RiotTeam
 */
class RiotTeam {

	protected $teamId;
	protected $winner;
	protected $firstBlood;
	protected $firstTower;
	protected $firstInhibitor;
	protected $firstBaron;
	protected $firstDragon;
	protected $towerKills;
	protected $inhibitorKills;
	protected $baronKills;
	protected $dragonKills;
	protected $vilemawKills;
	protected $dominionVictoryScore;
	protected $bans;

	public function __construct($teamJson){
		$this->teamId = $teamJson['teamId'];
		$this->winner = $teamJson['winner'];
		$this->firstBlood = $teamJson['firstBlood'];
		$this->firstTower = $teamJson['firstTower'];
		$this->firstInhibitor = $teamJson['firstInhibitor'];
		$this->firstBaron = $teamJson['firstBaron'];
		$this->firstDragon = $teamJson['firstDragon'];
		$this->towerKills = $teamJson['towerKills'];
		$this->inhibitorKills = $teamJson['inhibitorKills'];
		$this->baronKills = $teamJson['baronKills'];
		$this->dragonKills = $teamJson['dragonKills'];
		$this->vilemawKills = $teamJson['vilemawKills'];
		$this->dominionVictoryScore = $teamJson['dominionVictoryScore'];
		$this->bans = $teamJson['bans'];
	}

	public function getTeamId(){
		return $this->teamId;
	}

}
