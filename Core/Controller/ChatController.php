<?php

include $_SERVER['DOCUMENT_ROOT'] . "/chatBinario/Core/Classes/Autoloader.php";
include $_SERVER['DOCUMENT_ROOT'] . "/chatBinario/Core/Model/ChatModel.php";

$response = new Responses();
$validator = new Validators();

if (!isset($_POST['action'])	)
{
	$response->sendResponseAndDie("Invalid Action");
}

$option = $_POST['action'];

switch($option)
{	
	case "create-chat":

		$chatData = array(
			"name" => $_POST['name'],
			"password" => $_POST['pass']
		);

		if ($validator->isEmpty($chatData)) return;

		$chat = new ChatModel();

		if($chat->createChatRoom($chatData))
		{
			$response->sendResponse(array("created" => true, "password" => $_POST['pass']));
		}

		break;

	case "see-chat-rooms":
		$chat = new ChatModel();

		$creatorID = empty($_SESSION['CURRENT_USER_SESSION']) ? die() : $_SESSION['CURRENT_USER_SESSION'];

		$response->sendResponse($chat->getChatRooms($creatorID));

		break;

	case "delete-chat-room":
		$chat = new ChatModel();

		$idChat = (empty($_POST['id'])) ? null : $_POST['id'];

		if($chat->deleteChat($idChat))
		{
			$response->sendResponse(array("deleted" => true));
		}	

		break;

	default:
		break;
}	

?>