<?php
namespace Aura\Framework_Project\_Config;

use Aura\Di\Config;
use Aura\Di\Container;

class Common extends Config
{
    public function define(Container $di)
    {
		$config = include(dirname(__DIR__) . '/config/config.php');
        $di->set('aura/project-kernel:logger', $di->lazyNew('Monolog\Logger'));
		$di->set('view', $di->lazyNew('Aura\View\View'));
		$di->set('db', $di->lazyNew('Aura\sql\ExtendedPdo', ['dsn' => $config['db']['dsn'],
							 'username'=> $config['db']['username'],
							 'password'=> $config['db']['password']
		]));

		$di->set('phpFunc', $di->lazyNew('Aura\Session\Phpfunc'));
		$di->set('sessionManager', $di->lazyNew('Aura\Session\Session', [
			$di->lazyNew('Aura\Session\SegmentFactory'),
			$di->lazyNew('Aura\Session\CsrfTokenFactory', [$di->lazyNew('Aura\Session\Randval')]),
			$di->lazyGet('phpFunc'),
			$_COOKIE,
		]));

		$di->types['Aura\Session\Phpfunc'] = $di->lazyGet('phpFunc');
		$di->types['Aura\Sql\ExtendedPdo'] = $di->lazyGet('db');
		$this->setMappers($di);
		$di->params['Aura\View\TemplateRegistry']['paths'] = array(
			dirname(__DIR__) . '/src/App/Views',
			dirname(__DIR__) . '/src/App/Layouts',
		);

		$di->params['App\Actions\IndexAction'] = array(
			'request' => $di->lazyGet('aura/web-kernel:request'),
			'response' => $di->lazyGet('aura/web-kernel:response'),
			'view' => $di->lazyGet('view'),
			'userScoreMapper'=> $di->lazyGet('UserScoreMapper')
		);

		$di->params['App\Actions\GuessAction'] = array(
			'request' => $di->lazyGet('aura/web-kernel:request'),
			'response' => $di->lazyGet('aura/web-kernel:response'),
			'view' => $di->lazyGet('view'),
			'matchMapper'=> $di->lazyGet('MatchMapper'),
			'apiKey'=>$config['apiKey']
	);

		$di->params['App\Actions\GetMatchAction'] = array(
			'request' => $di->lazyGet('aura/web-kernel:request'),
			'response' => $di->lazyGet('aura/web-kernel:response'),
			'view' => $di->lazyGet('view'),
			'matchMapper'=> $di->lazyGet('MatchMapper'),
			'apiKey'=>$config['apiKey']
		);

		$di->params['App\Actions\MatchGuessAction'] = array (
			'request' => $di->lazyGet('aura/web-kernel:request'),
			'response' => $di->lazyGet('aura/web-kernel:response'),
			'matchMapper'=> $di->lazyGet('MatchMapper'),
			'sessionManager' =>$di->lazyGet('SessionManager')
		);
    }

    public function modify(Container $di)
    {
        $this->modifyLogger($di);
        $this->modifyCliDispatcher($di);
        $this->modifyWebRouter($di);
        $this->modifyWebDispatcher($di);
	}

    protected function modifyLogger(Container $di)
    {
        $project = $di->get('project');
        $mode = $project->getMode();
        $file = $project->getPath("tmp/log/{$mode}.log");

        $logger = $di->get('aura/project-kernel:logger');
        $logger->pushHandler($di->newInstance(
            'Monolog\Handler\StreamHandler',
            array(
                'stream' => $file,
            )
        ));
    }

    protected function modifyCliDispatcher(Container $di)
    {
        $context = $di->get('aura/cli-kernel:context');
        $stdio = $di->get('aura/cli-kernel:stdio');
        $logger = $di->get('aura/project-kernel:logger');
        $dispatcher = $di->get('aura/cli-kernel:dispatcher');
        $dispatcher->setObject(
            'hello',
            function ($name = 'World') use ($context, $stdio, $logger) {
                $stdio->outln("Hello {$name}!");
                $logger->debug("Said hello to '{$name}'");
            }
        );
    }

    public function modifyWebRouter(Container $di)
    {
        $router = $di->get('aura/web-kernel:router');

        $router->add('IndexAction', '/');
		$router->add('GuessAction', '/guess');
		$router->add('GetMatchAction', '/getMatch');
		$router->add('MatchGuessAction', '/matchGuess');


	}

    public function modifyWebDispatcher($di)
    {
        $dispatcher = $di->get('aura/web-kernel:dispatcher');

		$dispatcher->setObject(
				   'IndexAction',
					   $di->lazyNew('App\Actions\IndexAction')
		);

		$dispatcher->setObject(
				   'GuessAction',
					   $di->lazyNew('App\Actions\GuessAction')
		);
		$dispatcher->setObject(
				   'GetMatchAction',
					   $di->lazyNew('App\Actions\GetMatchAction')
		);
		$dispatcher->setObject(
				   'MatchGuessAction',
					   $di->lazyNew('App\Actions\MatchGuessAction')
		);
	}

	private function setMappers(Container $di){
		$di->set('MatchMapper', $di->lazyNew('App\Mappers\MatchMapper'));
		$di->set('UserScoreMapper', $di->lazyNew('App\Mappers\UserScoreMapper'));
	}
}
