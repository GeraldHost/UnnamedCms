<?php
namespace Cms\Src\Router\Middleware;

use Cms\Src\Router\Request;
use Cms\Src\Router\Response;

class Json {

	function __invoke(Request $req, Response $res)
	{
		$res->setHeader("Content-Type", "application/json");
	}

}