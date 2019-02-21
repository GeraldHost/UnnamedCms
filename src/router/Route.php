<?php
namespace Cms\Src\Router;

class Route {

	protected $uri;

	protected $regex;

	protected $http_method;

	protected $callback;

	protected $middleware = [];

	public function setUri($uri)
	{
		$this->uri = $uri;
		return $this;
	}
	
	public function getUri()
	{
		return $this->uri;
	}
	
	public function setRegex($regex)
	{
		$this->regex = $regex;
		return $this;
	}
	
	public function getRegex()
	{
		return $this->regex;
	}
	
	public function setHttpMethod($http_method)
	{
		$this->http_method = $http_method;
		return $this;
	}
	
	public function getHttpMethod()
	{
		return $this->http_method;
	}
	
	public function setCallback($callback)
	{
		$this->callback = $callback;
		return $this;
	}
	
	public function getCallback()
	{
		return $this->callback;
	}
	
	public function setMiddleware($middleware)
	{
		$this->middleware[] = $middleware;
		return $this;
	}
	
	public function getMiddleware()
	{
		return $this->middleware;
	}

	public function middleware($middleware)
	{
		if(is_string($middleware)){
			$class = "\\Cms\\Src\\Router\\Middleware\\$middleware";
			$middleware = new $class;
		}

		return $this->setMiddleware($middleware);
	}

}