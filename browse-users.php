<!DOCTYPE html>
<html>
<head>
    <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
        include "includes/css.inc.php"; 
        include "includes/db_config.inc.php";
        $usersDB = new UsersGateway($connection);?>
</head>
<body>
    
    <?php //taken from labs 
        include "includes/header.inc.php"; ?>
    <div class="container">
        <div class='panel panel-info'>
            <div class="panel panel-heading">Users</div>
                <div class='panel-body'>
                    <div class='row'>
                        <?php
                            #Connects to the user database to output a list of users
                            $users = $usersDB->findAllSorted($asc);
                
                             foreach($users as $record){
                                #didn't use utfencode() because of character issues.
                                echo "<div class='col-md-3'><a href='single-user.php?id=".$record["UserID"]."'>".$record["FirstName"]." ".$record["LastName"]."</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php //taken from labs 
        include "includes/footer.inc.php"; ?>
</body>

</html>