<?php

namespace Helium;

class Route
{
    const SEPARATOR = ':';
    protected $uri;
    protected $action;
    protected $class;
    protected $method;
    protected $params;
    protected $httpMethod;
    protected $middleware;

    public function __construct($uri, $action, $httpMethod, $middleware)
    {
        $this->uri = $uri;
        $this->action = $action;
        if (is_string($action) && strpos($action, self::SEPARATOR) !== false){
            $actionArr = explode(':', $action);
            $this->class = $actionArr[0];
            $this->method = $actionArr[1];
        }
        $this->httpMethod = $httpMethod;
        $this->middleware = $middleware?ucfirst($middleware).'Middleware':false;
        $this->params = [];
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function addParam($param)
    {
        array_push($this->params, $param);
    }

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }
}