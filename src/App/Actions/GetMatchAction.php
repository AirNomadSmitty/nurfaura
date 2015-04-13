<?php

namespace App\Actions;

use App\Objects\Session\SessionConstants;
use App\Parsers\MatchDetailsJsonParser;
use Aura\Session\Session;
use Aura\Web\Request;
use Aura\Web\Response;
use Aura\View\View;
use App\Mappers\MatchMapper;
use GuzzleHttp\Client;

class GetMatchAction extends BaseAction {

	protected $view;
	protected $matchMapper;
	protected $apiKey;
	protected $session;

	public function __construct(Request $request, Response $response, View $view, MatchMapper $matchMapper, Session $session, $apiKey) {
		parent::__construct($request, $response);
		$this->view = $view;
		$this->matchMapper = $matchMapper;
		$this->apiKey = $apiKey;
		$this->session = $session;
	}

	public function __invoke() {
		$client = new Client();
		$match = $this->matchMapper->getRandom();
		$res = $client->get('https://na.api.pvp.net/api/lol/na/v2.2/match/'.$match->getRiotMatchId().'?includeTimeline=true&api_key='.$this->apiKey);
		$parser = new MatchDetailsJsonParser($res->json());

		//Save the winning team for later so we don't need to re-calculate it or pass it to the client for cheating
		$segment = $this->session->getSegment(SessionConstants::ACTIVE_SEGMENT_KEY);
		$segment->set(SessionConstants::WINNING_TEAM, $parser->getWinningTeam());
		$this->response->content->set($parser->getUsefulJson());
	}
}