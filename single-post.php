<?php
    include 'set-fav.php';
    /* Checks if a post wants to be favorited */
    if($_GET['fav'] == true && isset($_COOKIE['user'])) {
        setFavPost($_GET['id']);
    }

?>

<!DOCTYPE  html>
<html>
<head>
     <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
        include "includes/css.inc.php"; 
        include "includes/db_config.inc.php"; 
        $postsDB = new PostsGateway($connection);
        $imagesDB = new ImagesGateway($connection);
    ?>
</head>
<script type="text/javascript"> </script>

<body>
    <?php include "includes/header.inc.php";?>
    <main class="container">
        <div class="row">
            <?php include "includes/left.inc.php"; ?>
               <div class="col-md-10">
                   <?php
                   /* Displays either a confirmation that the post was added or if it already exists */
                    if($_GET['fav'] == true && isset($_COOKIE['user'])) {
                        echo '<div class="alert alert-info fade in" alert.style.display="none" role="alert">';
                        echo 'Added Post to Favorites</div>';
                    } else if ($_GET['dup'] == true) {
                        echo '<div class="alert alert-warning fade in" alert.style.display="none" role="alert">';
                        echo 'Post is already in favorites list</div>';
                    } else if ($_GET['fav'] == true && !isset($_COOKIE['user'])) {
                        echo '<div class="alert alert-warning fade in" alert.style.display="none" role="alert">';
                        echo 'You must be logged in to favorite posts</div>';
                    }
                    echo '<div class="col-md-8">';
                            /* Displays a single post */
                            $posts = $postsDB->findByNonPrimaryID("PostID",$_GET["id"]);
                            
                            foreach($posts as $record){
                                    echo '<img class="img-responsive" src="images/medium/'.$record["Path"].'" alt="'.$record["Title"].'"/><p>'.$record["Message"].'</p>';
                                    echo '</div>';
                                    echo '<div class ="col-md-4">';
                                    echo '<h2>'.$record['Title'].'</h2><div class="panel panel-default"><div class="panel-body"><ul class="details-list">';
                                    echo '<li class="list-group-item">By: <a href="single-user.php?id='.$record["UserID"].'">'.$record["FirstName"].' '.$record["LastName"].'</a></li>';
                                    $date = strtotime($record['PostTime']);
                                    $format = date('Y-m-d', $date);
                                    echo '<li class="list-group-item">Posted on: '.$format.'</a></li></ul></div></div>';
                                    
                                 }
                        ?>
                        <!-- taken from labs -->
                            <div class="btn-group btn-group-justified" roll="group">
                                <div class="btn-group" roll="group">
                                    <?php
                                        echo "<a href='single-post.php?id=" . $_GET['id']. "&fav=true'>";
                                        echo '<button class ="btn btn-default" type="button"><span class="glyphicon glyphicon-heart"></span> Add to Favorites</button></a>';
                                    ?>
                                    <script type='text/javascript'>
                                        setTimeout(function() {
                                            $('.alert').fadeOut(400) 
                                        }, 3000);
                                    </script>
                                </div>
                            </div>
                            <div class="panel panel-default">
                            <h3>Related Pictures</h3>
                            <?php
                                
                                $images = $imagesDB->findByNonPrimaryID("PostImages",$_GET["id"]);
                                
                                foreach($images as $record){
                                    echo '<img class="img-responsive" src="images/medium/'.$record["Path"].'" alt="'.$record["Title"].'"/>';
                                }
                                
                            ?>
                        </div>
                    </div>
        </div>
    </main>
    <?php 
        include "includes/footer.inc.php";
    ?>
    <script>

        
        $('.panel img').mouseenter(function(e){
           
            var source = $(this).attr('src');
            //console.log(source)
            var newImg = source.replace("small", "medium");
            //console.log(newImg)
            hor= e.pageX - 10;
            ver = e.pageY - 100;
            
            $('<div id="preview" style = "position: absolute; padding: 10px 10px 0 10px; display: none;	background-color: #424242;"><img src="'+newImg+'"></div>').appendTo(".panel");
            $("#preview").css({top: ver, left: hor, display : "inline"});
            
        });
        
        $('.panel img').mouseleave(function(e){
           $('#preview').remove();
            
        });
        
        $('.panel img').mousemove(function(e){
           
            hor= e.pageX - 10;
            ver = e.pageY - 100;
            $("#preview").css({top: ver, left: hor, display : "inline"});
            
        });
        </script>
</body>

</html>
