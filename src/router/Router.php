<?php
namespace Cms\Src\Router;

use Closure;
use Cms\Src\Container;

class Router {

	public $routes;

	/**
	*	Router Constructor
	*/
	function __construct(Container $container, Request $req, Response $res)
	{
		$this->app = $container;
		$this->req = $req;
		$this->res = $res;
	}

	public function registerRoute($uri, $http_method, $callback)
	{
		$http_method = strtoupper($http_method);

		if(!isset($this->routes[$http_method])){
			$this->routes[$http_method] = [];
		}

		// @TODO create route object that can be returned
		$route = (new Route)
			->setUri($uri)
			->setRegex($this->buildRegex($uri))
			->setHttpMethod($http_method)
			->setCallback($callback);

		$this->routes[$http_method][] = $route;

		return $last_inserted = end($this->routes[$http_method]);
	}

	public function buildRegex($uri)
	{
		// get name
		$name = preg_match('/{(?<name>[0-9A-Za-z]*)}/', $uri, $matches);
		$name = isset($matches['name']) ? $matches['name'] : '';

		// make regex
		$regex = preg_replace('/{[0-9A-Za-z]*}/', "(?<$name>[0-9A-Za-z]*)", $uri);
		return $regex = str_replace('/', '\/', $regex);
	}

	/**
	*	Get Registered Routes
	*
	*	@return array routes
	*/
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	*	Match Routes
	*
	*	@return mixed string:key|null
	*/
	public function matchRoutes()
	{
		$uri = $this->req->getUri();
		$routes = $this->getRoutes()[$this->req->getMethod()];
		
		if(!$routes){
			throw new \Exception('Route not found', 404);
		}
		
		foreach($routes as $key => $route){
			$regex = $route->getRegex();
			if(preg_match("/^$regex$/", $uri, $this->matches)){
				return $key;
			}
		}
	}

	/**
	*	Resolve Closure
	*/
	protected function resolveClosure(Closure $closure)
	{
		return $closure;
	}

	/**
	*	Resolve Controller
	*/
	protected function resolveController($callback)
	{
		$callback = explode(':', $callback);
		$controller = $callback[0];
		$method = $callback[1];

		return [$this->app->make("Cms\\Src\\Router\\Middleware\\$controller"), $method];
	}

	/**
	*	Resolve Callback
	*/
	public function resolveCallback($callback)
	{
		if($callback instanceof Closure){
			return $this->resolveClosure($callback);
		}

		return $this->resolveController($callback);
	}

	/**
	*	Dispatch Router	
	*
	*	@throws Exception
	*/
	public function dispatch()
	{
		try{
			$key = $this->matchRoutes();

			if(is_null($key)){
				throw new \Exception('Route not found');
			}

			$route = $this->getRoutes()[$this->req->getMethod()][$key];
			$callback = $route->getCallback();

			$middlewares = $route->getMiddleware();

			// add default middleware
			$middlewares[] = new Middleware\Option;

			foreach($middlewares as $middleware){
				if(is_callable($middleware)){
					$middleware($this->req, $this->res);
				}
			}

			call_user_func($this->resolveCallback($callback), $this->req, $this->res);
		} catch(\Exception $e){
			$this->res->setHeader("Content-Type", "application/json");
			$this->res->setStatus('fail')->setCode(404)->setMessage($e->getMessage())->send();
		}
	}

}