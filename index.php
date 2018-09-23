<!DOCTYPE html>
<html>
<head>
    <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
        include "includes/css.inc.php"; ?>
</head>
<body>
    
    <?php //taken from labs 
        include "includes/header.inc.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="card">
                        <img class="img-responsive" src=/images/misc/home_countries.jpg alt="Home countries">
                        <div class="panel panel-default">
                            <div class="list-group-item"><h3>Countries</h3>
                                <p>See all countries for which we have images</p>
                            </div>
                            <div class="list-group-item">
                                <p><a href="browse-countries.php">View Countries</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <img class="img-responsive" src=/images/misc/home_images.jpg alt="Home countries">
                        <div class="panel panel-default">
                            <div class="list-group-item"><h3>Images</h3>
                                <p>See all of our travel images</p>
                            </div>
                            <div class="list-group-item">
                                <p><a href="browse-images.php">View Images</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                
               <div class="col-md-4">
                    <div class="card">
                       <img class="img-responsive" src=/images/misc/home_users.jpg alt="Home countries">
                        <div class="panel panel-default">
                            <div class="list-group-item"><h3>Users</h3>
                                <p>See information of contributing users</p>
                            </div>
                            <div class="list-group-item">
                                <p><a href="browse-users.php">View Users</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php //taken from labs 
        include "includes/footer.inc.php"; ?>
</body>

</html>