<?php

class Database
{

	private $user;
	private $host;
	private $password;
	private $database;

	public function getConnection()
	{

		$conn = mysqli_connect($this->host="localhost", $this->user="root", $this->password="", $this->database="binary_chat");

		if(!$conn)
		{
			die("No connection");
		}

		return $conn;
	}
}


?>