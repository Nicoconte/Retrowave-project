<?php
session_start();

include $_SERVER['DOCUMENT_ROOT'] . "/chatBinario/Core/Classes/Autoloader.php";

class UserModel extends Validators
{	

	protected $userPassword = "";

	public function registerUser($data)
	{	

		$success = null;

		$db = new Database();
		$conn = $db->getConnection();
 		$query = "INSERT INTO Users VALUES (?,?,?,?,?)";


 		$hash = new Hash();
 		$this->userPassword = $hash->setHash($data['password']);
		$id = $hash->generateHashId();

 		//In case if it fail, method will send an error message and then it´ll kill the script
 		if ($this->databaseFail($conn, $query)) return;

 		//In case if it not, script will go on
		$stmt = mysqli_prepare($conn, $query);

		mysqli_stmt_bind_param($stmt, "ssssi", $id, $data['email'], $data['name'], $this->userPassword, $data['active']);

		mysqli_execute($stmt);

 		mysqli_stmt_close($stmt);

 		mysqli_close($conn);

		return $success = true;
	}	


	//Llave pistola cuerda pollo de goma / 28.5 - 12

	public function userExist($name, $email)
	{
		$exist = false;

		$db = new Database();
		$conn = $db->getConnection();

 		$query = "SELECT User_name, User_email FROM Users WHERE (User_name=? or User_email=?) LIMIT 1";

 		if ($this->databaseFail($conn, $query)) return;

 		$stmt = mysqli_prepare($conn, $query);

 		mysqli_stmt_bind_param($stmt, "ss", $name, $email);

 		mysqli_execute($stmt);

 		//Store the result and then ask for rows
 		mysqli_stmt_store_result($stmt);

 		if (mysqli_stmt_num_rows($stmt) > 0)
 		{
 			$exist = true;
 		}


 		//Free result in memory and close it
 		mysqli_stmt_free_result($stmt);
 		mysqli_stmt_close($stmt);

		mysqli_close($conn);

 		return $exist;
				
	}

	public function getLogin($data)
	{

		$_SESSION['CURRENT_USER_SESSION'] = null;

		$access = false;

		$db = new Database();
		$conn = $db->getConnection();

		$hash = new Hash();
		$this->userPassword = $hash->setHash($data['pass']);

		$query = "SELECT User_id FROM users WHERE (User_name=? and User_password=?) LIMIT 1";

		if($this->databaseFail($conn, $query)) return;

		$stmt = mysqli_prepare($conn, $query);
		mysqli_stmt_bind_param($stmt, "ss", $data['name'], $this->userPassword);
		mysqli_stmt_execute($stmt);
		$rs = mysqli_stmt_get_result($stmt);
		
		$row = mysqli_fetch_assoc($rs); 	

		if (mysqli_num_rows($rs) > 0)
		{	

			$_SESSION['CURRENT_USER_SESSION'] = $row['User_id'];
			$access = true;
		}


 		mysqli_stmt_free_result($stmt);
 		mysqli_stmt_close($stmt);

		mysqli_close($conn);
			

		return $access;

	}

}


?>