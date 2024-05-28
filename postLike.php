<?php // <--- do NOT put anything before this PHP tag
// this php file will have no HTML

	include('Functions.php');
	include('custom_functions/Database.php');
	
	$post_id = $_GET['PostID'];
	$redirect = $_GET['Redirect'];
	update_likes($post_id);
	redirect($redirect);
?>