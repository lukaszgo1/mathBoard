<?php
$title = "mathBoard - login to the site";
include "includes/header.php";
require_once "php/db_connect.php";
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
	{
	header("location: index.php");
	exit;
	}
$cnt=dbCreateConnection(); 
$username = $password = $error = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
	{
	if(empty(trim($_POST["username"])))
		{
		$error= "User name or password is incorrect.";
		}
	else
		{
		$username = trim($_POST["username"]);
		}
	if(empty(trim($_POST["password"])))
		{
		$error = "User name or password is incorrect.";
		}
	else
		{
		$password = trim($_POST["password"]);
	}
	if(empty($error) )
		{
		$sql = "SELECT id, user_name, user_password FROM users WHERE user_name = ?";
		if($stmt = $cnt->prepare($sql))
			{
			$stmt->bind_param("s", $param_username);
			$param_username = $username;
			if($stmt->execute())
				{
				$stmt->store_result();
				if($stmt->num_rows == 1)
					{
					$stmt->bind_result($id, $username, $hashed_password);
					if($stmt->fetch())
						{
						if(password_verify($password, $hashed_password))
							{
// 							session_start();
							$_SESSION["loggedin"] = true;
							$_SESSION["id"] = $id;
							$_SESSION["username"] = $username;
							header("location: index.php");
							}
						else
							{
							$error = "User name or password is incorrect.";
						}
					}
				}
			else
					{
					$error = "User name or password is incorrect.";
					}
				}
					else
						{
						echo "Oops! Something went wrong. Please try again later.";
						}
				}
		$stmt->close();
	}
	$cnt->close();
}
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-6 mx-auto">
			<div class="card card-signin my-5">
				<div class="card-body">
					<h2 class="card-title text-center">Sign in</h2>
					<p class="card-text">To create a new board login below.</p>
					<p class="card-text"> If you don't have an account <a href="register.php">create one!</a></p>
						<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="login-form" method="post">
						<div class = "errorMessage_backend" > <?php echo (!empty($error)) ? $error : ''; ?> </div>
							<div class="form-group row">
								<label for="inputUserName"class="col-sm-4 col-form-label">User name:</label>
							<div class="col-sm-8">
								<input type="text" id="inputUserName" class="form-control" name="username" value="<?php echo $username; ?>" required>
								<div class = "errorMessage" role = "region" aria-live="polite"></div>	
							</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label" for="inputPassword">Password:</label>
							<div class="col-sm-8">
								<input type="password" id="password" class="form-control" name = "password" required>
								<div class = "errorMessage" role = "region" aria-live="polite"></div>
							</div>
							</div>
							<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		</div>

<?php
include "includes/footer.php"
?>