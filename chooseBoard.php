<?php
$title = "mathBoard - Open existing board";
include "includes/header.php";
require_once "php/db_connect.php";
$cnt=dbCreateConnection();
$boardName = $boardNameError = "";
$boardExists = 0;
if($_SERVER["REQUEST_METHOD"] == "POST")
	{
	if(empty(trim($_POST["boardName"])))
	{
		$boardNameError = "Please enter name of the board.";
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
					$boardExists = 1;
					}
			else
				{
				$boardName = trim($_POST["boardName"]);
				$boardNameError = "Board with this name doesn't exist";
				}
			}
			else
				{
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		$stmt->close();
	}
	if(empty($boardNameError) && $boardExists == 1)
		{
		$_SESSION['boardToOpen'] = $_POST['boardName'];
		if ($_POST["mode"] == "source")
			{
			header('location: php/boardViewSource.php');
			exit;
			}
		if ($_POST["mode"] == "rendered")
			{
			header('location: php/boardViewRendered.php');
			exit;
			}
		}
	}
?>
		<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 mx-auto">
			<div class="card card-signin my-5">
				<div class="card-body">
					<h2 class="card-title text-center col-sm-10 h4">To open an existing board enter its name, choose mode and click open.</h2>
						<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="register-form" method="post">
							<div class="form-group row">
								<label for="boardName"class="col-sm-2 col-form-label">Board name:</label>
							<div class="col-sm-10">
								<input type="text" id="boardName" class="form-control" required name="boardName" value="<?php echo $boardName; ?>">
								<div class = "errorMessage" role = "region" aria-live="polite"></div>
								<div class = "errorMessage_backend"> <?php echo (!empty($boardNameError)) ?  $boardNameError : ''; ?></div>
							</div>
							</div>
							<fieldset class="form-group">
								<div class="form-group row" role="group" aria-labelledby="desc">
								<legend class="col-form-label col-sm-2 pt-0" id = "desc">Choose mode:</legend>
								<div class="col-sm-10">
								<div class="form-check">
								<input class="form-check-input" type="radio" name="mode" id="modeL" value="source" checked>
								<label class="form-check-label" for="modeL">source</label>
								</div>
								<div class="form-check">
								<input class="form-check-input" type="radio" name="mode" id="modeM" value="rendered">
								<label class="form-check-label" for="modeM">compiled</label>
								</div>
								</div>
								</div>
								</fieldset>
								<button class="btn btn-lg btn-primary btn-block col-sm-12" type="submit">Open</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		</div>
<div class = "hidden" aria-hidden = "true"> </div>
<?php
include "includes/footer.php"
?>