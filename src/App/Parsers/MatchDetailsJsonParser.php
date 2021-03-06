<?php

namespace App\Parsers;

use App\Misc;

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
	const TOTAL_MATCH_REPLAY_TIME = 30000;
	const TEAM_KEY_1 = 'blue';
	const TEAM_KEY_2 = 'red';

	protected $matchJson;
	protected $participantTeamMap;
	protected $teamIdKeyMap;
	protected $gameLength;

	public function __construct($matchJson){
		$this->matchJson = $matchJson;
		$this->participantTeamMap = $this->generateParticipantsByTeam();
		$this->gameLength = $this->getGameLength();
		$this->teamIdKeyMap = $this->getTeamIdKeyMap();
	}

	protected function generateParticipantsByTeam(){
		$participantTeamMap = [];
		foreach($this->matchJson['participants'] as $participantJson){
			$participantTeamMap[$participantJson['participantId']] = $participantJson['teamId'];
		}
		return $participantTeamMap;
	}

	protected function getGameLength(){
		$lastFrame = end($this->matchJson['timeline']['frames']);
		return $lastFrame['timestamp'];
	}

	/**
	 * Want to err on the side of caution incase rito switches up the ids they use
	 *
	 * @return array of format [teamId=>key]
	 */
	protected function getTeamIdKeyMap(){
		$teamIdKeyMap = [];
		$teamIdKeyMap[$this->matchJson['teams'][0]['teamId']] = self::TEAM_KEY_1;
		$teamIdKeyMap[$this->matchJson['teams'][1]['teamId']] = self::TEAM_KEY_2;
		return $teamIdKeyMap;
	}

	protected function normalizeTimestamp($timestamp){
		return (int)(($timestamp / $this->gameLength) * self::TOTAL_MATCH_REPLAY_TIME);
	}
	
	protected function prettyTimestamp($timestamp){
		$seconds = floor($timestamp/1000);
		$minutes = floor($seconds / 60);
		$seconds = $seconds % 60;

		return sprintf("%01d:%02d", $minutes, $seconds);

	}

	protected function getKeyFromTeamId($teamId){
		return $this->teamIdKeyMap[$teamId];
	}

	public function getUsefulArray(){
		$return = [];
		$return['match'] = $this->matchJson['matchId'];
		$return['teams'] = $this->buildUsefulTeamsJson();
		$return['events'] = $this->buildUsefulEventsJson();
		$return['matchLength'] = $this->prettyTimestamp($this->gameLength);
		return $return;
	}

	protected function buildUsefulTeamsJson(){
		$teamsJson = [];
		foreach($this->matchJson['teams'] as $teamJson){
			$team= $this->getKeyFromTeamId($teamJson['teamId']);
			$teamsJson[$team] = [
				'team'=> $team,
				'winner'=>$teamJson['winner'],
				'participants'=>$this->buildUsefulParticipantsJsonFromTeamId($teamJson['teamId'])
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
					'currentKills' => 0,
					'currentDeaths' => 0,
					'currentAssists' => 0,
					'championId' => $participantJson['championId'],
					'championImg' => Misc::makeImgUrlFromId($participantJson['championId']),
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
			if(isset($frame['events'])){
				foreach($frame['events'] as $eventJson){
					if($eventJson['eventType'] == self::EVENT_CHAMPION_KILL){
						$eventJson['normalizedTimestamp'] = $this->normalizeTimestamp($eventJson['timestamp']);
						$eventJson['prettyTimestamp'] = $this->prettyTimestamp($eventJson['timestamp']);
						$timelineJson[] = $eventJson;
					}
				}
			}
			$timelineJson[] = ['eventType'=> self::EVENT_GOLD_UPDATE, 'normalizedTimestamp'=> $this->normalizeTimestamp($frame['timestamp']), 'prettyTimestamp'=>$this->prettyTimestamp($frame['timestamp']), 'timestamp'=>$frame['timestamp'], 'gold' => $this->buildTeamGoldJsonFromParticipantFrames($frame['participantFrames'])];
		}
		return $timelineJson;
	}

	protected function buildTeamGoldJsonFromParticipantFrames($participantFrames){
		$teams = array_values($this->participantTeamMap);
		$teamGoldJson = [];
		//Initialize just in case
		foreach($teams as $teamId){
			$teamGoldJson[$this->getKeyFromTeamId($teamId)] = 0;
		}
		foreach($participantFrames as $frame){
			$teamGoldJson[$this->getKeyFromTeamId($this->participantTeamMap[$frame['participantId']])] += $frame['totalGold'];
		}
		return $teamGoldJson;
	}

	public function getWinningTeam(){
		$winner = 0;
		foreach($this->matchJson['teams'] as $teamJson){
			if($teamJson['winner']==true){
				$winner=$this->getKeyFromTeamId($teamJson['teamId']);
			}
		}
		return $winner;
	}
}