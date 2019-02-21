<?php
namespace Cms\Src\Delivery;

use \Exception;
use Cms\Src\Database\Connection;

class Client {

	function __construct(Connection $connection, Entry $entry)
	{
		$this->connection = $connection;
		$this->entry = $entry;
	}

	public function getEntries($model = false)
	{	
		$params = [];
		$query = "SELECT entries.id, entries.uid, models.name AS model FROM entries JOIN models ON models.ID = entries.model_id";
		if($model){
			$query .= " WHERE models.name = :name";
			$params = ['name' => $model];
		}
		$this->connection->query($query);
		return $entries = $this->connection->resultSet($params);
	}
	
	public function getEntry($id)
	{
		return $this->entry->get($id);
	}

}