<?php


namespace Helium;
use Helium\Exception\MissingFileException;
use Symfony\Component\Config\Definition\Exception\Exception;

require_once '../app/Controllers/AppController.php';
require_once(__DIR__ . '/../vendor/autoload.php');


class App
{
    private $controller;
    protected $debug;
    private $route;

    public function __construct()
    {
        $this->request = new Http\Request();
        $this->router = new Router();
        $this->debug = 1;
    }

    public function setDebug($debug){
        $this->debug = $debug;
    }

    public function get($uri, $action, $middleware = null)
    {
        $this->router->addRoute($uri, $action, 'GET', $middleware);
    }

    public function post($uri, $action, $middleware = null)
    {
        $this->router->addRoute($uri, $action, 'POST', $middleware);
    }

    public function put($uri, $action, $middleware = null)
    {
        $this->router->addRoute($uri, $action, 'PUT', $middleware);
    }

    public function resource($name, $controller = null)
    {
        $this->router->addResource($name, $controller);
    }

    public function run()
    {
        try {
            $this->setDebugOptions();

            $this->route = $this->router->match($this->request);

            $middlewareClass =  $this->route->getMiddleware();

            if ($middlewareClass){
                $middleware_path = __DIR__ . '/../app/Middlewares/' . $middlewareClass . '.php';
                if (!file_exists($middleware_path)){
                    throw new MissingFileException($middleware_path);
                }
                require_once $middleware_path;
                $middleware = new $middlewareClass();
                if (method_exists($middleware, 'before')){
                    if (!$middleware->before()){
                        throw new \Exception('nope');
                    }
                }
            }

            if (is_callable($this->route->getAction())) {
                call_user_func_array($this->route->getAction(), $this->route->getParams());
            } else {
                $class = $this->route->getClass();
                $method = $this->route->getMethod();
                $path = __DIR__ . '/../app/Controllers/' . $class . '.php';
                if (!file_exists($path)) {
                    throw new MissingFileException($path);
                }
                require_once $path;
                $this->controller = new $class();
                $params = $this->route->getParams();
                if (method_exists($this->controller, $method)) {
                    call_user_func_array([$this->controller, $method], $params);
                }
            }
        }
        catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    public function getRoute()
    {
        return $this->route;
    }

    protected function setDebugOptions(){
        if ($this->debug){
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }
}
