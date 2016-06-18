<?php

namespace Helium;

use Helium\Exception\NotFoundException;

class Router
{

    protected $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routes = [];
        return $this;
    }

    public function addRoute($uri, $action, $method, $middleware = null)
    {
        $route = new Route($uri, $action, strtoupper($method), $middleware);
        if (!array_key_exists($method, $this->routes)){
            $this->routes[$method] = [];
        }
        $this->routes[$method][] = $route;

        return $this;
    }

    public function addResource($name, $controller = null)
    {
        if (!$controller) {
            $controller = ucfirst($name) . 'Controller';
        }
        $this->addRoute('/'.$name.'/:id', $controller.':show', 'GET');
        $this->addRoute('/'.$name, $controller.':index', 'GET');
        $this->addRoute('/'.$name, $controller.':create', 'POST');
        $this->addRoute('/'.$name.'/:id', $controller.':update', 'PUT');
        $this->addRoute('/'.$name.'/:id', $controller.':delete', 'DELETE');
    }

    /**
     * @param Http\Request $request
     * @return mixed
     * @throws NotFoundException
     */
    public function match(Http\Request $request)
    {
        foreach ($this->routes[$request->getHttpMethod()] as $route) {
            $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route->getUri())) . "$@D";
            $params = [];
            if (preg_match($pattern, $request->getPath(), $params)){
                array_shift($params);
                $route->setParams($params);
                return $route;
            }
        }
        throw new NotFoundException($request);
    }
}

