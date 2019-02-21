<?php
namespace Cms\Src\Database;

use PDO;
use Exception;

class Connection {
	
	/**
	*	Connection constructor
	*/
	public function __construct() 
	{
		$host = getenv('DBhost');
		$db = getenv('DBname');
		$user = getenv('DBuser');
		$pass = getenv('DBpass');
		
		try{
			$this->conn = new PDO('mysql:host='.$host.';dbname='.$db.';',$user, $pass);
		} catch(Exception $e){
			die('Database connection failed - ' . $e->getMessage());
		}
	}

	/**
	*	Build Query
	*
	*	@param 	<string> query
	*	@return <void>
	*/
	public function query(
		$query)
	{
		$this->query = $query;
		$this->stmt = $this->conn->prepare($query);
	}

	/**
	* 	Execute query
	*
	*	@param 	<array> bindings
	*	@return <bool>
	*/
	public function execute(
		Array $array)
	{
		$this->params = $array;
		return $this->stmt->execute($array);
	}

	/**
	*	Get result set
	*
	*	@param 	<array> bindings
	*	@return <array> results
	*/
	public function resultset(
		Array $array)
	{
		$this->params = $array;
		$this->execute($array);
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	*	Get single result
	*
	*	@param 	<array> bindings
	*	@return <array> result
	*/
	public function single(
		Array $array)
	{
		$this->params = $array;
		$this->execute($array);
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	/**
	*	Get row count
	*
	*	@return <string> count
	*/
	public function rowCount()
	{
		return $this->stmt->rowCount();
	}

	/**
	*	Emulate Complete Query String
	*
	*	@return <string> query
	*/
	public function emulateQuery()
	{
		foreach($this->params as $key => $value){
			$this->query = preg_replace('/:' . $key . '/', $value, $this->query);
		}
		return $this->query;
	}

}