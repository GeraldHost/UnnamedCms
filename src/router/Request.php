<?php 
namespace Cms\Src\Router;

class Request {

	public function getParams()
	{
		switch($this->getMethod()) {
			case 'GET' : 
				$params = $_GET;
				break;
			case 'POST' :
				$params = $_POST;
				break;
			case 'PUT' :
			case 'DELETE' :
				parse_str(file_get_contents("php://input"), $data);
				$params = $data;
				break;
		}

		return $params;
	}

	public function getParam(
		$name)
	{
		if(!$this->params){
			$this->params = $this->getParams();
		}
		return isset($this->params[$name]) ? $this->params[$name] : "";
	}

	public function getUri()
	{
		$uri = empty($_GET['url']) ? '' : $_GET['url'];
		return rtrim($uri, '/');
	}

	public function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	public function getCookies()
	{
		return $_COOKIES;
	}

	public function getCookie(
		$name)
	{
		$cookies = $this->getCookies();
		return $cookies[$name] ?: false;
	}

}