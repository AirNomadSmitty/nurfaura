<?php

namespace App\Actions;

use App\Objects\Session\SessionConstants;
use Aura\Session\Session;
use Aura\Web\Request;
use Aura\Web\Response;
use App\Mappers\MatchMapper;

class MatchGuessAction extends BaseAction {

	const SCORE_LIMIT = 500;
	protected $matchMapper;
	protected $session;
	protected $segment;

	public function __construct(Request $request, Response $response, MatchMapper $matchMapper, Session $session) {
		parent::__construct($request, $response);
		$this->matchMapper = $matchMapper;
		$this->session = $session;
		$this->segment = $this->session->getSegment(SessionConstants::ACTIVE_SEGMENT_KEY);

	}

	public function __invoke() {
		$score = $this->request->post->get('score');
		/* for debug purposes */
		if ($score==0 || !$this->segment->get(SessionConstants::WINNING_TEAM) || $score > self::SCORE_LIMIT){
			$this->session->destroy();
		}else if($this->request->post->get('team') == $this->segment->get(SessionConstants::WINNING_TEAM)){
			$this->correctGuess($score);
		} else {
			$this->incorrectGuess();
		}
		$this->segment->set(SessionConstants::WINNING_TEAM, null);
	}

	protected function correctGuess($score){
		$this->matchMapper->logGuess($this->request->post->get('matchId'), true);
		$segment = $this->segment;
		$previousTotal = $segment->get(SessionConstants::TOTAL_SCORE);
		$segment->set(SessionConstants::TOTAL_SCORE, $previousTotal+$score);
		$count = $segment->get(SessionConstants::QUESTION_COUNT)+1;
		$segment->set(SessionConstants::QUESTION_COUNT, $count);
		$this->response->content->set(json_encode(['correct'=>true, 'score'=>$previousTotal+$score, 'questionCount'=>$count]));
	}

	protected function incorrectGuess(){
		$this->matchMapper->logGuess($this->request->post->get('matchId'), false);
		$segment = $this->segment;
		$previousTotal = $segment->get(SessionConstants::TOTAL_SCORE);
		$count = $segment->get(SessionConstants::QUESTION_COUNT);

		$this->response->content->set('Nice run! Your final score is'.$previousTotal);

		/* Move scores into another segment that way we can clear this one right away to avoid cheating
		   Need to save them still for logging to leaderboards once username is picked*/
		$finishedSegment = $this->session->getSegment(SessionConstants::FINISHED_SEGMENT_KEY);
		$finishedSegment->set(SessionConstants::QUESTION_COUNT, $count);
		$finishedSegment->set(SessionConstants::TOTAL_SCORE, $previousTotal);
		$this->segment->clear();

		$this->response->content->set(json_encode(['correct'=>false, 'score'=>$previousTotal, 'questionCount'=>$count]));
	}

}