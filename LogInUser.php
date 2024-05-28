<?php // <--- do NOT put anything before this PHP tag

// this php file will have no HTML

	include('Functions.php');
	include('custom_functions/Database.php');

	if(isset($_POST['Username']))
	{
		$username = $_POST['Username'];
		if(user_exists($username))
		{
			setCookieUser($username);
			setcookie("SignInSuccessful", true);
			setCookieMessage("Welcome back $username!");
			redirect("Homepage.php");
		}
		else
		{
			setCookieMessage("Username not found");
			redirect("SignIn.php");
		}
	}
?>
