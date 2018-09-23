<!DOCTYPE html>
<html>
<head>
    <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
        include "includes/css.inc.php"; 
        include "includes/db_config.inc.php";
        $db = new UsersGateway($connection);
        /* Detects if a user session is set, or redirects to login. */
    if(!isset($_COOKIE['user'])){
        setCookie('error', 'login', time()+2);
        header('Location: login.php');
    }     
    ?>
</head>
<body>
    
    <?php //taken from labs 
        include "includes/header.inc.php"; 
    ?>
    <div class="container">
        <div class='jumbotron'>
            <div class='row'>
                <?php
                /* Displays information about the user logged in */
                    $result = $db->findViaJoin('u');
                    foreach ($result as $profile) {
                        if($profile['UserName'] == $_COOKIE['user']) {
                            echo '<div class="col-md-3"><h3>' . $profile['FirstName'] . ' ' . $profile['LastName'] . '</h3><br></div>';
                            echo '<div class="col-md-9"><h5>Address: ' . $profile['Address'] . ', ';
                            echo $profile['City'] . ', ';
                            echo $profile['Region'] . ', ';
                            echo $profile['Country'] . '</h5><br>';
                            echo 'Postal Code: ' . $profile['Postal'] . '<br>';
                            echo 'Phone: ' . $profile['Phone'] . ', ';
                            echo 'Email: ' . $profile['Email'] . '</div>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php //taken from labs 
        include "includes/footer.inc.php"; ?>
</body>

</html>