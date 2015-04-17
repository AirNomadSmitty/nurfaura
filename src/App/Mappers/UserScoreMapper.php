<?php

namespace App\Mappers;

use App\Objects\UserScore\UserScore;
use Aura\Sql\ExtendedPdo;

/**
 * Class UserScoreMapper for interacting with UserScore table
 * Note that some of the getters return arrays instead of standard php objects.
 * This is because we're going to be getting most of these via post requests so we'll be passing them back as json anyway
 * Due to the large numbers of scores we'll be passing, easiest to leave them in array form in this case.
 *
 * @package App\Mappers
 */
class UserScoreMapper {

	protected $db;

	public function __construct(ExtendedPdo $db){
		$this->db = $db;
	}

	public function save(UserScore $userScore){
		if(!$userScore->getScore()){
			return false;
		}
		$sql = "Insert into userScores (`username`, `score`, `questionCount`)
		values (:username, :score, :questionCount)";
		$this->db->perform($sql, ['username'=>$userScore->getUsername(), 'score'=> $userScore->getScore(), 'questionCount'=> $userScore->getQuestionCount()]);
		return true;
	}

	public function getFromTimeOrderByScore($from){
		$sql = "Select * from userScores where created > :from and created < NOW() Order by `score` desc";
		return $this->db->fetchAll($sql, ['from'=>$from]);
	}

	public function getAllArrayOrderByScore(){
		$sql = "Select * from userScores Order By `score` desc";
		return $this->db->fetchAll($sql);
	}

	public function getArrayLikeUsername($username){
		$sql = "Select * from userScores where `username` like :username";
		return $this->db->fetchAll($sql, ['username'=>'%'.$username.'%']);
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