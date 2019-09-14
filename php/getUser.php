<?php
require_once "db_connect.php";
$cnt=dbCreateConnection();
$userName =$userPassword =$userConfirmPassword = $userNameError =$userPasswordError =$userConfirmPasswordError = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
	{
	$sql = "SELECT id FROM users WHERE user_name = ?";
	if($stmt = $cnt->prepare($sql))
		{
		$stmt->bind_param("s", $param_username);
		$param_username = trim($_POST["username"]);
		if($stmt->execute())
			{
			$stmt->store_result();
			if($stmt->num_rows == 1)
				{
				echo ('1');
				}
			else
				{
				echo ('0');
				}
			}	
			else
				{
				echo ('0');
				}
		}
		$stmt->close();
	}
$cnt->close();
exit;
?>