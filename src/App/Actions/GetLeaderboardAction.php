<?php

namespace App\Actions;

use Aura\Web\Request;
use Aura\Web\Response;
use Aura\View\View;
use App\Mappers\UserScoreMapper;
use GuzzleHttp\Client;

class GetLeaderboardAction extends BaseAction {

	protected $userScoreMapper;

	public function __construct(Request $request, Response $response, UserScoreMapper $userScoreMapper) {
		parent::__construct($request, $response);
		$this->userScoreMapper = $userScoreMapper;
	}

	public function __invoke() {
		if ($this->request->query->get('username')){
			$scores = $this->userScoreMapper->getArrayLikeUsername($this->request->query->get('username'));
		} else {
			$scores = $this->userScoreMapper->getAllArrayOrderByScore();
		}
		$this->response->content->set(json_encode($scores));
	}
}