<?php

namespace Helium\Http;


class Request
{
  protected $path;
  protected $base_path;
  protected $call_parts;
  protected $httpMethod;
  protected $params;

  public function __construct()
  {
    if (isset($_SERVER['REQUEST_URI'])) {
      $request_path = explode('?', $_SERVER['REQUEST_URI']);
      $this->path = $request_path[0];
      $this->call_parts = explode('/', $this->path);
      array_shift($this->call_parts);
    }
    $this->httpMethod = $_SERVER['REQUEST_METHOD'];

    $this->params = ['get' => $_GET, 'post' => $_POST];

  }

  public function getCallParts()
  {
    return $this->call_parts;
  }

  public function getPath(){
    return $this->path;
  }

  public function getHttpMethod()
  {
    return $this->httpMethod;
  }
 
}