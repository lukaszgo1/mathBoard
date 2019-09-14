<?php
$title = "Math board - welcome!";
include "includes/header.php"
?>
<canvas id="canvas" aria-label = "Animation with the text 'Math Board' moving from left to right." role = "img" >Your browser does not support the canvas element.</canvas>
<main>
<h1 class = "h2"> Welcome!</h1>
<article>
<h2>What is Math Board?</h2>
<p>Math Board is essentially a classical blackboard in your web browser. To be able to write mathematical content on it you need to know LaTeX, or at least some commands used in LaTeX math mode. If you want to learn it I personally recommend reading <a href = "https://en.wikibooks.org/wiki/LaTeX">LaTeX book on Wikibooks</a>.</p>
<h2>How it works?</h2>
<p>There are two modes in which Math Board is able to operate:</p>
<ul>
<li>If you are logged in you can create new boards, and then edit them using LaTeX syntacs.</li>
<li>If you want to share your board with others they do not have to create account - you should simply give them name of your board, and they would be able to open it using appropriate option from the menu.</li>
</ul>
<p>Board can be opened in two modes: as a raw LaTeX source and in a SVG form suitable for people who just want to read math without prior LaTeX knowledge. The engine responsible for conversion from source form to a graphical presentation is called <a href = "https://www.mathjax.org/">MathJax</a>, and if something isn't rendering as you would expect it to be it is worth contacting MathJax developers.</p>
<p>The best Math Board feature is the fact that it is updating almost in real time, so you can open a rendered version of your board on a projector, start editing it from a second machine and your changes would be present on the projector. Isn't that great?</p>
<p>I hope you would find my little page useful!</p>
</article>
<?php
include "includes/footer.php"
?>