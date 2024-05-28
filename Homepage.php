<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        $page_title = "Home";
        include('Header.php');
        include('custom_functions/Database.php');
    ?>
</head>
<body>
    <?php include('NavBar.php'); ?>
    <div id="page-content">

        <div class="main-content">
            <?php
                if(isset($_COOKIE['RegistrationSuccessful']))
                {
                    deletecookie('RegistrationSuccessful');
                    echo "<div class='centered-div'>";

                    // https://commons.wikimedia.org/wiki/File:Eo_circle_green_checkmark.svg
                    // Emoji One, CC BY-SA 4.0 <https://creativecommons.org/licenses/by-sa/4.0>, via Wikimedia Commons
                    echo "<img id='registration-success-image' src='images/checkmark_in_circle.svg' height='150px' width=auto>";
                    echo "<p id='registration-success-message'>" . $cookieMessage . "</p>";
                    echo "</div>";
                }
                elseif(isset($_COOKIE['SignInSuccessful']))
                {
                    deletecookie('SignInSuccessful');
                    echo "<div class='centered-div'>";

                    // https://commons.wikimedia.org/wiki/File:Cat_Laptop_-_Idil_Keysan_-_Wikimedia_Giphy_stickers_2019.gif
                    // Idil Keysan for the Wikimedia Foundation, CC BY-SA 4.0 <https://creativecommons.org/licenses/by-sa/4.0>, via Wikimedia Commons
                    echo "<img id='sign-in-success-image' src='images/cat-typing.gif'>";
                    echo "<p id='sign-in-success-message'>" . $cookieMessage . "</p>";

                    echo "</div>";
                }
                else
                {
                    $top_post = get_top_post();
                    echo "<div id='main-homepage'>";
                    echo "<div id='cta-slider'>";
                    echo "<div id='headlines'>";
                    echo "<h1 id='h1-copy'>Communication Done Right</h1>";
                    echo "<h2 id='body-copy'>Zero adverts.<br>Zero tracking<br>All Forum.</h2>";
                    if(getCookieUser() == '')
                    {
                        echo "<form action='SignUp.php'><button id='sign-up-button' type='submit'>Sign Up Now</button></form>";
                    }
                    echo "</div>";
                    echo "</div>";

                    if($top_post) 
                    {
                        echo "<div id='popular-post'>";
                        echo "<h3 id='trending-header'>Trending Post</h3>";
                        echo "<div id='post-content'>";
                        echo $top_post['Post'];
                        echo "</div>";
                        echo "<div id='post-author'>";
                        echo $top_post['UserName'];
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                }
            ?>
        </div>

    </div>
    <?php include "Footer.php"; ?>
</body>
</html>
