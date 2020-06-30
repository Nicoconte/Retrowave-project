<?php

session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/chatBinario/Core/Classes/Autoloader.php";

class ChatModel extends Validators
{

	protected $chatPassword = "";

	public function createChatRoom($chatData)
	{	

		$created = false;

		$db = new Database();
		$conn = $db->getConnection();
		$query = "INSERT INTO Chat_room VALUES (?,?,?,?,?)";

		$hash = new Hash();
		$this->chatPassword = $hash->setHash($chatData['password']);  		

		$chatId = $hash->generateHashId();
		$chatCreatorId = $_SESSION['CURRENT_USER_SESSION'];

		$chatDate = date("Y/m/d");

		if($this->databaseFail($conn, $query)) return;

		$stmt = mysqli_prepare($conn, $query);

		//Chat_id 	Chat_creator_id 	Chat_name 	Chat_password 	Chat_date 	
		mysqli_stmt_bind_param($stmt, "sssss", $chatId, $chatCreatorId, $chatData['name'], $this->chatPassword, $chatDate);

		$created = mysqli_execute($stmt);

 		mysqli_stmt_close($stmt);

 		mysqli_close($conn);

		return $created;

	}


	public function getChatRooms($creatorID)
	{
		$chatResponse = array();

		$db = new Database();
		$conn = $db->getConnection();
		$query="SELECT users.User_name, chat_room.Chat_name, chat_room.Chat_date, chat_room.Chat_id 
				FROM chat_room 
				INNER JOIN users 
				ON chat_room.Chat_creator_id=users.User_id
				WHERE chat_room.Chat_creator_id=? ";

		if($this->databaseFail($conn, $query)) return;

		//$creatorID = $_SESSION['CURRENT_USER_SESSION'];

		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "s", $creatorID);
		mysqli_stmt_execute($stmt);

		$rs = mysqli_stmt_get_result($stmt);

		while ($row = mysqli_fetch_assoc($rs))
		{
			$chatResponse[] = array(
				"chat_id" => $row['Chat_id'],
				"u_name" => $row['User_name'],
				"name" => $row['Chat_name'],
				"date" => $row['Chat_date']
			);
		}


		mysqli_stmt_free_result($stmt);
		mysqli_stmt_close($stmt);
		mysqli_close($conn);

		return $chatResponse;
	}


	public function deleteChat($id)
	{

		$deleted = false;

		$db = new Database();
		$conn = $db->getConnection();
		$query = "DELETE FROM chat_room WHERE Chat_id=?";
	
		if($this->databaseFail($conn, $query)) return;

		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "s", $id);

		$deleted = mysqli_execute($stmt);


		mysqli_stmt_close($stmt);
		mysqli_close($conn);

		return $deleted;

	}
	
}

?>