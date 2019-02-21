<?php
namespace Cms\Src;

use ReflectionClass;
use ReflectionParameter;
use Exception;

class Container {
	
	/**
	*	Make class
	*	
	*	@param <mixed> abstract
	*	@param <array> paramterers
	*/
	public function make($abstract, $parameters = [])
	{
		return $this->resolve($abstract, $parameters);
	}

	/**
	*	Resolve Abstract
	*	
	*	@param <mixed> abstract
	*	@param <array> paramterers
	*/
	public function resolve($abstract, $parameters)
	{
		// check if the instance is already being managed by the container
		// if it already exists then return the current instance rather than
		// create a new one
		if(isset($this->instance[$abstract])){
			return $this->instance[$abstract];
		}
		
		$object = $this->build($abstract);

		$this->instance[$abstract] = $object;

		return $object;
	}

	/**
	*	Build Instance of Class
	*	
	*	@param <concrete>
	*/
	public function build($concrete)
	{
		$reflector = new ReflectionClass($concrete);

		if (! $reflector->isInstantiable()) {
            throw new Exception('You are trying to build a instantiable object');
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();

        $instances = $this->resolveDependencies($dependencies);
        return $reflector->newInstanceArgs($instances);
	}

	/**
	*	Resolve Class Dependencies
	*	
	*	@param <mixed> dependencies
	*/
	public function resolveDependencies(
		$dependencies)
	{
		$resp = [];
		foreach($dependencies as $dependency){	
			$resp[] = !is_null($dependency->getClass()) ?
				$this->resolveClass($dependency) :
				$this->resolvePrimitive($dependency);
		}
		return $resp;
	}

	/**
	*	Resolve Class
	*	
	*	@param <ReflectionParameter> dependency
	*/
	public function resolveClass(ReflectionParameter $dependency)
	{
		return $this->make($dependency->getClass()->name);
	}

	/**
	*	Resolve Primitive Class
	*	
	*	@param 	dependency
	*	@throws <Exception>
	*/
	public function resolvePrimitive($dependency)
	{
		if ($dependency->isDefaultValueAvailable()) {
            return $dependency->getDefaultValue();
        }
        
		throw new Exception('Trying to resolve primitive dependency');
	}

}