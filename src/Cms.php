<?php
namespace Cms\Src;

use Closure;

class Cms {

	/**
	*	Model Array
	*
	*	@var <array>
	*/
	protected $models = [];

	/**
	*	Current Model Name
	*
	*	@var <string>
	*/
	protected $model;

	/**
	*	Add Model (Post Type)
	*
	*	@param 	<string> 	model name
	*	@param 	<closure> 	callback
	*	@return <void>
	*/
	public function add($name, Closure $callback)
	{
		// set current model name
		$this->model = $name;
		// set base model array
		$this->models[$name] = [];

		$callback();
	}

	/**
	*	Add Field 
	*
	*	@param 	<string> 	field name
	*	@param 	<Closure> 	filter callback
	*	@param 	<Closure> 	Ui callback
	*	@throws <Exception>
	*/
	public function field($name, Closure $filter, Closure $ui)
	{
		// is the model set
		if(empty($this->model)){
			throw new Exception('Current model not set');
		}

		// push the field array to the model
		$this->models[$this->model]['fields'][$name] = [
			'name' => $name,
			'filter' => $filter,
			'ui' => $ui,
		];
	}

	/**
	*	Get Models Array
	*
	*	@return <array> models
	*/
	public function getModels(): array
	{
		return $this->models;
	}

	/**
	*	Get Single Model Array
	*
	*	@return <array> models
	*/
	public function getModel($name): array
	{
		return $this->models[$name];
	}

}