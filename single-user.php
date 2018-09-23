<!DOCTYPE html>
<html>
<head>
    <title>Assign 1 (Winter 2018)</title>
    <?php //taken from labs 
        include "includes/css.inc.php"; 
        include "includes/db_config.inc.php";
        $usersDB = new UsersGateway($connection);
        $imagesDB = new ImagesGateway($connection);?>
        <script type="text/javascript">
   
        function imgHover(id){
            id.style.height = "150px";
            id.style.width = "150px";

        }

        function imgOut(id) {
            id.style.height = "75px";
            id.style.width = "75px";;
           
        }
        
     </script>
</head>
<body>
    
    <?php //taken from labs 
        include "includes/header.inc.php"; ?>
    <div class="container">
        <div class="jumbotron">
            <?php 
                /* Displays a single user */
                $record = $usersDB->findByID($_GET["id"]);
                $fname = $record["FirstName"];
                $lname = $record["LastName"];
                echo "<h2>".$record["FirstName"]." ".$record["LastName"]."</h2>";
                echo "<p>".$record["Address"]."<p>";
                echo "<p>".$record["City"].", ".$record["Region"].", ".$record["Postal"].", ".$record["Country"]."<p>";
                echo "<p>".$record["Phone"]."<p>";
                echo "<p>".$record["Email"]."<p></div>";
                echo "<div class='panel panel-info'> <div class='panel-heading'>Images from ".$record["FirstName"]." ".$record["LastName"]."</div><div class='panel-body'><div class='row'>";
                $images = $imagesDB->findByNonPrimaryID("UserID",$_GET["id"]);
                
                foreach($images as $image){
                        echo '<div class="col-md-1"> <a href="single-image.php?id='.$image["ImageID"].'" class="img-responsive"><img onmouseover="imgHover(this)" onmouseout="imgOut(this)" src="/images/square-small/'.$image["Path"].'"></a></div>';
                        
                    }
                    echo "</div></div></div>";

            echo "</div>";
            //taken from labs 
            include "includes/footer.inc.php"; ?>
</body>

</html>