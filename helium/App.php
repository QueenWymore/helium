<?php


namespace Helium;
use Helium\Exception\NotFoundException;


require_once(__DIR__ . '/../vendor/autoload.php');


class App
{
	private $controller;
	protected $debug;

	public function __construct()
	{
		$this->request = new Request();
		$this->router = new Router();
		$this->debug = 0;
	}

	public function setDebug($debug){
		$this->debug = $debug;
	}

	public function get($uri, $action)
	{
		$this->router->addRoute($uri, $action, 'GET');
	}

	public function post($uri, $action)
	{
		$this->router->addRoute($uri, $action, 'POST');
	}

	public function put($uri, $action)
	{
		$this->router->addRoute($uri, $action, 'PUT');
	}

	public function resource($name)
	{
		$this->router->addResource($name);
	}

	public function run()
	{
		$this->setDebugOptions();

		$route = $this->router->match($this->request);

		if (is_callable($route->getAction())){
			call_user_func_array($route->getAction(), $route->getParams());
		} else {
			$class = explode(':', $route->getAction())[0];
			$method = explode(':', $route->getAction())[1];
			$obj = new $class();
			$params = $route->getParams();
			if (method_exists($obj, $method)){
				call_user_func_array([$obj, $method], $params);
			}
		}
	}

	protected function setDebugOptions(){
		if ($this->debug){
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
		}
	}
}
