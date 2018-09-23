<!DOCTYPE html>
<html>
<head>
    <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
        include "includes/css.inc.php"; 
        include "includes/db_config.inc.php"; ?>
</head>
<body>
    
    <?php //taken from labs 
        include "includes/header.inc.php";
    ?>
    <div class="container">
        <div class='jumbotron'>
            <div class='row'>
                <form action="make-session.php" method="post" role="login">
                    <div class="form-group">
                        <!-- Creates a login page for the user to login -->
                        <?php 
                            #Checks of there are errors being sent in via cookies
                            if(isset($_COOKIE['error']) && $_COOKIE['error'] == 'user') {
                                echo '<div class="alert alert-danger fade in" role="alert">';
                                echo 'User not found</div>';
                            } else if(isset($_COOKIE['error']) && $_COOKIE['error'] == 'login') {
                                echo '<div class="alert alert-warning fade in" role="alert">';
                                echo 'Please login to access your account</div>';
                            }
                        ?>
                        <label for='user'>Username</label>
                        <input type='text' name='user' class='form-control'>
                    </div>
                    <div class="form-group">
                        <?php
                            #Checks if there is a password error
                            if(isset($_COOKIE['error']) && $_COOKIE['error'] == 'password') {
                                echo '<div class="alert alert-danger fade in" role="alert">';
                                echo 'Incorrect Password</div>';
                            }
                        ?>
                        <script type='text/javascript'>
                            /* Fades out the alert status */
                            setTimeout(function() {
                                $('.alert').fadeOut(400)
                            }, 3000 );
                        </script>
                        <label for='pword'>Password</label>
                        <input type='password' name='pword' class='form-control'>
                    </div>
                    <input type='submit' value='Login' class='form-control'>
                    
                </form>
            </div>
        </div>
    </div>
    <?php //taken from labs 
        include "includes/footer.inc.php"; ?>
</body>

</html>