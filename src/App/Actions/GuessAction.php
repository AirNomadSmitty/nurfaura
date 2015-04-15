<?php

namespace App\Actions;

use App\Parsers\MatchDetailsJsonParser;
use Aura\Web\Request;
use Aura\Web\Response;
use Aura\View\View;
use App\Mappers\MatchMapper;
use GuzzleHttp\Client;

class GuessAction extends BaseAction {

	protected $view;
	protected $matchMapper;
	protected $apiKey;

	public function __construct(Request $request, Response $response, View $view, MatchMapper $matchMapper, $apiKey) {
		parent::__construct($request, $response);
		$this->view = $view;
		$this->matchMapper = $matchMapper;
		$this->apiKey = $apiKey;
	}

	public function __invoke() {
		$this->view->setView('guess');
		$this->view->setLayout('default');
		$this->response->content->set($this->view->__invoke());
	}
}