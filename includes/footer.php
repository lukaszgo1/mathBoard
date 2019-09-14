<footer class="page-footer font-small fixed-bottom footer-dark">
<div class="footer-copyright text-center text-dark bg-secondary py-3"> <small> © 2019 Łukasz Golonka,
sources are <a class="text-light" href="https://github.com/lukaszgo1/mathBoard"><span class = "gitHubLogo"></span>available on GitHub</a></small>
</div>
</footer>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
<?php
$currentPage= basename($_SERVER["SCRIPT_NAME"]);
switch ($currentPage):
	case "index.php":
	echo '<script src="js/canvas.js"></script>';
	break;
	case "register.php":
	echo '<script src="js/registerValidation.js"></script>';
	break;
	case "login.php":
	case "chooseBoard.php":
	case "newBoard.php":
	echo '<script src="js/fieldsValidation.js"></script>';
	break;
	endswitch;
?>
</body>
</html>