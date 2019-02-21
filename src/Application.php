<?php
namespace Cms\Src;

class Application extends Container {

	protected $bootstrappers = [
		\Cms\Src\Bootstrap\Routes::class,
		\Cms\Src\Bootstrap\Admin::class
	];

	public function bootstrap()
	{
		foreach($this->getBootstrappers() as $bootstrap){
			$class = $this->make($bootstrap);
		}
	}

	public function getBootstrappers()
	{
		return $this->bootstrappers;
	}

}