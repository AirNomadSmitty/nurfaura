<?php

namespace App\Parsers;

/**
 * Class MatchDetailsJsonParser
 *
 * Houses the json
 * Deciding to leave it in json format rather than convert to a php object
 * We ned to pass it back to the view as json anyway, no reason to convert then switch back
 * Except maybe for readability ;)
 *
 * @package App\Parsers
 */
class MatchDetailsJsonParser {

	const EVENT_CHAMPION_KILL = "CHAMPION_KILL";
	const EVENT_GOLD_UPDATE = "GOLD_UPDATE";

	protected $matchJson;
	protected $participantTeamMap;

	public function __construct($matchJson){
		$this->matchJson = $matchJson;
		$this->participantTeamMap = $this->generateParticipantsByTeam();
	}

	protected function generateParticipantsByTeam(){
		$participantTeamMap = [];
		foreach($this->matchJson['participants'] as $participantJson){
			$participantTeamMap[$participantJson['participantId']] = $participantJson['teamId'];
		}
		return $participantTeamMap;
	}

	public function getUsefulJson(){
		$return = [];
		$return['match'] = $this->matchJson['matchId'];
		$return['teams'] = $this->buildUsefulTeamsJson();
		$return['events'] = $this->buildUsefulEventsJson();
		return json_encode($return);
	}

	protected function buildUsefulTeamsJson(){
		$teamsJson = [];
		foreach($this->matchJson['teams'] as $teamJson){
			$id = $teamJson['teamId'];
			$teamsJson[$id] = [
				'teamId'=> $id,
				'winner'=>$teamJson['winner'],
				'participants'=>$this->buildUsefulParticipantsJsonFromTeamId($id)
			];
		}
		return $teamsJson;
	}

	protected function buildUsefulParticipantsJsonFromTeamId($teamId){
		$participantsJson = [];
		foreach($this->matchJson['participants'] as $participantJson){
			if($participantJson['teamId'] == $teamId){
				$id = $participantJson['participantId'];
				$participantsJson[$id] = [
					'participantId' => $id,
					'championId' => $participantJson['championId'],
					'tier' => $participantJson['highestAchievedSeasonTier'],
					'lane' => $participantJson['timeline']['lane']
				];
			}
		}
		return $participantsJson;
	}

	protected function buildUsefulEventsJson(){
		$timelineJson = [];
		foreach($this->matchJson['timeline']['frames'] as $frame){
			$timelineJson[$frame['timestamp']] = ['eventType'=> self::EVENT_GOLD_UPDATE, 'timestamp'=> $frame['timestamp'], 'gold' => $this->buildTeamGoldJsonFromParticipantFrames($frame['participantFrames'])];
			if(isset($frame['events'])){
				foreach($frame['events'] as $eventJson){
					if($eventJson['eventType'] == self::EVENT_CHAMPION_KILL){
						$timelineJson[$eventJson['timestamp']] = $eventJson;
					}
				}
			}
		}
		return $timelineJson;
	}

	protected function buildTeamGoldJsonFromParticipantFrames($participantFrames){
		$teams = array_values($this->participantTeamMap);
		$teamGoldJson = [];
		foreach($teams as $teamId){
			$teamGoldJson[$teamId] = 0;
		}
		foreach($participantFrames as $frame){
			$teamGoldJson[$this->participantTeamMap[$frame['participantId']]] += $frame['totalGold'];
		}
		return $teamGoldJson;
	}

	public function getWinningTeam(){
		$winner = 0;
		foreach($this->matchJson['teams'] as $teamJson){
			if($teamJson['winner']==true){
				$winner=$teamJson['teamId'];
			}
		}
		return $winner;
	}
}