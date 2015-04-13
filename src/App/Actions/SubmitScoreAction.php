<?php

namespace App\Actions;

use App\Mappers\UserScoreMapper;
use App\Objects\Session\SessionConstants;
use App\Objects\UserScore\UserScore;
use Aura\Session\Session;
use Aura\Web\Request;
use Aura\Web\Response;

class SubmitScoreAction extends BaseAction {

	protected $userScoreMapper;
	protected $session;

	public function __construct (Request $request, Response $response, UserScoreMapper $userScoreMapper, Session $session){
		parent::__construct($request, $response);
		$this->userScoreMapper = $userScoreMapper;
		$this->session = $session;
	}

	public function __invoke() {
		$segment = $this->session->getSegment(SessionConstants::FINISHED_SEGMENT_KEY);
		$score = $segment->get(SessionConstants::TOTAL_SCORE);
		$questions = $segment->get(SessionConstants::QUESTION_COUNT);
		$username = $this->request->query->get('username');
		$userScore = new UserScore(null, $username, $score, null, $questions);
		$this->userScoreMapper->save($userScore);
		$segment->clear();
		$this->response->content->set(json_encode(['success'=>true]));
	}
}