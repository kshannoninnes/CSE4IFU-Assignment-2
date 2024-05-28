<?php // <--- do NOT put anything before this PHP tag

// this php file will have no HTML

	include('Functions.php');

	$redirect_uri = urldecode($_GET['Page']);

	deletecookie("CookieUser");
	redirect($redirect_uri);
?>
