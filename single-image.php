<?php
    include 'set-fav.php';
    /* Checks if a image wants to be favorited */
    if($_GET['fav'] == true && isset($_COOKIE['user'])) {
        setFavImg($_GET['id']);
    }

?>

<!DOCTYPE  html>
<html>
<head>
     <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
        include "includes/css.inc.php"; 
        include "includes/db_config.inc.php"; 
        $imagesDB = new ImagesGateway($connection);
        ?>
        <style>
       #map {
        height: 250px;
        width: 100%;
       }
    </style>
</head>

<body>
    <?php include "includes/header.inc.php";?>
    <main class="container">
        <div class="row">
            <?php include "includes/left.inc.php"; ?>
               <div class="col-md-10">
                   <?php
                   /* Displays either a confirmation that the image was added or if it already exists */
                   if($_GET['fav'] == true && isset($_COOKIE['user'])) {
                        echo '<div class="alert alert-info fade in" alert.style.display="none" role="alert">';
                        echo 'Added Image to Favorites</div>';
                    } else if ($_GET['dup'] == true) {
                        echo '<div class="alert alert-warning fade in" alert.style.display="none" role="alert">';
                        echo 'Image is already in favorites list</div>';
                    } else if ($_GET['fav'] == true && !isset($_COOKIE['user'])) {
                        echo '<div class="alert alert-warning fade in" alert.style.display="none" role="alert">';
                        echo 'You must be logged in to favorite images</div>';
                    }
                    echo '<div class="col-md-8">';
                          /* Displays a single image */
                            
                            $image = $imagesDB->findByNonPrimaryID("ImageID",$_GET["id"]);
                            
                                foreach($image as $record){
                                    echo '<img class="img-responsive" src="images/medium/'.$record["Path"].'" alt="'.$record["Title"].'"/><p>'.$record["Description"].'</p>';
                                    echo '</div>';
                                    echo '<div class ="col-md-4">';
                                    echo '<h2>'.$record[Title].'</h2><div class="panel panel-default"><div class="panel-body"><ul class="details-list">';
                                    echo '<li class="list-group-item">By: <a href="single-user.php?id='.$record["UserID"].'">'.$record["FirstName"].' '.$record["LastName"].'</a></li>';
                                    echo '<li class="list-group-item">Country : <a href="single-country.php?id='.$record["CountryCodeISO"].'">'.$record["CountryName"].'</a></li>';
                                    echo '<li class="list-group-item">City: '.$record["AsciiName"].'</a></li></ul></div></div>';
                                    echo '<div id="map"></div>';
                                    echo '<script>';
                                    echo 'function initMap() {';
                                    echo 'var uluru = {lat:'.$record["Latitude"].', lng:'.$record["Longitude"].'};';
                                        echo 'var map = new google.maps.Map(document.getElementById("map"), { zoom: 4, center: uluru });';
                                        echo 'var marker = new google.maps.Marker({position: uluru, map: map });}';
                                    echo '</script>';
                                    echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuI02Z5KzIBl3jXFKnqK32QjOpWxpy5II&callback=initMap"></script>';
                                 }
                            
                        ?>
                        <!-- taken from labs -->
                            <div class="btn-group btn-group-justified" roll="group">
                                <div class="btn-group" roll="group">
                                    <?php 
                                        echo "<a href='single-image.php?id=" . $_GET['id']. "&fav=true'>";
                                        echo '<button class ="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Favorites</button></a>';
                                    ?>
                                    <script type='text/javascript'>
                                        setTimeout(function() {
                                            $('.alert').fadeOut(400) 
                                        }, 3000 );
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </main>
    <?php 
        include "includes/footer.inc.php";
    ?>
</body>

</html>
