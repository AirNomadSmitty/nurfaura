<?php

namespace App\Actions;

use Aura\View\View;
use Aura\Web\Request;
use Aura\Web\Response;
use App\Mappers\UserScoreMapper;

class IndexAction extends BaseAction {

	const LEADERBOARD_LIMIT = 10;

	protected $view;
	protected $userScoreMapper;

	public function __construct(Request $request, Response $response, View $view, UserScoreMapper $userScoreMapper) {
		parent::__construct($request, $response);
		$this->view = $view;
		$this->userScoreMapper = $userScoreMapper;
	}

	public function __invoke() {
		$topTen = $this->userScoreMapper->getLimitedOrderByScore(self::LEADERBOARD_LIMIT);
		$recent = $this->userScoreMapper->getLimitedOrderByCreated(self::LEADERBOARD_LIMIT);
		$this->view->setView('index');
		$this->view->setData(['topTen'=>$topTen, 'recent'=>$recent]);
		$this->view->setLayout('default');
		$this->response->content->set($this->view->__invoke());
	}
}
