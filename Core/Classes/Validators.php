<?php


class Validators extends Responses
{
	public function isEmpty($data) : bool
	{	
		$isEmpty = false;

		foreach($data as $value)
		{
			if (empty($value))
			{
				$isEmpty = true;
				break;
			}
		}

		return $isEmpty;
	}


	public function databaseFail($conn, $query)
	{	
		if(!$conn)
		{	
			$this->sendResponseAndDie(array("Error" => "Error with database"));
		}

		if(!mysqli_prepare($conn, $query))
		{
			$this->sendResponseAndDie(array("Error" => "Error with query"));
		}		
	}
}


?>