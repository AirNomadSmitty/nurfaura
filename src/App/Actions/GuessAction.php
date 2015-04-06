<?php

namespace App\Actions;

use Aura\Di\Container;
use Aura\Web\Request;
use Aura\Web\Response;

class GuessAction {

	use BaseActionTrait;

	public function __invoke() {
		$this->view->setView('guess');
		$this->view->setLayout('default');
		$this->response->content->set($this->view->__invoke());
	}
}