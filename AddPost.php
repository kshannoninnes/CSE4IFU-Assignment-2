<?php // <--- do NOT put anything before this PHP tag

// this php file will have no HTML

	include('Functions.php');
	include('custom_functions/Database.php');
	include('custom_functions/Time.php');
	include('custom_functions/Error.php');

	$username = getCookieUser();
	$topic = $_GET['Topic'];

	$user_id = get_user_id($username);
	$post = $_POST['Post'];
	$now = get_current_timestamp();
	$topic_id = get_topic_id($topic);

	if(! $user_id)
	{
		abort_and_redirect("Problem retreiving valid user, speak to your administrator", "Forum.php?Topic=$topic");
	}

	if(! $topic_id)
	{
		abort_and_redirect("Problem retreiving valid topic, speak to your administrator", "Forum.php?Topic=$topic");
	}

	insert_post($user_id, $post, $now, $topic_id);
	$num_pages = count_posts_in_topic($topic_id);
	$offset = ($num_pages - 1) / 10;

	redirect("Forum.php?Topic=$topic");
?>