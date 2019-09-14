<?php
$title = "Photo gallery";
include "includes/header.php"
?>
<div id="demo" class="carousel slide" data-ride="carousel" data-pause="false">

	<!-- Indicators -->
	<ul class="carousel-indicators">
		<li data-target="#demo" data-slide-to="0" class="active"></li>
		<li data-target="#demo" data-slide-to="1"></li>
		<li data-target="#demo" data-slide-to="2"></li>
	</ul>

	<!-- The slideshow -->
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img class = "center" src="img/1.jpg" alt="Screenshot showing equation in LaTeX code and rendered as SVG.">
		</div>
		<div class="carousel-item">
			<img class = "center" src="img/2.jpg" alt="Screenshot showing equation in LaTeX code and rendered as SVG.">
		</div>
		<div class="carousel-item">
			<img class = "center" src="img/3.jpg" alt="Screenshot showing equation in LaTeX code and rendered as SVG.">
		</div>
	</div>

	<!-- Left and right controls -->
		<a class="carousel-control-prev" aria-label = "previous slide" role = "button" href="#demo" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden = "true"></span>
	</a>
	<a class="carousel-control-next" aria-label = "next slide" role = "button" href="#demo" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden = "true"></span>
	</a>

</div>
<?php
include "includes/footer.php"
?>