<?php
    include 'set-fav.php';
    /* Checks the query string if there was a request to remove something from the favorites list */
    if($_GET['del'] == true) {
        if(isset($_GET['postID'])) {
            removeFavPost($_GET['postID']);
        } else if (isset($_GET['imgID'])) {
            removeFavImg($_GET['imgID']);
        }
        
    }
    /* Checks the query string if there was a request to remove everything from the favorites list */
    if($_GET['delAll'] == true) {
        removeFavAll();
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
        include "includes/css.inc.php"; 
        include "includes/db_config.inc.php";
        $db = new PostsGateway($connection);
        $db2 = new ImagesGateway($connection);
        /* Detects if a user session is set, or redirects to login. */
    if(!isset($_COOKIE['user'])){
        setCookie('error', 'login', time()+2);
        header('Location: login.php');
    }     
    ?>
    <!--<script src="js/bootstrap.js"></script>-->
    <script src="js/jquery-3.3.1.min.js"></script>
</head>
<body>
    
    
    
    <?php //taken from labs 
        include "includes/header.inc.php"; 
    ?>
    <div class="container">
        <div class='panel panel-info'>
            <div class="panel panel-heading"><h4>Favorite Posts</h4></div>
            <div class='panel-body'>
                <?php
                    /* Gets the favorite list and displays the correct posts that are saved */
                    $result = $db->findViaJoin('i');
                    $fav = unserialize($_COOKIE['fav']);
                    $size = sizeof($fav);
                    foreach($result as $post) {
                        for($i=0;$i<$size;$i++) {
                            if($fav[$i][0] == 'post') {
                                if($fav[$i][1] == $post['ImageID']) {
                                    echo '<div class="row">';
                                    echo '<div class="col-md-1">';
                                    echo '<img class="img-responsive" src="images/square-small/' . $post['Path'] . '"/></div>';
                                    echo '<div class="col-md-6"><h3>' . $fav[$i][2] . '</h3></div>';
                                    echo '<div class="col-md-5"><span class="pull-right"><a href="show-fav.php?postID='. $fav[$i][3] . '&del=true">';
                                    echo '<button class ="btn btn-warning" type="button">Remove</button></a></span></div>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                    echo '<div class="col-md-12"><h5>';
                    echo '<a href="show-fav.php?delAll=true">';
                    echo '<button class ="btn btn-danger" type="button">Remove All</button></a>'; 
                    echo '</h5></div>';
                ?>
            </div>
            
            <div class="panel panel-heading"><h4>Favorite Images</h4></div>
            
            <div class='panel-body'>
                <?php
                    /* Gets the favorite list and displays the correct images that are saved */
                    $resultImg = $db2->findAll();
                    $fav = unserialize($_COOKIE['fav']);
                    $size = sizeof($fav);
                    foreach($resultImg as $img) {
                        for($i=0;$i<$size;$i++) {
                            if($fav[$i][0] == 'img') {
                                if($fav[$i][3] == $img['ImageID']) {
                                    echo '<div class="row">';
                                    echo '<div class="col-md-1">';
                                    echo '<img class="img-responsive" src="images/square-small/' . $fav[$i][1] . '"/></div>';
                                    echo '<div class="col-md-6"><h3>' . $fav[$i][2] . '</h3></div>';
                                    echo '<div class="col-md-5"><span class="pull-right"><a href="show-fav.php?imgID='. $fav[$i][3] . '&del=true">';
                                    echo '<button class ="btn btn-warning" type="button">Remove</button></a></span></div>';
                                    echo '</div>';
                                }
                            }
                        }
                    }
                    echo "<div class='col-md-12'><h5>";
                    echo '<a href="show-fav.php?delAll=true">';
                    echo '<button class ="btn btn-danger" type="button">Remove All</button></a>'; 
                    echo '</h5></div>';
                ?>
                
                <div class='col-md-12'><h5>
                    <button class ="btn btn-info" type="button" data-toggle="modal" data-target="#myModal">Print Favorites</button></a> 
                </h5></div>
                
                
                
            </div>
        </div>
            
            
            
    </div>
    
    <!--</div>-->
    
    <?php //taken from labs 
        include "includes/footer.inc.php"; 
        include "includes/viewModal.inc.php"?>
    
    
</body>

</html>