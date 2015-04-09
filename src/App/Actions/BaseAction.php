<?php
namespace App\Actions;

use Aura\Di\Container;
use Aura\View\View;
use Aura\Web\Request;
use Aura\Web\Response;

class BaseAction {

	protected $request;
	protected $response;

	public function __construct(Request $request, Response $response) {
		$this->request = $request;
		$this->response = $response;
	}
}
