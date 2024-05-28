<?php
    include('Functions.php');

    $cookieMessage = getCookieMessage();
    $cookieUser = getCookieUser();

    function setActiveClass($button_redirects_to)
    {
        $request_uri = strtok(basename($_SERVER['REQUEST_URI'], ".php"), ".");

        /* Highlight the button if it's the topics button and we're in the topic sub-forum,
         * or if the button redirects to the current page
         */
        $highlighted_button = (strpos($request_uri, "Forum") === 0 and $button_redirects_to == "Topics") || $button_redirects_to == $request_uri;

        if($highlighted_button)
        {
            return 'highlighted';
        }
        # If none of the above, the button is not highlighted
        else
        {
            return 'unhighlighted';
        }
    }
?>

<title><?php echo "$page_title"; ?></title>
<link rel="stylesheet" type="text/css" href="styles/styles.css">
<meta charset="UTF-8">		<!-- For emojis -->
