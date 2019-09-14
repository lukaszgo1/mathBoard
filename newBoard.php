<?php
$title = "mathBoard - Create a new board";
include "includes/header.php";
require_once "php/db_connect.php";
if((!isset($_SESSION["loggedin"])) || $_SESSION["loggedin"] === false)
	{
	header("location: index.php");
	exit;
	}
$cnt=dbCreateConnection();
$boardName = $boardNameError = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
	{
	if(empty(trim($_POST["boardName"])))
	{
		$boardNameError = "Please enter name of the new board.";
		}
	else
		{
		$sql = "SELECT id FROM Boards WHERE boardName = ?";
		if($stmt = $cnt->prepare($sql))
			{
			$stmt->bind_param("s", $param_boardName);
			$param_boardName = trim($_POST["boardName"]);
			if($stmt->execute())
				{
				$stmt->store_result();
				if($stmt->num_rows == 1)
					{
					$_SESSION['boardToOpen'] = $_POST['boardName'];
					header('location: php/boardEdit.php');
					exit;
					}
			else
				{
				$boardName = trim($_POST["boardName"]);
				}
			}
			else
				{
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		$stmt->close();
	}
	if(empty($boardNameError))
		{
		$sql = "INSERT INTO Boards (Owner, boardName) VALUES (?, ?)";
		if($stmt = $cnt->prepare($sql))
			{
			$ownerName = $_SESSION["username"];
			$stmt->bind_param("ss", $param_ownerName, $param_boardName);
			$param_ownerName = $ownerName;
			$param_boardName = $boardName;
			if($stmt->execute())
				{
				$_SESSION['boardToOpen'] = $_POST['boardName'];
				header("location: php/boardEdit.php");
				}
			else
				{
				echo "Something went wrong. Please try again later.";
				}
		}
		$stmt->close();
	}
		$cnt->close();
}
?>
<main>
		<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 mx-auto">
			<div class="card card-signin my-5">
				<div class="card-body">
					<p class="card-title text-center col-sm-10 h4">To create a new board enter its name below. If you've previously created board with the same name you would be able to edit it.</p>
						<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="register-form" method="post">
							<div class="form-group row">
								<label for="newBoardName"class="col-sm-2 col-form-label">Board name:</label>
							<div class="col-sm-10">
								<input type="text" id="newBoardName" class="form-control" required name="boardName" value="<?php echo $boardName; ?>">
								<div class = "errorMessage" role = "region" aria-live="polite"></div>
								<div class = "errorMessage_backend"> <?php echo (!empty($boardNameError)) ?  $boardNameError : ''; ?></div>
							</div>
							</div>
							<button class="btn btn-lg btn-primary btn-block col-sm-12" type="submit">Create</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		</div>
</main>
<?php
include "includes/footer.php"
?>