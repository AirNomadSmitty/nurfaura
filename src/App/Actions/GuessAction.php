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
		$client = new Client();
		$match = $this->matchMapper->getRandom();
		$res = $client->get('https://na.api.pvp.net/api/lol/na/v2.2/match/'.$match->getRiotMatchId().'?includeTimeline=true&api_key='.$this->apiKey);
		$parser = new MatchDetailsJsonParser($res->json());

		$this->view->setView('guess');
		$this->view->setData( ['match'=>$parser->getUsefulJson()]);
		$this->view->setLayout('default');
		$this->response->content->set($this->view->__invoke());
	}
}