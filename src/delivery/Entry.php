<?php
namespace Cms\Src\Delivery;

use \Exception;
use Cms\Src\Database\Connection;
use Cms\Src\Cms;

class Entry {

	public $connection;
	
	public $cms;

	public $entry;

	public $fields;

	function __construct(Connection $connection, Cms $cms)
	{
		$this->connection = $connection;
		$this->cms = $cms;
	}

	public function create()
	{
		// create entry field
	}

	public function get($id)
	{
		// get entry
		$query = "SELECT entries.id, entries.uid, models.name AS model FROM entries JOIN models ON models.ID = entries.model_id WHERE entries.ID = :id";
		$this->connection->query($query);
		$this->entry = $this->connection->single(['id' => $id]);

		if(!$this->connection->rowCount()){
			throw new Exception("Entry id:$id not found");
		}
		
		// get fields
		$query = "SELECT * FROM content WHERE entry_id = :id";
		$this->connection->query($query);
		$fields = $this->connection->resultSet(['id' => $id]);

		//map fields
		$map = [];
		foreach($fields as $field){
			$field_name = $field['field_name'];
			$field_data = $field['data'];

			$this->entry['fields'][$field_name] = $field_data;
			$map[$field_name] = $field_data;
		}
		$this->map($map);

		return $this->entry;
	}

	public function save()
	{
		$entryId = $this->entry['id'];

		foreach($this->fields as $key => $value){
			// check if the row already exists
			$select = "SELECT * FROM content WHERE entry_id = :id AND field_name = :field_name";
			$this->connection->query($select);
			$resp = $this->connection->resultSet([
				'field_name' => $key, 
				'id' => $entryId,
			]);

			if($this->connection->rowCount()){
				// update
				$query = "UPDATE content SET data = :value WHERE entry_id = :id AND field_name = :field_name";
			} else {
				// insert
				$query = "INSERT INTO content (entry_id, data, field_name) VALUES (:id, :value, :field_name)";
			}

			$this->connection->query($query);
			$resp = $this->connection->execute([
				'value' => $value,
				'id' => $entryId,
				'field_name' => $key,
			]);
		}
	}

	public function delete()
	{
		// delete entry

		// delete content
	}

	public function map(Array $data)
	{
		foreach($data as $key => $value){
			$this->fields[$key] = $value;
		}
	}

	public function __get($name)
	{
		if( !isset($this->fields[$name]) ){
			throw new Exception("Entry: cannot get property $name. field not found");
		}

		return $this->fields[$name];
	}

	public function __set($name, $value)
	{
		// check if the field is registered with the model
		if( !isset($this->cms->getModels()[$this->entry['model']]['fields'][$name]) ){
			throw new Exception("Entry: cannot set property $name. field not valid");	
		}

		return $this->fields[$name] = $value;
	}

}