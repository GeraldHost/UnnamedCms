<?php 
namespace Cms\Src\Router;

class Response {

	protected $status;

	protected $code;

	protected $message;

	protected $errors = [];

	protected $data;

	protected static $json_options = JSON_PRETTY_PRINT;

	public function setStatus($status)
	{
		$this->status = $status;
		return $this;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setCode($code)
	{
		$this->code = $code;
		return $this;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function setMessage($message)
	{
		$this->message = $message;
		return $this;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function setError($error)
	{
		$this->errors[] = $error;
		return $this;
	}

	public function getError()
	{
		return $this->error;
	}

	public function setData(Array $data)
	{
		$this->data = $data;
		return $this;
	}

	public function getData()
	{
		return $this->data;
	}

	public function send()
	{
		$res = [];
		$res['status'] = $this->getStatus() ?: 'fail';
		$res['code'] = $this->getCode() ?: 404;
		
		if($message = $this->getMessage())
			$res['message'] = $message;

		if($data = $this->getData())
			$res['data'] = $data;

		echo json_encode($res, static::$json_options);
		return;
	}

	public function	setHeader($key, $value)
	{
		header($key . ': ' . $value);
	}

}