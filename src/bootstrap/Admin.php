<?php 
namespace Cms\Src\Bootstrap;

use Cms\Src\Router\Router;
use Cms\Src\Cms;
use Cms\Src\Delivery\Client;

class Admin {

	function __construct(Router $router, Cms $cms, Client $client)
	{
		/* -----------------------------------------------------------
		*	GET: /admin
		*  -----------------------------------------------------------
		*/
		$router->registerRoute("admin", 'get', function() use ($router, $client){
			$entries = $client->getEntries();
			require __DIR__ . '/../templates/admin.php';
		});

		/* -----------------------------------------------------------
		*	GET: /admin/model
		*  -----------------------------------------------------------
		*/
		$router->registerRoute("admin/(?<model>[-a-zA-Z0-9@:%._\+~#=]*)$", 'get', function() use ($router, $client){
			$model = $router->matches['model'];
			$entries = $client->getEntries($model);
			require __DIR__ . '/../templates/admin-model.php';
		});

		/* -----------------------------------------------------------
		*	GET: /admin/model/<id>
		*  -----------------------------------------------------------
		*/
		$router->registerRoute("admin/(?<model>[-a-zA-Z0-9@:%._\+~#=]*)/(?<entry_id>[0-9])$", 'get', function() use ($router, $client, $cms){
			$entryId = $router->matches['entry_id'];
			$entry = $client->getEntry($entryId);
			$contentModel = $cms->getModel($router->matches['model']);
			require __DIR__ . '/../templates/admin-single.php';
		});
	}

}