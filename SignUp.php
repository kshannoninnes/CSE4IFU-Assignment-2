<!DOCTYPE html>
<html lang="en">
    <?php 
        $page_title = "Sign Up";
        include('Header.php');
    ?>
    <body>
        <?php include('NavBar.php'); ?>
        <div id="page-content">

            <div id="signup-content" class="main-content">
                <div class="centered-div">
                    <?php 
                        if(strlen(getCookieMessage()) > 0)
                        {
                            echo "<h4 class='error-message'>$cookieMessage</h4>"      ;                      
                        }
                    ?>
                    <form method = "POST" action = "AddUser.php" class="input-form">
                        <div class="credential-input-row">
                            <input autofocus class="credential-input-field" type="text" placeholder="Username" size="50" name = "Username" required>
                        </div>
                        <div class="credential-input-row">
                            <input class="credential-input-field" type="text" placeholder="First Name" size="50" name = "FirstName" required>
                        </div>
                        <div class="credential-input-row">
                            <input class="credential-input-field" type="text" placeholder="Last Name" size="50" name = "LastName" required>
                        </div>
                        <div class="credential-input-row">
                            <input class="credential-input-field" type="text" placeholder="Short Tag" size="50" name = "ShortTag">
                        </div>
                        <div class="form-button-row">
                            <button type="submit" class="custom-button">Sign Up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php include "Footer.php"; ?>
    </body>
</html>