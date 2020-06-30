<?php

include $_SERVER['DOCUMENT_ROOT'] . "/chatBinario/Core/Classes/Autoloader.php";
include $_SERVER['DOCUMENT_ROOT'] . "/chatBinario/Core/Model/MessageModel.php";

$response = new Responses();

if (!isset($_POST['action'])	)
{
	$response->sendResponseAndDie("Error al traducir");
}

$option = $_POST['action'];

switch($option)
{	
	case "save-msg":

		if (isset($_POST['message']))
		{	
			$message = new MessageModel();
			//$userId, $chatId, $msg
			$message->saveMessage("1", "3", $_POST['message']);
		}

		break;
	default:
		break;
}

?>