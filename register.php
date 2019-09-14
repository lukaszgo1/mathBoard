<?php
$title = "mathBoard - create account";
include "includes/header.php";
require_once "php/db_connect.php";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
	{
	header("location: index.php");
	exit;
	}
$cnt=dbCreateConnection();
$userName =$userPassword =$userConfirmPassword = $userNameError =$userPasswordError =$userConfirmPasswordError = "";
if($_SERVER["REQUEST_METHOD"] == "POST")
	{
	if(empty(trim($_POST["username"])))
		{
		$userNameError = "Please enter a username.";
		}
	elseif(strlen(trim($_POST["username"])) < 6)
		{
		$userNameError = "Username is to short. At least 6 characters.";
		}
	else
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
					$userNameError = "This username is already taken.";
					$userName = trim($_POST["username"]);
					}
				else
					{
					$userName = trim($_POST["username"]);
					}
				}
			else
				{
				echo "Oops! Something went wrong. Please try again later.";
				}
		}
		$stmt->close();
	}
			if(empty(trim($_POST["password"])))
				{
				$userPasswordError = "Please enter a password.";
				}
			elseif(strlen(trim($_POST["password"])) < 8)
				{
				$password_err = "Password must have atleast 8 characters.";
				}
			else
				{
				$userPassword = trim($_POST["password"]);
				}
	if(empty(trim($_POST["confirm_password"])))
		{
		$userConfirmPasswordError= "Please confirm password.";
		}
	else
		{
		$userConfirmPassword = trim($_POST["confirm_password"]);
		if(empty($userPasswordError) && ($userPassword != $userConfirmPassword))
			{
			$userConfirmPasswordError= "Password did not match.";
			}
	}
	

	if(empty($userNameError) && empty($userPasswordError) && empty($userConfirmPasswordError))
		{
		$sql = "INSERT INTO users (user_name, user_password) VALUES (?, ?)";
		if($stmt = $cnt->prepare($sql))
			{
			$stmt->bind_param("ss", $param_username, $param_password);
			$param_username = $userName;
			$param_password = password_hash($userPassword, PASSWORD_DEFAULT);
			if($stmt->execute())
				{
				header("location: login.php");
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
		<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 mx-auto">
			<div class="card card-signin my-5">
				<div class="card-body">
					<h2 class="card-title text-center col-sm-10">Register</h2>
						<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="register-form" method="post">
							<div class="form-group row">
								<label for="registerUsername"class="col-sm-2 col-form-label">User name:</label>
							<div class="col-sm-10">
								<input type="text" id="registerUsername" class="form-control" required name="username" value="<?php echo $userName; ?>">
								<div class = "errorMessage" role = "region" aria-live="polite"></div>
								<div class = "errorMessage_backend"> <?php echo (!empty($userNameError)) ?  $userNameError : ''; ?></div>
							</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label" for="typePassword">Password:</label>
							<div class="col-sm-10">
								<input type="password" id="typePassword" class="form-control"  required name="password">
								<div>Password must consist of at least 8 characters, one capital letter and one number</div>
								<div class = "errorMessage" role = "region" aria-live="polite"></div>
								<div class = "errorMessage_backend"> <?php echo (!empty($userPasswordError)) ? $userPasswordError : ''; ?></div>
							</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-2 col-form-label" for="retypePassword">Password again:</label>
							<div class="col-sm-10">
								<input type="password" id="retypePassword" class="form-control"  required name="confirm_password">
								<div class = "errorMessage" role = "region" aria-live="polite"></div>
								<div class = "errorMessage_backend"> <?php echo (!empty($userConfirmPassword)) ? $userConfirmPasswordError : ''; ?></div>
							</div>
							</div>
							<button class="btn btn-lg btn-primary btn-block col-sm-12" type="submit">Register</button>
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