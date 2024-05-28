<?php // <--- do NOT put anything before this PHP tag

// this php file will have no HTML

	include('Functions.php');
	include('custom_functions/Database.php');
	include('custom_functions/Time.php');
	include('custom_functions/Error.php');

	if(isset($_POST['TopicName']))
	{
		$topic = trim($_POST['TopicName']); 
		$user_id = get_user_id(getCookieUser());
		$now = get_current_timestamp();

		if(strlen($topic) === 0) 
		{ 
			abort_and_redirect("Topic name cannot be blank", "Topics.php"); 
		}

		if(topic_exists($topic)) 
		{ 
			abort_and_redirect("Topic already exists", "Topics.php"); 
		}

		if(! $user_id) 
		{ 
			abort_and_redirect("Problem retreiving valid user, speak to your administrator", "Topics.php"); 
		}
			
		insert_topic($user_id, $now, $topic);	
		redirect("Topics.php");
	}

?>