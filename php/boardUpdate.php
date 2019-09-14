<?php
require_once "db_connect.php";
$cnt=dbCreateConnection();
if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$sql = "UPDATE   Boards SET Content = ? WHERE boardName = ?";
		if($stmt = $cnt->prepare($sql))
			{
			$stmt->bind_param("ss", $param_Content, $param_boardName);
			$param_boardName = trim($_POST["boardName"]);
			$param_Content = trim($_POST["Content"]);
			$stmt->execute();
		}
		$stmt->close();
	}
		$cnt->close();
?>