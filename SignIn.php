<!DOCTYPE html>
<html lang="en">
    <?php 
        $page_title = "Sign In";
        include('Header.php');
    ?>
    <body>
        <?php include('NavBar.php'); ?>
        <div id="page-content">

            <div id="signin-content" class="main-content">
                <div class="centered-div">
                    <?php 
                        if(strlen(getCookieMessage()) > 0)
                        {
                            echo "<h4 class='error-message'>$cookieMessage</h4>"      ;                      
                        }
                    ?>
                    <form method = "POST" action = "LogInUser.php" class="input-form">
                        <div class="credential-input-row">
                            <input autofocus class="credential-input-field" type="text" placeholder="Username" name="Username" size="50" required>
                        </div>
                        <div class="form-button-row">
                            <button type="submit" class="custom-button">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    <?php include "Footer.php"; ?>
    </body>
</html>