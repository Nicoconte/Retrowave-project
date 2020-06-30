<?php

include $_SERVER['DOCUMENT_ROOT'] . "/chatBinario/Core/Classes/Autoloader.php";
include $_SERVER['DOCUMENT_ROOT'] . "/chatBinario/Core/Model/UserModel.php";

$validator = new Validators();
$response = new Responses();


if(!isset($_POST['action']))
{
	$response->sendResponseAndDie(array("Error" => "Invalid Action"));
}

switch($_POST['action'])
{
	case "register":	
	
		$data = array( 
			"email" => $_POST['email'],
			"name" => $_POST['name'],
			"password" => $_POST['pass'],
			"active" => 1
		);


		$user = new UserModel();

		if ($validator->isEmpty($data)) return;
		
		if ($user->userExist($data['name'], $data['email']))
		{
			$response->sendResponseAndDie(array("success" => 0));
		}

		if($user->registerUser($data))
		{
			$response->sendResponse(array("success" => 1));
		}

		break;

	//User_name = 'admin' AND '1' = '1' #'

	case "login":

		$loginData = array(
			"name" => $_POST['name'],
			"pass" => $_POST['pass']
		);

		$user = new UserModel();

		if($validator->isEmpty($loginData)) return;

		if($user->getLogin($loginData))
		{
			$response->sendResponse(array("access" => true));
		}
		else
		{
			$response->sendResponse(array("access" => false));
		}

		break;

	case "active-user":

		if(empty($_SESSION['CURRENT_USER_SESSION']))	
		{
			$response->sendResponse(array("active" => false));
			die();
		}
		else
		{
			$response->sendResponse(array("active" => true));
		}

		break; 

	case "logout":
		unset($_SESSION['CURRENT_USER_SESSION']);
		session_destroy();
		$response->sendResponse(array("logout" => true));
		break;

	default:
		break;
}

?>