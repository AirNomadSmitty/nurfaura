<?php

namespace App\Objects\RiotApiObjects;

/**
 * Class to house riot Match detail json
 *
 * Class RiotMatch
 *
 * @package App\Objects\RiotApiObjects\Match
 */
class RiotMatchDetail {

	protected $matchId;
	protected $region;
	protected $platformId;
	protected $matchMode;
	protected $matchType;
	protected $matchCreation;
	protected $matchDuration;
	protected $queueType;
	protected $mapId;
	protected $season;
	protected $matchVersion;
	protected $participants;
	protected $participantIdentities;
	protected $teams;
	protected $timeline;

	public function __construct($matchJson){
		$this->matchId = $matchJson['matchId'];
		$this->region = $matchJson['region'];
		$this->platformId = $matchJson['platformId'];
		$this->matchMode = $matchJson['matchMode'];
		$this->matchType = $matchJson['matchType'];
		$this->matchCreation = $matchJson['matchCreation'];
		$this->matchDuration = $matchJson['matchDuration'];
		$this->queueType = $matchJson['queueType'];
		$this->mapId = $matchJson['mapId'];
		$this->season = $matchJson['season'];
		$this->matchVersion = $matchJson['matchVersion'];
		$this->buildParticipantsFromJson($matchJson['participants']);
		$this->participantIdentities = $matchJson['participantIdentities'];
		$this->buildTeamsFromJson($matchJson['teams']);
		$this->timeline = $matchJson['timeline'];
	}

	protected function buildParticipantsFromJson($participantsJson){
		foreach($participantsJson as $participantJson){
			$participant = new RiotParticipant($participantJson);
			$this->participants[$participant->getParticipantId()] = $participant;
		}
	}

	protected function buildTeamsFromJson($teamsJson){
		foreach($teamsJson as $teamJson){
			$team = new RiotTeam($teamJson);
			$this->teams[$team->getTeamId()] = $team;
		}
	}

	public function getParticipantsByTeam(){
		$return = [];
		foreach($this->participants as $participant){
			$return[$participant->getTeamId()][$participant->getParticipantId()] = $participant;
		}
		return $return;
	}

	public function getTimeline(){
		return $this->timeline;
	}
}