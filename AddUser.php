<?php // <--- do NOT put anything before this PHP tag

// this php file will have no HTML

	include('Functions.php');
	include('custom_functions/Database.php');
	include('custom_functions/Error.php');
	
	if(isset($_POST['Username']))
	{
		$username = trim($_POST['Username']);
		$first_name = trim($_POST['FirstName']);
		$last_name = trim($_POST['LastName']);
		$short_tag = trim($_POST['ShortTag']);

		if(user_exists($username))
		{
			abort_and_redirect("Username '$username' already exists, please try again.", 'SignUp.php');
		}
		else
		{
			insert_user($username, $first_name, $last_name, $short_tag);

			setcookie("RegistrationSuccessful", true);
			setCookieMessage("Registration successful. You may now sign in.");

			redirect("Homepage.php");
		}
	}
	else
	{
		echo "Username not provided";
	}
?>