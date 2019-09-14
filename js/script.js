/// mark current item in the nav bar. Using aria-current is sufficient because it is underlined visually with a CSS selector.
currentHref = window.location.pathname.substring(window.location.pathname.lastIndexOf('/')+1);
if (currentHref.length == 0) // Main page
	currentHref = "index.php";
var activeLink = $('.collapse a[href="'+currentHref+'"]');
activeLink.attr('aria-current', 'true');
// Hide all Font Awesome icons from screen reader users.
$(".fas").attr('aria-hidden', 'true');
