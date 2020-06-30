<?php

include $_SERVER['DOCUMENT_ROOT'] . "/chatBinario/Core/Classes/Autoloader.php";

$response = new Responses();

class MessageModel extends Validators
{

	public function saveMessage($userId, $chatId, $msg) 
	{	

		$db = new Database();
		$conn = $db->getConnection();
 		$query = "INSERT INTO message VALUES (?,?,?,?,?)";

 		$hash = new Hash();
 		$msgId = $hash->generateHashId();

 		$currentTime = date("H:i:s");

 		if($this->databaseFail($conn, $query)) return;

 		$stmt = mysqli_prepare($conn, $query);

 		mysqli_stmt_bind_param($stmt, "sssss", $msgId, $userId, $chatId, $msg, $currentTime);

 		mysqli_execute($stmt);

 		mysqli_stmt_close($stmt);

 		mysqli_close($conn);
			
	}

}


?>