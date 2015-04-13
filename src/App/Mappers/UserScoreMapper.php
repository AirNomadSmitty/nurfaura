<?php

namespace App\Mappers;

use App\Objects\UserScore\UserScore;
use Aura\Sql\ExtendedPdo;

class UserScoreMapper {

	protected $db;

	public function __construct(ExtendedPdo $db){
		$this->db = $db;
	}

	public function save(UserScore $userScore){
		$sql = "Insert into userScore (`username`, `score`, `questionCount`)
		values (:username, :score, :questionCount)";
		$this->db->perform($sql, ['username'=>$userScore->getUsername(), 'score'=> $userScore->getScore(), 'questionCount'=> $userScore->getQuestionCount()]);
	}

	public function getFromTimeOrderByScore($from){
		$sql = "Select * from userScores where created > :from and created < NOW() Order by `score` desc";
		return $this->db->fetchAssoc($sql, ['from'=>$from]);
	}


	protected function makeFromArray($data){
		$return = [];
		foreach($data as $row){
			$return[$row['userScoreId']] = new UserScore(
				$row['userScoreId'],
				$row['username'],
				$row['score'],
				$row['created'],
				$row['questionCount']
			);
		}
		return $return;
	}
}