<?php

namespace App\Actions;

use Aura\Web\Request;
use Aura\Web\Response;
use Aura\View\View;

class LeaderboardAction extends BaseAction {

	protected $view;

	public function __construct(Request $request, Response $response, View $view) {
		parent::__construct($request, $response);
		$this->view = $view;
	}

	public function __invoke() {
		$this->view->setView('leaderboard');
		$this->view->setLayout('default');
		$this->response->content->set($this->view->__invoke());
	}
}