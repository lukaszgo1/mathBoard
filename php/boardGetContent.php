<?php
function getBoardContent($name)
	{
	require_once "db_connect.php";
	$cnt=dbCreateConnection();
	$sql = "SELECT Content FROM Boards WHERE boardName = ?";
		if($stmt = $cnt->prepare($sql))
			{
			$stmt->bind_param("s", $param_boardName);
			$param_boardName = $name;
			if($stmt->execute())
				{
				$stmt->store_result(); // work around for https://bugs.php.net/bug.php?id=47928.
				$stmt->bind_result($cont);
				$stmt->fetch();
				$stmt->close();
				$cnt->close();
				}
			}
	return $cont;
	}
if($_SERVER["REQUEST_METHOD"] == "POST")
	{
	$newContent = getBoardContent($_POST["boardName"]);
	echo $newContent;
	exit;
	}
?>