<?php

namespace App\Actions;

use Aura\View\View;
use Aura\Web\Request;
use Aura\Web\Response;
use App\Mappers\UserScoreMapper;

class IndexAction extends BaseAction {

	protected $view;
	protected $userScoreMapper;

	public function __construct(Request $request, Response $response, View $view, UserScoreMapper $userScoreMapper) {
		parent::__construct($request, $response);
		$this->view = $view;
		$this->userScoreMapper = $userScoreMapper;
	}

	public function __invoke() {
		$this->view->setView('index');
		$this->view->setLayout('default');
		$this->response->content->set($this->view->__invoke());
	}
}
