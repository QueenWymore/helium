<?php

namespace Helium;

class Route
{
	protected $uri;
	protected $action;
	protected $params;
	protected $method;

	public function __construct($uri, $action, $method)
	{
		$this->uri = $uri;
		$this->action = $action;
		$this->method = $method;
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
}