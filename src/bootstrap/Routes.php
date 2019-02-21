<?php 
namespace Cms\Src\Bootstrap;

use Cms\Src\Router\Router;
use Cms\Src\Cms;
use Cms\Src\Delivery\Client;

class Routes {

	function __construct(Router $router, Cms $cms, Client $client)
	{
		$this->client = $client;

		foreach($cms->getModels() as $key => $model){

			/* -----------------------------------------------------------
			*	GET: /<model>
			*  -----------------------------------------------------------
			*/
			$router->registerRoute("$key", 'get', function() use ($key, $model, $router){
				$router->res
					->setStatus('ok')
					->setMessage("$key endpoint")
					->setData($this->client->getEntries($key))
					->send();
			})->middleware('Json');

			/* -----------------------------------------------------------
			*	GET: /<model>/<entry_id>
			*  -----------------------------------------------------------
			*/
			$router->registerRoute("$key/(?<id>[0-9]*$)", 'get', function() use ($key, $model, $router){
				$router->res
					->setStatus('ok')
					->setMessage("Get single $key")
					->setData($this->client->entry->get($router->matches['id']))
					->send();
			})->middleware('Json');

			/* -----------------------------------------------------------
			*	PUT: /<model>/<entry_id>
			*  -----------------------------------------------------------
			*/
			$router->registerRoute("$key/(?<id>[0-9]*$)", 'put', function() use ($key, $model, $router){

				$this->client->entry->get($router->matches['id']);
				$params = $router->req->getParams();
				foreach($params as $_key => $value){
					$this->client->entry->{$_key} = $value;
				}
				$this->client->entry->save();

				$router->res
					->setStatus('ok')
					->setMessage("Update single $key")
					->setData([])
					->send();
			})->middleware('Json');

		}
	}

}