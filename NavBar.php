<?php
    function populateNavBar()
    {
        global $cookieUser;
        $current_page = urlencode(basename($_SERVER['REQUEST_URI']));

        echo '<ul id="nav-bar">';
        echo '<li class="nav-button ' .  setActiveClass("Homepage") . '"><a href="Homepage.php">Home</a></li>';
        echo '<li class="nav-button ' .  setActiveClass("Topics") . '"><a href="Topics.php">Topics</a></li>';

        if($cookieUser == '')
        {
            echo '<li class="nav-button ' .  setActiveClass("SignIn") . '"><a href="SignIn.php?">Sign In</a></li>';
            echo '<li class="nav-button ' .  setActiveClass("SignUp") . '"><a href="SignUp.php">Sign Up</a></li>';
        }
        else
        {
            echo '<li class="nav-button ' .  setActiveClass("SignOut") . '"><a href="LogOutUser.php?Page=' . $current_page . '">Sign Out</a></li>';
        }

        echo '</ul>';
    }
?>

<div id="header">
    <div id="page-name"> <h2><?php echo "<a href='Homepage.php'>CSE4IFU</a> - $page_title"; ?></h2> </div>
    <?=populateNavBar()?>
    <div id="filler"></div>
</div>