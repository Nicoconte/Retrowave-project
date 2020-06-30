<?php


class Responses
{
	public function sendResponseAndDie($msg)
	{
		echo die(json_encode($msg));
	}

	public function sendResponse($msg)
	{
		echo json_encode($msg);
	}
}


?>