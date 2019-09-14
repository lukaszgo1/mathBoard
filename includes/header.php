<?php
$author = "Łukasz Golonka";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta charset="utf-8">
<meta name="description" content="Math board using LaTeX." />
<meta name="author" content="<?php echo $author;?>">
<title> <?php echo $title; ?></title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-sm bg-secondary navbar-dark">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainmenu" aria-expanded="false" aria-label="toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-text-center" id = "mainmenu">
				<a class="nav-item nav-link text-light mx-auto" href = "index.php"><span class="fas fa-home mr-1"></span>Home page</a>
				<?php
					if((!isset($_SESSION["loggedin"])) || $_SESSION["loggedin"] == false)
						{
						echo '<a class="nav-item nav-link text-light mx-auto" href = "login.php"><span class = "fas fa-user mr-1"></span>Login/register</a>';
						}
				?>
				<a class = "nav-item nav-link text-light mx-auto" href = "chooseBoard.php"><span class="fas fa-chalkboard mr-1"></span>Open existing board</a>
				<a class="nav-item nav-link text-light mx-auto" href = "photoGallery.php"><span class="fas fa-images mr-1"></span>Photo gallery</a>
				<?php
					if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true)
						{
						echo '<a class="nav-item nav-link text-light mx-auto" href = "newBoard.php"><span class="fas fa-file mr-1"></span>Create new board</a>';
						echo '<p class = "nav navbar-text text-dark">Logged in as '.$_SESSION['username'].'</p>';
						echo '<a class="nav-item nav-link text-light mx-auto" href = "logout.php"><span class="fas fa-sign-out-alt mr-1"></span>Logout</a>';
						}
				?>
			</div>

</nav>