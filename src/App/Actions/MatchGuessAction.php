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
		$this->segment = $this->session->getSegment(SessionConstants::SEGMENT_KEY);

	}

	public function __invoke() {
		$score = $this->request->query->get('score');
		/* for debug purposes */
		if ($score==0 || !$this->segment->get(SessionConstants::WINNING_TEAM) || $score > self::SCORE_LIMIT){
			echo '<pre>';
			print_r($this->segment);
			echo '</pre>';
			$this->session->destroy();
		}else if($this->request->query->get('teamId') == $this->segment->get(SessionConstants::WINNING_TEAM)){
			$this->matchMapper->logGuess($this->request->query->get('matchId'), true);
			$this->correctGuess($score);
		} else {
			$this->matchMapper->logGuess($this->request->query->get('matchId'), true);
			$this->incorrectGuess();
		}
		$this->segment->set(SessionConstants::WINNING_TEAM, null);
	}

	protected function correctGuess($score){
		$segment = $this->segment;
		$previousTotal = $segment->getFlash(SessionConstants::TOTAL_SCORE);
		$segment->setFlash(SessionConstants::TOTAL_SCORE, $previousTotal+$score);
		$count = $segment->get(SessionConstants::QUESTION_COUNT)+1;
		$segment->set(SessionConstants::QUESTION_COUNT, $count);
		$this->response->content->set(json_encode(['previousTotal'=>$previousTotal, 'score'=>$score, 'questionCount'=>$count]));
	}

	protected function incorrectGuess(){
		$segment = $this->segment;
		$this->response->content->set('Nice run! Your final score is'.$segment->getFlash(SessionConstants::TOTAL_SCORE));
		$this->session->destroy();
	}

}