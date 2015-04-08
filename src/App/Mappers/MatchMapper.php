<?php

namespace App\Mappers;

use App\Objects\Match\Match;
use Aura\Sql\ExtendedPdo;

class MatchMapper {

	protected $db;

	public function __construct(ExtendedPdo $db){
		$this->db = $db;
	}

	/**
	 * Selects a random match from the table
	 *
	 * @return null|Match
	 */
	public function getRandom(){
		$id = self::getRandomId();
		$results = $this->db->fetchAssoc('Select * from matches where matchId = :id', ['id'=>$id]);
		$matches = self::makeFromArray($results);
		return (isset($matches[$id])? $matches[$id] : null);
	}

	private function getRandomId(){
		$results = $this->db->fetchAll('Select Max(matchId) as max, Min(matchId) as min from matches');
		$results = $results[0];
		$max = $results['max'];
		$min = $results['min'];
		$id = mt_rand($min, $max);
		return $id;
	}

	/**
	 * Takes an array of data from the db and returns an array of match objects keyed by matchId
	 *
	 *
	 * @param $data
	 * @return Match[]
	 */
	private function makeFromArray($data){
		$return = [];
		foreach($data as $row){
			$return[$row['matchId']] = new Match(
				$row['matchId'],
				$row['riotMatchId'],
				$row['sumGuessed'],
				$row['sumCorrect']
			);
		}
		return $return;
	}
}